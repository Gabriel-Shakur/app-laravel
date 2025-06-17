<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedores::all();
        $empresa = Empresa::where('id', Auth::user()->empresa_id)->first();
        return view('admin.proveedores.index',compact('empresa','proveedores'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.proveedores.create');
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
            'empresa'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'email'=>'required',
            'nombre'=>'required',
            'celular'=>'required',
           
        ]);
        $Proveedores= new Proveedores();

        $Proveedores->empresa = $request->empresa;
        $Proveedores->direccion = $request->direccion;
        $Proveedores->telefono = $request->telefono;
        $Proveedores->email = $request->email;
        $Proveedores->nombre = $request->nombre;
        $Proveedores->celular = $request->celular;
        $Proveedores->empresa_id = Auth::user()->empresa_id;

        $Proveedores->save ();

        

        return redirect()->route('admin.proveedores.index')
      ->with('mensaje', 'Se registro el Proveedor de manera correcta :)')
      ->with('icono','success');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedores = Proveedores::find($id);
        return view('admin.proveedores.show',compact('proveedores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedores = Proveedores::find($id);
        return view('admin.proveedores.edit',compact('proveedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    
    
  public function update(Request $request, $id)
    {
        $request->validate([
            'empresa'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'email'=>'required',
            'nombre'=>'required',
            'celular'=>'required',
           
        ]);
        $proveedores = Proveedores::findOrFail($id);

        $proveedores->empresa = $request->empresa;
        $proveedores->direccion = $request->direccion;
        $proveedores->telefono = $request->telefono;
        $proveedores->email = $request->email;
        $proveedores->nombre = $request->nombre;
        $proveedores->celular = $request->celular;
        $proveedores->empresa_id = Auth::user()->empresa_id;

        $proveedores->save ();

        

        return redirect()->route('admin.proveedores.index')
      ->with('mensaje', 'Se modifico los datos del Proveedor de manera correcta :)')
      ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          Proveedores::destroy($id);
      return redirect()->route('admin.proveedores.index')
          ->with('mensaje','se elimino el proveedor de manera correcta')
          ->with('icono','success');
    }
}
