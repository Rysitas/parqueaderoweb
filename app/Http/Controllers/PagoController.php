<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Registro;
use App\Models\Tarifa;
use App\Models\Suscipcione;
use App\Models\Empresa;
use App\Models\Tiquete;
use App\Models\Servicio;
use App\Models\Impresora;
use App\Models\Factura;



use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;

use Mike42\Escpos\Printer;


use Milon\Barcode\DNS1D;
use PDF;



class PagoController extends Controller
{
    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos
        $this->middleware('auth');

    }

    public function index()
    {
        $tiquetes = Tiquete::orderBy('id', 'desc')->paginate(10); // Paginate with 10 records per page

        $data = [];

        foreach ($tiquetes as $tiquete) {
            $hora_entrada = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_entrada));
            $hora_salida = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_salida));
            $horas_transcurridas = strtotime($tiquete->hora_salida) - strtotime($tiquete->hora_entrada);
            $dias = floor($horas_transcurridas / 86400);

            $horas = floor($horas_transcurridas / 3600);
            $minutos = floor(($horas_transcurridas % 3600) / 60);
            $horas_transcurridas = $dias . ' Dias ' .$horas . ' Horas ' . $minutos . ' Minutos';

            $data[] = [
                'tiquete' => $tiquete,
                'hora_entrada' => $hora_entrada,
                'hora_salida' => $hora_salida,
                'horas_transcurridas' => $horas_transcurridas,
            ];
        }

        return view('pagos.index', compact('data', 'tiquetes'));
    }

    
    public function show($id)
    {
        $tiquete = Tiquete::findOrFail($id);

        $hora_entrada = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_entrada));
        $hora_salida = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_salida));
        $horas_transcurridas = strtotime($tiquete->hora_salida) - strtotime($tiquete->hora_entrada);
        $dias = floor($horas_transcurridas / 86400);
        $horas = floor(($horas_transcurridas / 3600) % 24);
        $minutos = floor(($horas_transcurridas % 3600) / 60);
        $horas_transcurridas =  $dias . ' Dias ' . $horas . ' Horas ' . $minutos . ' Minutos';

        $valor_tiempo = $tiquete->valor_tiempo;
        $precios = explode(';', $valor_tiempo);
        $valor_hora = $precios[0];
        $valor_media = $precios[1];
        $valor_fraccion = $precios[2];

        return view('pagos.show', compact('tiquete', 'hora_entrada', 'hora_salida', 'horas_transcurridas', 'valor_hora','valor_media','valor_fraccion'));
    }

    
    // muestra el formulario de creación de pagos
    public function create()
    {
       
        return view('pagos.create');
    }
    

    //metodo de pago controlador 
    public function store(Request $request)
    {
        $placa = $request->input('placa');
        $codigo_barras = $request->input('codigo_barras');

        //Verificar si los input estan vacios
        if (empty($placa) && empty($codigo_barras)) {
            return redirect()->back()->with('error', 'Debe ingresar la placa o el código de barras.');
        }
        //Llenar datos de vehiculo, para verificar si existe
        $vehiculo = null;
        if (!empty($placa)) {
            $vehiculo = Vehiculo::where('placa', $placa)->first();
        } else {
            $vehiculo = Vehiculo::where('placa', str_limit($codigo_barras, 6, ''))->first();
        }

        if (!$vehiculo) {
            return redirect()->back()->with('error', 'No se encontró un vehículo registrado con esa placa o código de barras.');
        }

        if ($vehiculo->ubicacion !== 'Dentro') {
            return redirect()->back()->with('error', 'El vehículo no está dentro del parqueadero.');
        }
        //Buscar el vehiculo en el registro de entrada
        $registro = Registro::where([
            ['placa', '=', $vehiculo->placa],
            ['pagado', '=', 'no']
        ])->first();

        if (!$registro) {
            return redirect()->back()->with('error', 'No se encontró un registro de pago pendiente para ese vehículo.');
        }
        //Establecer el tipo de vehiculo
        $tipoVehiculo = $vehiculo->tipo;
        $tarifa = Tarifa::where('tipo_vehiculo', $tipoVehiculo)->first();
        if (!$tarifa) {
            session()->flash('alert', 'No se encontró el tipo de vehículo en tarifas');
            return redirect()->back();
        }
        //Verificar que solo una impresora esté activa y exista
        if (!Impresora::where('activo', 1)->exists()) {
            return redirect()->back()->with('error', 'No se encontró ninguna impresora activa.');
        }

        $impresora = Impresora::where('activo', 1)->first();

        // Verificar si existe una factura activa
        $active_count = Factura::where('activa', true)->count();
        $factura = Factura::where('activa', true)->first();

        if ($active_count == 0) {
            return redirect()->back()->with('error', 'No hay resolucion de factura activas.');
        } elseif ($active_count > 1) {
            return redirect()->back()->with('error', 'Hay más de una resolucion activa.');
        }
        // Verificar si el número actual de la factura + 1 es mayor que el número final
        if ($factura && ($factura->numero_factura_actual + 1) > $factura->numero_factura_final) {
            return redirect()->back()->with('error', 'El número actual de facturacion ha alcanzado su limite');
        }

        // Verificar si la fecha final ha vencido
        $fecha_actual = date('Y-m-d');
        if ($fecha_actual > $factura->fecha_vencimiento) {
            return redirect()->back()->with('error', 'La fecha final de la facturacion ha vencido.');
        }

        $factura = Factura::where('activa', 1)->first();

        // Obtener información de la empresa y verificar que exista
        $empresa = Empresa::first();
        if (!$empresa) {
            session()->flash('alert', 'Empresa no creada');
            return redirect()->back();
        }

         // Obtener la lista de servicios solicitados del registro
         $servicios_solicitados = json_decode($registro->servicios_solicitados, true);
         // Inicializar el total de los precios de los servicios en cero
         $total_servicios = 0;
         $valor_servicio = 0;

        // Recorrer la lista de servicios solicitados y sumar sus precios
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

        $hora_entrada = $registro->entrada;
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
                $horas_completas = floor($minutos_transcurridos / 60);
                $fraccion_hora = 1;
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


         $nombreEmpresa = $empresa->nombre;
         $nit = $empresa->nit;
         $iva = $empresa->iva;
         $descripcion = $empresa->descripcion;
         
 
         $valor_iva = 0;
         //Agregar IVA si existe
         if ($empresa->iva == 'Si') {
             $valor_iva = ($valor_servicio_parqueadero + $valor_servicio) * 0.19;
             $valor_pagar += ($valor_servicio + $valor_iva);
         }else {
             $valor_pagar += $valor_servicio;
         }
             
 
        //Guardando tiquete
        $valor_tiempo = $valor_hora . ';' . $valor_media . ';' . $valor_fraccion;

        $tiquete = new Tiquete();
        $tiquete->placa = $placa;
        $tiquete->hora_entrada = $hora_entrada;
        $tiquete->hora_salida = $hora_salida;
        $tiquete->tipo_vehiculo = $tipoVehiculo;
        $tiquete->valor_tiempo = $valor_tiempo;
        $tiquete->valor_iva = $valor_servicio_parqueadero;
        $tiquete->valor_pagar = $valor_pagar;
        $tiquete->save();
         if (!$tiquete->id) {
             session()->flash('alert', 'No se encontro ticket');
             return redirect()->back();
         }
 
         // Actualizar el estado del vehículo
         $vehiculo->ubicacion = 'Fuera';
         $vehiculo->save();
 
         // Actualizar el registro a pagado
         $registro->salida = now();
         $registro->pagado = 'si';
         $registro->save();
 
 
         //informacion adicional
         $codigo_barras = DNS1D::getBarcodeHTML($vehiculo->placa.$registro->id, "C39", 1.6, 30);
         $hora_entrada = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_entrada));
         $hora_salida = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_salida));
         $horas_transcurridas = strtotime($tiquete->hora_salida) - strtotime($tiquete->hora_entrada);
         $dias = floor($horas_transcurridas / 86400);
         $horas = floor(($horas_transcurridas / 3600) % 24);
         $minutos = floor(($horas_transcurridas % 3600) / 60);
         $numero_factura = $tiquete->id;
         
        $numero_factura_actual = $factura->numero_factura_actual; // obtiene el número de factura actual
        $factura->numero_factura_actual = $numero_factura_actual + 1; // suma 1 al número de factura actual
        $factura->save(); // guarda la factura actualizada en la base de datos
                

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
        //$printer->setPrintWidth($ancho);

        // Imprime los datos
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Factura de Parqueadero\n\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($nombreEmpresa . "\n");
        $printer->text("N.I.T: " . $nit. "\n");
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer->text($factura->tipo_documento. " " .$factura->prefijo_facturacion. " " .strval($numero_factura_actual) . "\n");
        $printer->selectPrintMode(); // Desactivar todos los modos de impresión

        if ($iva == true) {
            $printer->text("Empresa responsable de IVA\n");
        } else {
            $printer->text("Empresa no responsable de IVA\n");
        }
        $printer->text("Hora de entrada:\n" . $hora_entrada . "\n");
        $printer->text("Hora de salida:\n" . $hora_salida . "\n");
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer->text("Placa: " . $vehiculo->placa . "\n");
        $printer->selectPrintMode(); // Desactivar todos los modos de impresión
        $printer->text("Tipo: " . strval($tipoVehiculo) . "\n");

        // Define la anchura de la tabla
        $tableWidth = 25;

        // Imprime la tabla de tiempo de estadía
        $printer->text("Tiempo transcurrido:\n");

        // Imprime la línea superior de la tabla
        $printer->text(str_repeat('-', $tableWidth) . "\n");

        // Imprime los encabezados de la tabla
        $printer->text(sprintf("| %5s | %5s | %7s |\n", 'Dias', 'Horas', 'Minutos'));

        // Imprime la línea separadora entre encabezados y contenido
        $printer->text(str_repeat('-', $tableWidth) . "\n");

        // Imprime los datos de la tabla
        $printer->text(sprintf("| %5d | %5d | %7d |\n", $dias, $horas, $minutos));

        // Imprime la línea inferior de la tabla
        $printer->text(str_repeat('-', $tableWidth) . "\n");

        $printer->text("\nValor de servicio: $" . strval($valor_servicio_parqueadero) . "\n");
        if ($valor_servicio != 0) {
            $printer->text("Valor de otros servicios: $" . strval($valor_servicio) . "\n");
        }
        if ($iva == true) {
            $printer->text("Valor de IVA: $" . strval($valor_iva) . "\n");
        }
        $printer->text("Total a pagar: $" . strval($valor_pagar) . "\n");
        $printer->text("\nCodigo de barras: \n");
        $printer->setBarcodeHeight(30);
        $printer->setBarcodeWidth(1);
        $printer->barcode($vehiculo->placa.$registro->id, Printer::BARCODE_CODE39);
        $printer->feed();

        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer->text("\nResolucion de " .$factura->tipo_resolucion."\n");
        $printer->text("\nN# " .$factura->numero_resolucion." DEL ".date('Y-m-d', strtotime($factura->fecha_inicio))." HASTA ".date('Y-m-d', strtotime($factura->fecha_vencimiento)). "\n");
        $printer->text("\nNUMERACION DESDE " .$factura->numero_factura_inicial." HASTA ".$factura->numero_factura_final."\n");


        $printer->text($descripcion);

        // Corta el papel
        $printer->cut();

        // Cierra la conexión con la impresora
        $printer->close();
        return redirect()->route('dashboard')->with('message', 'Pago realizado correctamente');


    }





    //pagar desde el directorio de no pagos
    public function pagar(Request $request, $placa)
    {
        $registro = Registro::where([
            ['placa', '=', $placa],
            ['pagado', '=', 'no']
        ])->first();

        if (!$registro) {
            session()->flash('alert', 'El vehiculo está pago, o no existe');
            return redirect()->back();        }

        // Obtener el vehículo correspondiente a la placa
        $vehiculo = Vehiculo::where('placa', $placa)->latest('id')->first();
        if (!$vehiculo) {
            session()->flash('alert', 'No se encontro placa en el registro');
            return redirect()->back();        }

        // Obtener el tipo de vehículo
        $tipoVehiculo = $vehiculo->tipo;
        // Buscar la tarifa correspondiente al tipo de vehículo
        $tarifa = Tarifa::where('tipo_vehiculo', $tipoVehiculo)->first();
        if (!$tarifa) {
            session()->flash('alert', 'No se encontro el tipo de vehiculo en tarifas');
            return redirect()->back();
            
        }

        //Verificar que solo una impresora esté activa y exista
        if (!Impresora::where('activo', 1)->exists()) {
            return redirect()->back()->with('error', 'No se encontró ninguna impresora activa.');
        }

        $impresora = Impresora::where('activo', 1)->first();

        // Verificar si existe una factura activa
        $active_count = Factura::where('activa', true)->count();
        $factura = Factura::where('activa', true)->first();

        if ($active_count == 0) {
            return redirect()->back()->with('error', 'No hay resolucion de factura activas.');
        } elseif ($active_count > 1) {
            return redirect()->back()->with('error', 'Hay más de una resolucion activa.');
        }
        // Verificar si el número actual de la factura + 1 es mayor que el número final
        if ($factura && ($factura->numero_factura_actual + 1) > $factura->numero_factura_final) {
            return redirect()->back()->with('error', 'El número actual de facturacion ha alcanzado su limite');
        }

        // Verificar si la fecha final ha vencido
        $fecha_actual = date('Y-m-d');
        if ($fecha_actual > $factura->fecha_vencimiento) {
            return redirect()->back()->with('error', 'La fecha final de la facturacion ha vencido.');
        }

        $factura = Factura::where('activa', 1)->first();

      

        // Obtener la lista de servicios solicitados del registro
        $servicios_solicitados = json_decode($registro->servicios_solicitados, true);
        // Inicializar el total de los precios de los servicios en cero
        $total_servicios = 0;
        $valor_servicio = 0;
            // Recorrer la lista de servicios solicitados y sumar sus precios
        
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

        $hora_entrada = $registro->entrada;
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

            if($minutos_restantes <= 30){
                $horas_completas = floor($minutos_transcurridos / 60);
                $media_hora = 1;
            }else{
                $media_hora = 0;
                $horas_completas = round($minutos_transcurridos / 60);

            }
            // calcular valor a pagar por horas y medias
            $valor_horas_completas = $valor_hora * $horas_completas;
            $valor_media_hora = $valor_media * $media_hora;
            $valor_pagar = $valor_horas_completas + $valor_media_hora;

        } else {
            // cobrar por día completo si la tarifa lo permite
            $dias_transcurridos = floor($horas_transcurridas / 24);
            $minutos_restantes = $minutos_transcurridos % 60;

            if($minutos_restantes <= 30){
                $horas_restantes = floor($minutos_transcurridos / 60) % 24;
                $media_hora = 1;
            }else{
                $media_hora = 0;
                $horas_restantes = round($minutos_transcurridos / 60) % 24;

            }
             // calcular valor a pagar por horas y medias
            $valor_dias_completos = $valor_dia * $dias_transcurridos;
            $valor_horas_completas = $valor_hora * $horas_restantes;
            $valor_media_hora = $valor_media * $media_hora;

            $valor_pagar = $valor_horas_completas + $valor_media_hora + $valor_dias_completos;
        }

        $valor_servicio_parqueadero = $valor_pagar;


        // Obtener información de la empresa
        $empresa = Empresa::first();
        $nombreEmpresa = $empresa->nombre;
        $nit = $empresa->nit;
        $iva = $empresa->iva;
        $descripcion = $empresa->descripcion;
        if (!$empresa) {
            session()->flash('alert', 'Empresa no creada');
            return redirect()->back();
        }

        $valor_iva = 0;
        //Agregar IVA si existe
        if ($empresa->iva == 'Si') {
            $valor_iva = ($valor_servicio_parqueadero + $valor_servicio) * 0.19;
            $valor_pagar += ($valor_servicio + $valor_iva);
        }else {
            $valor_pagar += $valor_servicio;
        }
            

        //Guardando tiquete
        $valor_tiempo = $valor_hora . ';' . $valor_media . ';' . $valor_fraccion;

        $tiquete = new Tiquete();
        $tiquete->placa = $placa;
        $tiquete->hora_entrada = $hora_entrada;
        $tiquete->hora_salida = $hora_salida;
        $tiquete->tipo_vehiculo = $tipoVehiculo;
        $tiquete->valor_tiempo = $valor_tiempo;
        $tiquete->valor_iva = $valor_servicio_parqueadero;
        $tiquete->valor_pagar = $valor_pagar;
        $tiquete->save();
        if (!$tiquete->id) {
            session()->flash('alert', 'No se encontro ticket');
            return redirect()->back();
        }

        // Actualizar el estado del vehículo
        $vehiculo->ubicacion = 'Fuera';
        $vehiculo->save();

        // Actualizar el registro a pagado
        $registro->salida = now();
        $registro->pagado = 'si';
        $registro->save();



        $codigo_barras = DNS1D::getBarcodeHTML($placa.$registro->id, "C39", 1.4, 30);
        $hora_entrada = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_entrada));
        $hora_salida = date('m/d/Y - h:i:s A', strtotime($tiquete->hora_salida));
        $horas_transcurridas = strtotime($tiquete->hora_salida) - strtotime($tiquete->hora_entrada);
        $dias = floor($horas_transcurridas / 86400);
        $horas = floor(($horas_transcurridas / 3600) % 24);
        $minutos = floor(($horas_transcurridas % 3600) / 60);
        $segundos = $horas_transcurridas % 60;
        $numero_factura = $tiquete->id;
        
        $numero_factura_actual = $factura->numero_factura_actual; // obtiene el número de factura actual
        $factura->numero_factura_actual = $numero_factura_actual + 1; // suma 1 al número de factura actual
        $factura->save(); // guarda la factura actualizada en la base de datos
        // Pasar información a la vista para mostrar el recibo
        $tipo_documento = $factura->tipo_documento;
        $tipo_resolucion = $factura->tipo_resolucion;
        $numero_resolucion = $factura->numero_resolucion;
        $numero_factura_inicial = $factura->numero_factura_inicial;
        $numero_factura_final = $factura->numero_factura_final;
        $fecha_inicio = $factura->fecha_inicio;
        $fecha_vencimiento = $factura->fecha_vencimiento;
        $prefijo_facturacion = $factura->prefijo_facturacion;

        $data = [
            'nombreEmpresa' => $nombreEmpresa,
            'nit' => $nit,
            'iva' => $iva,
            'numero_factura_actual' => $numero_factura_actual,
            'tipo_documento' => $tipo_documento,
            'tipo_resolucion' => $tipo_resolucion,
            'numero_resolucion' => $numero_resolucion,
            'numero_factura_inicial' => $numero_factura_inicial,
            'numero_factura_final' => $numero_factura_final,
            'fecha_inicio' => $fecha_inicio,
            'fecha_vencimiento' => $fecha_vencimiento,
            'prefijo_facturacion' => $prefijo_facturacion,
            'placa' => $placa,
            'tipoVehiculo' => $tipoVehiculo,
            'hora_entrada' => $hora_entrada,
            'hora_salida' => $hora_salida,
            'dias' => $dias,
            'horas' => $horas,
            'minutos' => $minutos,
            'segundos' => $segundos,
            'valor_servicio_parqueadero' => $valor_servicio_parqueadero,
            'valor_servicio' => $valor_servicio,
            'valor_iva' => $valor_iva,
            'valor_pagar' => $valor_pagar,
            'codigo_barras' => $codigo_barras,
            'descripcion' => $descripcion
        ];
        $size = $impresora->tamaño;
        $size = ($size * 2.835); 
        $customPaper = array(0, 0, $size, 851);
        // return view('pagos.recibo', $data);
        $pdf = PDF::loadView('pagos.recibo', $data)->setPaper($customPaper, 'portrait');
        //Trae los datos de imprimir y descarga el ticket
        return $pdf->stream('factura_'.$numero_factura_actual.'.pdf');
        
    }




}
