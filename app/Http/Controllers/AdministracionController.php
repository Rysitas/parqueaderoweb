<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdministracionController extends Controller
{
    public function __construct()
    {
        //es el constructor que permite que despues que se validen datos de ingreso permite que admin y usuario entren a todos los metodos y url de este controler
        $this->middleware('auth');
        
    }
    public function index()
    {
        $admins = User::all();
        return view('admin.index', compact('admins'));
    }

    public function edit($admin)
    {
        $admin = User::findOrFail($admin);
        // Lógica para mostrar el formulario de edición sin incluir la opción de cambiar la contraseña
        return view('admin.edit', compact('admin'));
    }


    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$admin->id,
            'tipo' => 'required|string|in:1,2',
        ]);
    
        $admin->update($request->only(['name', 'email', 'tipo']));
    
        return redirect()->route('admin.index')->with('message', 'Cuenta actualizada correctamente');
    }
    public function destroy(User $admin)
    {
        $admin->delete();

        return redirect()->route('admin.index')->with('message', 'Cuenta eliminada correctamente');
    }

}
