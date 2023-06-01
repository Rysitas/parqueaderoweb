<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;

class EmpresasController extends Controller
{


    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
        
    }

    public function index()
    {
        $empresa = Empresa::first();

        view()->share('empresa', $empresa);
        
        return view('empresas.index', compact('empresa'));
    }
    

    public function create()
    {
        // Verificamos si ya existe una empresa creada en la base de datos
        $empresa = Empresa::first();
    
        // Si existe, redirigimos al formulario de edición de empresa
        if ($empresa) {
            return redirect()->route('empresas.edit', $empresa->id);
        }
    
        // Si no existe, mostramos el formulario de creación de empresa
        return view('empresas.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'nit' => 'required|string|unique:empresas,nit',
            'descripcion' => 'required|string',
            'horario_atencion' => 'required|string',
            'gerente' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string',
            'iva' => 'required|in:Si,No',
            'logo' => 'image'
        ]);
    
        $empresa = new Empresa($request->all());
    
        // Guardar imagen
        $logo = $request->file('logo');
    
        if ($logo->isValid()) {
            $filename = $logo->getClientOriginalName();
            $logo->storeAs('public/img/empresa', $filename);
            $empresa->logo = 'img/empresa/' . $filename;
        }        
    
        $empresa->save();
    
        return redirect()->route('dashboard')->with('success', 'Empresa creada correctamente');
    }

    
    public function edit(Empresa $empresa)
    {
        // Mostramos el formulario de edición de empresa con los datos de la empresa seleccionada
        return view('empresas.edit', compact('empresa'));
    }
    
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required|string',
            'nit' => 'required|string|unique:empresas,nit,'.$empresa->id,
            'descripcion' => 'required|string',
            'horario_atencion' => 'required|string',
            'gerente' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string',
            'iva' => 'required|in:Si,No',
            'logo' => 'image'
        ]);
    
        
        $empresa->fill($request->all());
        // Guardar imagen
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logo_path = $empresa->logo; // Ruta del logo actual
            
            if ($logo_path) {
                // Elimina el logo actual
                Storage::delete('public/'.$logo_path);
            }
        
            $logo = $request->file('logo');
            $filename = $logo->getClientOriginalName();
            $logo->storeAs('public/img/empresa', $filename);
            $empresa->logo = 'img/empresa/' . $filename;
        }
        
    
        $empresa->save();
    
        return redirect()->route('dashboard')->with('success', 'Empresa actualizada correctamente');
    }
    
}
