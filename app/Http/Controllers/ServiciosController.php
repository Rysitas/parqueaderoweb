<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Servicio;

class ServiciosController extends Controller
{
    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
        
    }
    public function index(Request $request)
    {
        $empresa = Empresa::first();
        if (!$empresa) {
            return redirect()->route('empresas.create')
                ->with('message', 'Primero debe crear una empresa para continuar.');
        }
        $search = $request->input('search') ?? ''; // Asignar un valor predeterminado en caso de que $request->input('search') no exista
        $servicios = Servicio::where('nombre', 'LIKE', '%'.$search.'%')->paginate(10);
        return view('servicios.index', compact('servicios','search'));
    }

    public function create()
    {
        $empresa = Empresa::first();
        if (!$empresa) {
            return redirect()->route('empresas.create')
                ->with('message', 'Primero debe crear una empresa para continuar.');
        }
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'precio' => 'required|numeric|min:0',
        ]);
    
        $empresa = Empresa::first();
        if (!$empresa) {
            return redirect()->route('empresas.create')
                ->with('message', 'Primero debe crear una empresa para continuar.');
        }
    
        $servicio = new Servicio();
        $servicio->empresa_id = $empresa->id;
        $servicio->nombre = $request->input('nombre');
        $servicio->precio = $request->input('precio');
        $servicio->save();
    
        return redirect()->route('servicios.index')
            ->with('message', 'Servicio creado exitosamente.');
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'precio' => 'required|numeric|min:0',
        ]);
    
        $empresa = Empresa::first();
        if (!$empresa) {
            return redirect()->route('empresas.create')
                ->with('message', 'Primero debe crear una empresa para continuar.');
        }
    
        $servicio->empresa_id = $empresa->id;
        $servicio->nombre = $request->input('nombre');
        $servicio->precio = $request->input('precio');
        $servicio->save();
    
        return redirect()->route('servicios.index')
            ->with('message', 'Servicio actualizado exitosamente.');
    }
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')
            ->with('message', 'Servicio eliminado exitosamente.');
    }
}
