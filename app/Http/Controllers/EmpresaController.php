<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;


class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = DB::table('countries')->get();
        $estados = DB::table('states')->get();
        $ciudades = DB::table('cities')->get();
        $monedas = DB::table('currencies')->get();
        return view('admin.empresas.create',compact('paises','estados','ciudades','monedas'));
    }

    public function buscar_estado($id_pais){
        try{
            $estados = DB::table('states')->where('country_id',$id_pais)->get();
            return view('admin.empresas.cargar_estados',compact('estados'));
        }catch(\Exception $exception){
            return response ()->json(['mensaje'=>'error']); 
        }
    }

    public function buscar_ciudades($id_estado){
        try{
            $ciudades = DB::table('cities')->where('state_id',$id_estado)->get();
            return view('admin.empresas.cargar_ciudades',compact('ciudades'));
        }catch(\Exception $exception){
            return response ()->json(['mensaje'=>'error']); 
        }
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
  */
  public function store (Request $request)
  {
    //$datos = request()->all();
    //return response()->json($datos);

    $request->validate([
    'nombre_empresa'=>'required',
    'tipo_empresa'=>'required',
    'rfc'=>'required|unique:empresas',
    'telefono'=>'required',
    'correo'=>'required',
    'cantidad_impuesto'=>'required',
    'nombre_impuesto'=>'required',
    'direccion'=>'required',
    'logo'=>'required'
    ]);

    $empresa = new Empresa();

    $empresa->pais = $request->pais;
    $empresa->nombre_empresa = $request->nombre_empresa;
    $empresa->tipo_empresa = $request->tipo_empresa;
    $empresa->rfc = $request->rfc;
    $empresa->telefono = $request->telefono;
    $empresa->correo = $request->correo;
    $empresa->cantidad_impuesto = $request->cantidad_impuesto;
    $empresa->nombre_impuesto = $request->nombre_impuesto;
    $empresa->moneda = $request->moneda;
    $empresa->direccion = $request->direccion;
    $empresa->ciudad = $request->ciudad;
    $empresa->departamento = $request->departamento;
    $empresa->codigo_postal = $request->codigo_postal;
    $empresa->logo = $request->file('logo')->store('logos');

    $empresa->save();

    $usuario = new User();
    $usuario->name = "Admin";
    $usuario->email = $request->correo;
    $usuario->password = Hash::make($request->rfc);
    $usuario->empresa_id = $empresa->id;
    $usuario->save();

    $usuario->assignRole('ADMINISTRADOR');

    Auth::login($usuario);

    return redirect()->route('admin.index');
    
  }
  

    

    








        /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        $paises = DB::table('countries')->get();
        $estados = DB::table('states')->get();
        //$ciudades = DB::table('cities')->get();
        $monedas = DB::table('currencies')->get();
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::where('id',$empresa_id)->first();
        $departamentos = DB::table('states')->where('country_id',$empresa->pais)->get();
        $ciudades = DB::table('cities')->where('state_id',$empresa->departamento)->get();
        
        return view('admin.configuraciones.edit',compact('paises', 'estados', 'monedas', 'empresa','departamentos','ciudades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$datos = request()->all();
        //return response()->json($datos);
        $request->validate([
            'nombre_empresa'=>'required',
            'tipo_empresa'=>'required',
            'rfc'=>'required|unique:empresas,rfc,'.$id,
            'telefono'=>'required',
            'correo'=>'required',
            'cantidad_impuesto'=>'required',
            'nombre_impuesto'=>'required',
            'direccion'=>'required',
            'logo'=>'required'
        ]);
            
            
        
       $empresa = Empresa::find($id);

      $empresa->pais = $request->pais;
      $empresa->nombre_empresa = $request->nombre_empresa;
      $empresa->tipo_empresa = $request->tipo_empresa;
      $empresa->rfc = $request->rfc;
      $empresa->telefono = $request->telefono;
      $empresa->correo = $request->correo;
      $empresa->cantidad_impuesto = $request->cantidad_impuesto;
      $empresa->nombre_impuesto = $request->nombre_impuesto;
      $empresa->moneda = $request->moneda;
      $empresa->direccion = $request->direccion;
      $empresa->ciudad = $request->ciudad;
      $empresa->departamento = $request->departamento;
      $empresa->codigo_postal = $request->codigo_postal;

      if($request->hasFile('logo')){
        Storage::delete('public/'.$empresa->logo);
        $empresa->logo = $request->file('logo')->store('logos');
      }
     

      $empresa->save();

      $usuario_id = Auth::user()->id;

      $usuario = User::find($usuario_id);
      $usuario->name = "Admin";
      $usuario->email = $request->correo;
      $usuario->password = Hash::make($request->rfc);
      $usuario->empresa_id = $empresa->id;
      $usuario->save();

      

      return redirect()->route('admin.index')
      ->with('mensaje', 'Se actualizaron los datos de manera correcta :)')
      ->with('icono','success');

    
  

            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
