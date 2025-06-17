<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermisoController extends Controller
{
    public function index(){
        $permisos=Permission::all();
        return view('admin.permisos.index',compact('permisos'));
    }

    public function create(){
        return view('admin.permisos.create');
    }

    public function store(Request $request)
  {
      $request->validate([
          'name' => 'required|string|max:255|unique:permissions,name',
       ]);

      Permission::create([
          'name' => $request->name,
       ]);

       return redirect()->route('admin.permisos.index')->with('success', 'Permiso creado correctamente.');
   }

   public function show($id)
  {
      $permiso = Permission::findOrFail($id);
      return view('admin.permisos.show', compact('permiso'));
  }

  public function edit($id)
  {
      $permiso = Permission::findOrFail($id);
      return view('admin.permisos.edit', compact('permiso'));
  }

  public function update(Request $request, $id)
   {
      $request->validate([
          'name' => 'required|string|max:255|unique:permissions,name,' . $id,
      ]);

       $permiso = Permission::findOrFail($id);
       $permiso->name = $request->name;
       $permiso->save();

      return redirect()->route('admin.permisos.index')->with('success', 'Permiso actualizado correctamente.');
   }

   public function destroy($id)
   {
      $permiso = Permission::findOrFail($id);
      $permiso->delete();

      return redirect()->route('admin.permisos.index')->with('success', 'Permiso eliminado correctamente.');
   }

}
