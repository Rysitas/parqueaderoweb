<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Impresora;

class ImpresoraController extends Controller
{
    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
        
    }
    public function index()
    {
        // Obtener una lista de todas las impresoras
        $impresoras = DB::table('impresora')->get();

        return view('impresoras.index', compact('impresoras'));
    }

    public function create()
    {
        // Mostrar el formulario para crear una nueva impresora
        return view('impresoras.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario de creación de impresoras
        $request->validate([
            'nombre' => 'required',
            'tamaño' => 'required|numeric'
        ]);

        // Crear una nueva impresora en la base de datos
        DB::table('impresora')->insert([
            'nombre' => $request->nombre,
            'tamaño' => $request->tamaño,
            'activo' => false
        ]);

        return redirect()->route('impresoras.index');
    }

    public function edit($id)
    {
        // Obtener los datos de la impresora que se va a editar
        $impresora = DB::table('impresora')->where('id', $id)->first();

        return view('impresoras.edit', compact('impresora'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario de edición de impresoras
        $request->validate([
            'nombre' => 'required',
            'tamaño' => 'required|numeric'
        ]);

        // Actualizar los datos de la impresora en la base de datos
        DB::table('impresora')->where('id', $id)->update([
            'nombre' => $request->nombre,
            'tamaño' => $request->tamaño
        ]);

        return redirect()->route('impresoras.index');
    }

    public function destroy($id)
    {
        // Eliminar la impresora seleccionada de la base de datos
        DB::table('impresora')->where('id', $id)->delete();

        return redirect()->route('impresoras.index');
    }
    public function activarImpresora($id)
    {
        $impresora = Impresora::findOrFail($id);
        if ($impresora->activo) {
            $impresora->activo = false;
        } else {
            // Desactivar todas las impresoras
            Impresora::where('activo', true)->update(['activo' => false]);
            $impresora->activo = true;
        }
        $impresora->save();
    
        return redirect()->route('impresoras.index');
    }
}