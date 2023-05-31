<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarifa;

class TarifasController extends Controller
{
    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
        
    }

    public function index(Request $request)
    {
        $search = $request->input('search') ?? ''; // Asignar un valor predeterminado en caso de que $request->input('search') no exista
        $tarifas = Tarifa::where('tipo_vehiculo', 'LIKE', '%'.$search.'%')->paginate(10);
        return view('tarifas.index', compact('tarifas', 'search'));
    }
    
    
    

    public function create()
    {
        return view('tarifas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_vehiculo' => 'required|string',
            'precio_hora' => 'required|numeric',
            'precio_media_hora' => 'required|numeric',
            'precio_fraccion_hora' => 'required|numeric',
        ]);
        Tarifa::create($request->all());
        return redirect()->route('tarifas.index')->with('message', 'Tarifa creada correctamente');
    }

    public function edit(Tarifa $tarifa)
    {
        return view('tarifas.edit', compact('tarifa'));
    }

    public function update(Request $request, Tarifa $tarifa)
    {
        $request->validate([
            'tipo_vehiculo' => 'required|string',
            'precio_hora' => 'required|numeric',
            'precio_media_hora' => 'required|numeric',
            'precio_fraccion_hora' => 'required|numeric',
        ]);
    
        $tarifa->update($request->all());
    
        return redirect()->route('tarifas.index')->with('message', 'Tarifa actualizada correctamente');
    }
    

    public function destroy(Tarifa $tarifa)
    {
        $tarifa->delete();
        return redirect()->route('tarifas.index')->with('message', 'Tarifa eliminada correctamente');
    }

    


}
