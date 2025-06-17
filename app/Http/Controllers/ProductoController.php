<?php

namespace App\Http\Controllers;

use App\Models\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

         // Carga todos los productos con su categoría relacionada
          $productos = Producto::with('categoria')->get();
  
       // Retorna la vista con los productos
       return view('admin.productos.index', compact('productos'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view ('admin.productos.create',compact('categorias'));
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
            'codigo'=>'required',
            'nombre'=>'required',
            'stock'=>'required',
            'stock_minimo'=>'required',
            'stock_maximo'=>'required',
            'precio_compra'=>'required',
            'precio_venta'=>'required',
            'fecha_ingreso'=>'required',
           
        ]);

        $producto = new Producto();

        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->stock_maximo = $request->stock_maximo;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = $request->fecha_ingreso;
        $producto->categoria_id = $request->categoria_id;
        $producto->empresa_id = Auth::user()->empresa_id;

        if($request->hasFile('imagen')){
            $producto->imagen = $request->file('imagen')->store('producto','public');

        }
        $producto->save();
        return redirect()->route('admin.productos.index')
      ->with('mensaje', 'Se registro el producto de manera correcta :)')
      ->with('icono','success');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        return view('admin.productos.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit',compact('producto','categorias'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo'=>'required',
            'nombre'=>'required',
            'stock'=>'required',
            'stock_minimo'=>'required',
            'stock_maximo'=>'required',
            'precio_compra'=>'required',
            'precio_venta'=>'required',
            'fecha_ingreso'=>'required',
           
        ]);

        $producto = Producto::find($id);

        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->stock_maximo = $request->stock_maximo;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = $request->fecha_ingreso;
        $producto->categoria_id = $request->categoria_id;
        $producto->empresa_id = Auth::user()->empresa_id;

        if ($request->hasFile('imagen')) {
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->imagen = $request->file('imagen')->store('producto', 'public');
    }
        $producto->save();
        return redirect()->route('admin.productos.index')
      ->with('mensaje', 'Se actualizo el producto de manera correcta :)')
      ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    {
        $producto = Producto::find($id);

         if ($producto && $producto->imagen) {
        Storage::delete('public/' . $producto->imagen);
         }

        Producto::destroy($id);
        
        return redirect()->route('admin.productos.index')

        ->with('mensaje','se elimino el producto de manera correcta')
        ->with('icono','success');
    }
}
