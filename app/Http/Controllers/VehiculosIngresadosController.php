<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vehiculo;
use App\Models\Registro;
use App\Models\Tarifa;
use App\Models\Suscipcione;
use App\Models\Empresa;
use App\Models\Servicio;
use App\Models\Impresora;


use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

use Mike42\Escpos\Printer;


use Milon\Barcode\DNS1D;
use PDF;



class VehiculosIngresadosController extends Controller
{


    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
    }


    public function index()
    {
        $registros = DB::table('ingresos_vista')
                    ->orderBy('entrada', 'desc')
                    ->paginate(10);

                    
    
        return view('vehiculos_ingresados.ingresos', compact('registros'));
    }
    
    
    public function filtroPlaca(Request $request)
    {
        // Obtener el valor de la placa a buscar
        $placa = $request->input('placa');
    
        // Consultar los vehículos ingresados que coincidan con la placa
        $registros = DB::table('ingresos_vista')
                    ->orderBy('entrada', 'desc')
                    ->Where('ingresos_vista.placa','like','%'.$placa.'%')->get();

    
        // Renderizar la vista con los resultados de la búsqueda
        return view('vehiculos_ingresados.tabla_ingresados', ['registros' => $registros])->render();
    }

    public function create()
    {
        //Trae todas las tarifas, para crear y sacar la información de tipo de vehiculo
        $tarifas = Tarifa::all();
        $tiposVehiculo = Tarifa::select('tipo_vehiculo')->distinct()->get();
        
        // Obtener la lista de servicios disponibles
        $servicios = Servicio::all();

        // Enviar los datos a la vista de create en las variables
        return view('vehiculos_ingresados.ingresos_create', compact('tiposVehiculo', 'tarifas', 'servicios'));
    }
    
    
      

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'placa' => 'required|string|min:6|max:6', // Establecemos el mínimo y máximo a 6 caracteres
            'tipo_vehiculo' => 'required|string|max:255',
            'servicios' => 'nullable|array',
            'servicios.*' => 'nullable|integer|exists:servicios,id',
        ], ['placa.min' => 'La placa debe tener 6 caracteres']); // Personalizamos el mensaje de error
    
        // Buscar el vehículo correspondiente a la placa
        $vehiculo = Vehiculo::where('placa', $request->placa)->first();
        $empresa = Empresa::first();

        if (!$empresa) {
            session()->flash('error', 'Empresa no creada');
            return redirect()->back();
        }

        //Verificar si esxiste impresoras activas
        $impresoras = Impresora::all();
        if ($impresoras->count() === 0) {
            return redirect()->back()->with('error', 'No se encontraron impresoras.');
        }
        $impresoras_activas = Impresora::where('activo', 1)->count();

        if($impresoras_activas === 0){
            return redirect()->back()->with('error', 'No se encontró ninguna impresora activa.');
        }
        
        if($impresoras_activas > 1){
            return redirect()->back()->with('error', 'Existe más de una impresora activa.');
        }
        
        $impresora = Impresora::where('activo', 1)->first();
        // Si el vehículo no existe, crear uno nuevo
        if (!$vehiculo) {
            $vehiculo = new Vehiculo();
            $vehiculo->placa = $request->placa;
            $vehiculo->tipo = $request->tipo_vehiculo;
            $vehiculo->save();
        }
        // Verificar si el vehículo está ubicacion del parqueadero
        if ($vehiculo->ubicacion == 'Dentro') {
            return redirect()->route('vehiculos_no_pagados.index')->with('message', 'Vehiculo en el parqueadero.');
        }
    
        // Actualizar el estado del vehículo a "Dentro"
        $vehiculo->ubicacion = 'Dentro';
        $vehiculo->save();
    
        // Crear el nuevo registro de ingreso
        $ingreso = new Registro();
        $ingreso->vehiculo_id = $vehiculo->id;
        $ingreso->placa = $vehiculo->placa;
        $ingreso->entrada = now();     
        $ingreso->save();
    
        // Guardar los servicios seleccionados en el registro de ingreso
        if ($request->servicios) {
            $ingreso->servicios_solicitados = json_encode($request->servicios);
            $ingreso->save();
        }
        
        
         // Agregamos información de la empresa
        $nombreEmpresa = $empresa->nombre;
        $nit = $empresa->nit;
        $descripcion = $empresa->descripcion;
         //Informacion del regustro
        $id = $ingreso->id;
        $placa = $ingreso->placa;
        $vehiculo = Vehiculo::where('placa', $placa)->first();
        $tipo = $vehiculo->tipo;
        $pagado = $ingreso->pagado;
        $entrada = date('m/d/Y - h:i:s A', strtotime($ingreso->entrada));

        $print = $impresora->nombre;
        $ancho = 576;
        if ($ancho > 576) {
            $ancho = 576;
        }

        // Conectarse a la impresora
        $connector = new WindowsPrintConnector($print);
        $printer = new Printer($connector);
        $printer->initialize();

        // Configurar el ancho de la impresión
        $printer->setPrintWidth($ancho);
         // Imprime los datos
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("TICKET\n\n");
 
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($nombreEmpresa . "\n");
        $printer->text("N.I.T: " . $nit. "\n");
        $printer->text("Ticket N#: " . strval($id) . "\n");
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer->text("Placa: " . $placa . "\n");
        $printer->selectPrintMode(); // Desactivar todos los modos de impresión
        $printer->text("Tipo: " . strval($tipo) . "\n");
        $printer->text("Hora de entrada:\n" . $entrada . "\n");
        $printer->text("\nCodigo de barras: \n");
        $printer->setBarcodeHeight(30);
        $printer->setBarcodeWidth(1);
        $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
        $printer->barcode($placa.$ingreso->id, Printer::BARCODE_CODE39);
        $printer->feed();
 
        $printer->text("\n---------------------\n");
        $printer->text($descripcion);
 
         // Corta el papel
        $printer->cut();
         // Cierra la conexión con la impresora
        $printer->close();
        // Redireccionar a la página de impresión y enviar el ID del registro recién creado como parámetro en la URL
        return redirect()->route('dashboard')->with('message', 'Vehiculo registrado correctamente');
    }
    

    //para imprimir desde la vista, en caso de perdida de ticket
    public function imprimirPDF($id) 
    {
        //Busca los registros correspondientes para el ticket 
        $registro = Registro::find($id);
        $id = $registro->id;
        $placa = $registro->placa;
        $vehiculo = Vehiculo::where('placa', $placa)->first();
        $tipo = $vehiculo->tipo;
        $pagado = $registro->pagado;
        $entrada = date('m/d/Y - h:i:s A', strtotime($registro->entrada));

        //Verificar que solo una impresora esté activa y exista
        if (!Impresora::where('activo', 1)->exists()) {
            return redirect()->back()->with('error', 'No se encontró ninguna impresora activa.');
        }

        $impresora = Impresora::where('activo', 1)->first();

        // Agregamos información de la empresa
        $empresa = Empresa::first();
        $nombreEmpresa = $empresa->nombre;
        $nit = $empresa->nit;
        $descripcion = $empresa->descripcion;
    
        //Genera codigo de barras a partir de la placa en formato c39
        $codigo_barras = DNS1D::getBarcodeHTML($placa.$id, "C39", 1.5   , 30);
    
        $data = [
            'placa' => $placa,
            'tipo' => $tipo,
            'entrada' => $entrada,
            'pagado' => $pagado,
            'codigo_barras' => $codigo_barras,
            'nombreEmpresa' => $nombreEmpresa,
            'nit' => $nit,
            'descripcion' => $descripcion
        ];
        $size = $impresora->tamaño;
        $size = ceil($size * 2.835); 
        $customPaper = array(0, 0, $size, 484);
        //manda los datos a la bista de imprimir
        $pdf = PDF::loadView('vehiculos_ingresados.imprimir', $data)->setPaper($customPaper, 'portrait');
        //Trae los datos de imprimir y descarga el ticket
        //return $pdf->download('ticket_'.$placa.'.pdf');
        return $pdf->stream('ticket_'.$placa.'.pdf');

    }
    
    
    
    
    


}    
