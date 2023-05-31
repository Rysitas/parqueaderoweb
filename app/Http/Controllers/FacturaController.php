<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Factura;

class FacturaController extends Controller
{
    
    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
        
    }
    public function index()
    {
        $facturas = Factura::all();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $tipos_resolucion = ['Autorizacion', 'Habilitacion'];
        return view('facturas.create', compact('tipos_resolucion'));
    }

    public function store(Request $request)
    {
        $factura = new Factura;
        $factura->tipo_documento = $request->tipo_documento;
        $factura->tipo_resolucion = $request->tipo_resolucion;
        $factura->numero_resolucion = $request->numero_resolucion;
        $factura->fecha_autorizacion = $request->fecha_autorizacion;
        $factura->numero_factura_inicial = $request->numero_factura_inicial;
        $factura->numero_factura_actual =$request->numero_factura_inicial;
        $factura->numero_factura_final = $request->numero_factura_final;
        $factura->fecha_inicio = $request->fecha_inicio;
        $factura->fecha_vencimiento = $request->fecha_vencimiento;
        $factura->prefijo_facturacion = $request->prefijo_facturacion;
        $factura->activa = false;
        $factura->save();
        return redirect()->route('facturas.index')->with('success','Factura creada exitosamente.');
    }

    public function show(Factura $factura)
    {
        return view('facturas.show', compact('factura'));
    }

    public function edit($id)
    {

        // Obtener los datos de la impresora que se va a editar
        $factura = DB::table('facturas')->where('id', $id)->first();
        $tipos_resolucion = ['Autorizacion', 'Habilitacion'];

        return view('facturas.edit', compact('factura','tipos_resolucion'));
    }

    public function update(Request $request, Factura $factura)
    {
        $factura->update($request->all());
        return redirect()->route('facturas.index')->with('success','Factura actualizada exitosamente.');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('success','Factura eliminada exitosamente.');
    }

    public function activarFactura($id)
    {
        $factura = Factura::findOrFail($id);
        if ($factura->activa) {
            $factura->activa = false;
        } else {
            // Desactivar todas las resoluciones
            Factura::where('activa', true)->update(['activa' => false]);
            $factura->activa = true;
        }
        $factura->save();

        return redirect()->route('facturas.index');
    }
}
