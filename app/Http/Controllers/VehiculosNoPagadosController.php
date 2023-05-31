<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Servicio;
use App\Models\VehiculosNoPagado;
use Carbon\Carbon;
use App\Models\Registro;
use App\Models\Tarifa;
use App\Models\Empresa;





class VehiculosNoPagadosController extends Controller
{
    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
        
    }

    public function index()
    {
        $vehiculosNoPagados = DB::table('vehiculos_no_pagados')->orderByDesc('entrada')->paginate(10);
        $servicios = DB::table('servicios')->pluck('nombre', 'id')->toArray();
        foreach($vehiculosNoPagados as $registro) {
            $servicios_solicitados = json_decode($registro->servicios_solicitados);
            if(is_array($servicios_solicitados)) {
                $registro->servicios_solicitados = implode(', ', array_intersect_key($servicios, array_flip($servicios_solicitados)));
                $registro->num_servicios = count($servicios_solicitados);
            } else {
                $registro->servicios_solicitados = '';
                $registro->num_servicios = 0;
            }
        }
        return view('vehiculos_no_pagados.index', compact('vehiculosNoPagados', 'servicios'));
    }

    public function show($id)
    {
        //Establecer el metodo en español
        setlocale(LC_ALL,"es_ES"); 
        \Carbon\Carbon::setLocale('es'); 
       
        //Se busca el vehiculo por el id, se buscan los servicios y se trae el tipo de tarifa
        $vehiculoNoPagado = VehiculosNoPagado::findOrFail($id);
        $servicios = DB::table('servicios')->pluck('nombre', 'id')->toArray();
        $tarifa = Tarifa::where('tipo_vehiculo', $vehiculoNoPagado->tipo)->first();
        if (!$tarifa) {
            session()->flash('alert', 'No se encontro el tipo de vehiculo en tarifas');
            return redirect()->back();
            
        }

        $servicios_solicitados = json_decode($vehiculoNoPagado->servicios_solicitados);
        $servicios_nombres = is_array($servicios_solicitados) ? array_intersect_key($servicios, array_flip($servicios_solicitados)) : [];
        $num_servicios = count($servicios_nombres);
        
        // Inicializar el total de los precios de los servicios en cero
        $total_servicios = 0;
        $valor_servicio = 0;

        if ($servicios_solicitados) {
            foreach ($servicios_solicitados as $id_servicio) {
                $servicio = Servicio::find($id_servicio);
            if ($servicio) {
                $total_servicios += $servicio->precio;
                }
            }
        }
        
        $valor_servicio += $total_servicios;

        // Configurando tiquete
        $valor_hora = $tarifa->precio_hora;
        $valor_media = $tarifa->precio_media_hora ? $tarifa->precio_media_hora : $valor_hora;
        $valor_fraccion = $tarifa->precio_fraccion_hora ? $tarifa->precio_fraccion_hora : $valor_hora;
        $valor_dia = $valor_hora * 24;

        $hora_entrada = $vehiculoNoPagado->entrada;
        $hora_salida = now();

        $tiempo_transcurrido_en_segundos = strtotime($hora_salida) - strtotime($hora_entrada);
        $minutos_transcurridos = ($tiempo_transcurrido_en_segundos / 60);
        $horas_transcurridas = ceil($minutos_transcurridos / 60);


        if ($minutos_transcurridos < 15) {
            // cobrar fracción de hora si la tarifa lo permite
            $valor_pagar = $valor_fraccion;
        } else if($minutos_transcurridos <= 45 ){

            $media_hora = 1;
            $fraccion_hora = ceil($minutos_transcurridos /15) %2;

            $valor_media_hora = $valor_media * $media_hora;
            $valor_fraccion_hora = $valor_fraccion * $fraccion_hora;
            $valor_pagar = $valor_media_hora + $valor_fraccion_hora;

        }else if ($horas_transcurridas < 24) {
            // calcular media hora y  horas completas
            $minutos_restantes = $minutos_transcurridos % 60; 

            if($minutos_restantes <= 15){
                if($minutos_restantes > 0){
                    $horas_completas = floor($minutos_transcurridos / 60);
                    $fraccion_hora = 1;
                }else{
                    $horas_completas = floor($minutos_transcurridos / 60);
                    $fraccion_hora = 0;
                }              
            }else{
                $fraccion_hora = 0;
                $horas_completas = ceil($minutos_transcurridos / 60);

            }
            // calcular valor a pagar por horas y medias
            $valor_horas_completas = $valor_hora * $horas_completas;
            $valor_fraccion_hora = $valor_fraccion * $fraccion_hora;
            $valor_pagar = $valor_horas_completas + $valor_fraccion_hora;

        } else {
            // cobrar por día completo si la tarifa lo permite
            $dias_transcurridos = floor($horas_transcurridas / 24);
            $minutos_restantes = $minutos_transcurridos % 60;

            if($minutos_restantes <= 15){
                if($minutos_restantes > 0){
                    $horas_completas = (floor($minutos_transcurridos / 60)%24);
                    $fraccion_hora = 1;
                }else{
                    $horas_completas = (floor($minutos_transcurridos / 60)%24);
                    $fraccion_hora = 0;
                }              
            }else{
                $fraccion_hora = 0;
                $horas_completas = (ceil($minutos_transcurridos / 60)%24);

            }

            // calcular valor a pagar por horas y medias
            $valor_dias_completos = $valor_dia * $dias_transcurridos;
            $valor_horas_completas = $valor_hora * $horas_completas;
            $valor_fraccion_hora = $valor_fraccion * $fraccion_hora;

            $valor_pagar = $valor_horas_completas + $valor_fraccion_hora + $valor_dias_completos;
        }

        $valor_servicio_parqueadero = $valor_pagar;

         // Obtener información de la empresa
         $empresa = Empresa::first();
         if (!$empresa) {
             session()->flash('alert', 'Empresa no creada');
             return redirect()->back();
         }
        $iva = $empresa->iva;        

        $valor_iva = 0;
        //Agregar IVA si existe
        if ($empresa->iva == 'Si') {
            $valor_iva = ($valor_servicio_parqueadero + $valor_servicio) * 0.19;
            $valor_pagar += ($valor_servicio + $valor_iva);
        }else {
            $valor_pagar += $valor_servicio;
        }

        $fecha_entrada = Carbon::parse($vehiculoNoPagado->entrada);
        $fecha_actual = Carbon::now();
        $tiempo_transcurrido = $fecha_actual->diffForHumans($fecha_entrada, [
            'parts' => 4,
            'join' => ' - ',
            'short' => true
        ]);
        
        return view('vehiculos_no_pagados.show', compact('vehiculoNoPagado', 'servicios_nombres', 'num_servicios', 'tiempo_transcurrido', 'valor_servicio_parqueadero', 'valor_iva', 'valor_pagar', 'iva', 'valor_servicio'));
    }

    

      

    public function filtroPlacaNoPagado(Request $request)
    {
        $placa = $request->input('placa');
        $vehiculosNoPagados = DB::table('vehiculos_no_pagados')
            ->where('placa', 'like', '%'.$placa.'%')
            ->orderByDesc('entrada')
            ->get();
        $servicios = DB::table('servicios')->pluck('nombre', 'id')->toArray();
        foreach($vehiculosNoPagados as $registro) {
            $servicios_solicitados = json_decode($registro->servicios_solicitados);
            if(is_array($servicios_solicitados)) {
                $registro->servicios_solicitados = implode(', ', array_intersect_key($servicios, array_flip($servicios_solicitados)));
                $registro->num_servicios = count($servicios_solicitados);
            } else {
                $registro->servicios_solicitados = '';
                $registro->num_servicios = 0;
            }
        }
        return view('vehiculos_no_pagados.tabla_no_pagos', compact('vehiculosNoPagados', 'servicios'));
    }

}
