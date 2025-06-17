<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;



use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa_id = AUTH::user()->empresa_id;
        $usuarios = User::where('empresa_id',$empresa_id)->get();
        return view('admin.usuarios.index',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|confirmed',
           
        ]);
        $usuario= new User();

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->empresa_id = Auth::user()->empresa_id;

        $usuario->save ();

        $usuario->assignRole($request->role);

        return redirect()->route('admin.usuarios.index')
      ->with('mensaje', 'Se registro el usuario de manera correcta :)')
      ->with('icono','success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::with('roles')->findOrFail($id);
        return view ('admin.usuarios.show',compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        $roles = Role::all();
        return view ('admin.usuarios.edit',compact('usuario','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'confirmed',
           
        ]);
        
        $usuario= User::find($id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        if($request->filled('password')){
            $usuario->password = Hash::make($request->password);
        }
        $usuario->empresa_id = Auth::user()->empresa_id;

        $usuario->save ();

        $usuario->syncRoles($request->role);

        return redirect()->route('admin.usuarios.index')
      ->with('mensaje', 'Se modifico al usuario de manera correcta :)')
      ->with('icono','success');




       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
      return redirect()->route('admin.usuarios.index')
        ->with('mensaje','se elimino el usuario de manera correcta')
        ->with('icono','success');
    }

    
}
