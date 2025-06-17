<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Role;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;





class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.roles.create');
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
            'name'=>'required|unique:roles,name',
            
        
        ]);
        
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();
        
            
        
            
        
        return redirect()->route('admin.roles.index')
          ->with('mensaje','se registro el rol de manera correcta')
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
        $role = Role::find($id);
        return view('admin.roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin.roles.edit',compact('role'));
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
            'name'=>'required|unique:roles,name,'.$id,
            

            
        
        ]);
        
        $role = Role::find($id);
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();
        
            
        
            
        
        return redirect()->route('admin.roles.index')
          ->with('mensaje','se modifico el rol de manera correcta')
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
      
      Role::destroy($id);
      return redirect()->route('admin.roles.index')
          ->with('mensaje','se elimino el rol de manera correcta')
          ->with('icono','success');
    }

    public function reportePdf()
    {
        $roles = Role::all();
        $empresa = Empresa::where('id',Auth::user()->empresa_id)->first();
        $pdf = Pdf::loadView('admin.roles.reporte', compact('roles','empresa'));
        return $pdf->stream('reporte_roles.pdf');
    }

    public function asignar($id)
   {
      $role = Role::findOrFail($id);
      $role->load('permissions');
      $permisos = Permission::all();
      return view('admin.roles.asignar', compact('role', 'permisos'));
   }

   public function guardarAsignacion(Request $request, $id)
  {
       $role = Role::findOrFail($id);
       $role->syncPermissions($request->permissions ?? []);
    
      return redirect()->route('admin.roles.index')->with('success', 'Permisos actualizados correctamente.');
   }
}
