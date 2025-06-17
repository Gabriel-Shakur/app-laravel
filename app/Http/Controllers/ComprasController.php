<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\Producto;
use App\Models\Proveedores;
use App\Models\TmpCompra;
use App\Models\Arqueo;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use App\Models\DetalleCompra;
use Barryvdh\DomPDF\Facade\Pdf;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arqueo = Arqueo::where('empresa_id', auth()->user()->empresa_id)
                    ->whereNull('fecha_cierre')
                    ->latest()
                    ->first();
        $compras = Compras::with('detalles','proveedores')->get();
        return view('admin.compras.index',compact('compras','arqueo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::where('empresa_id', Auth::user()->empresa_id)->get();
        $proveedores = Proveedores::where('empresa_id', Auth::user()->empresa_id)->get();

        $session_id = session()->getId();
        $tmp_compras = TmpCompra::where('session_id',$session_id)->get();


        return view('admin.compras.create', compact('productos', 'proveedores','tmp_compras'));

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
            'fecha'=>'required',
            'comprobante'=>'required',
            'precio_total'=>'required',
            'proveedor_id' => 'required',
           
        ]);

       

        
        $compras = new Compras();

        $compras->fecha = $request->fecha;
        $compras->comprobante = $request->comprobante;
        $compras->precio_total = $request->precio_total;
        $compras->proveedor_id = $request->proveedor_id;
        $compras->empresa_id = Auth::user()->empresa_id;
        $compras->save ();

        // Obtener arqueo abierto
        $arqueo = Arqueo::where('empresa_id', auth()->user()->empresa_id)
                    ->whereNull('fecha_cierre')
                    ->latest()
                    ->first();
        // Obtener arqueo abierto
                    
        

        //Registrar en el arqueo si existe
       if ($arqueo) {
          $arqueo->movimientos()->create([
              'tipo' => 'egreso',
              'monto' => $request->precio_total,
              'descripcion' => 'Compra registrada (ID: ' . $compras->id . ')',
           ]);
       }
        //Registrar en el arqueo si existe


        //Registrar detalles de la compra
        $session_id = session()->getId();
        $tmp_compras = TmpCompra::where('session_id',$session_id)->get();
        
        foreach ($tmp_compras as $tmp_compra){

            $producto = Producto::where('id',$tmp_compra->producto_id)->first();
            $detalle_compra = new DetalleCompra();
            $detalle_compra->cantidad = $tmp_compra->cantidad;
            $detalle_compra->compras_id = $compras->id;
            $detalle_compra->producto_id = $tmp_compra->producto_id;

            $detalle_compra->save ();

            $producto->stock += $tmp_compra->cantidad;
            $producto->save();
        }

        TmpCompra::where('session_id',$session_id)->delete();

    

        return redirect()->route('admin.compras.index')->with('success', 'Compra registrada correctamente.');

        

       

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compras  $compras
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $compra = Compras::with('detalles.producto','proveedores','empresa')->findorFail($id);
        return view('admin.compras.show',compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compras  $compras
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $compra = Compras::with('detalles','proveedores')->findorfail($id);

        $proveedores = Proveedores::all();
        $productos = Producto::all();

         return view('admin.compras.edit',compact('compra','proveedores','productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compras  $compras
     * @return \Illuminate\Http\Response
     */
    
    
   public function update(Request $request, $id)
  {
      $request->validate([
        'fecha' => 'required',
        'comprobante' => 'required',
        'precio_total' => 'required',
      ]);

      $compra = Compras::find($id);
      $compra->fecha = $request->fecha;
      $compra->comprobante = $request->comprobante;
      $compra->precio_total = $request->precio_total;
      $compra->proveedor_id = $request->proveedor_id;
      $compra->empresa_id = Auth::user()->empresa_id;
      $compra->save();
 
      return redirect()->route('admin.compras.index')
        ->with('mensaje', 'Se actualizó la compra de manera correcta')
        ->with('icono', 'success');
   }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compras  $compras
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
   {
     $compra = Compras::findOrFail($id);

     foreach ($compra->detalles as $detalle) {
        $producto = Producto::find($detalle->producto_id);
        if ($producto) {
            // Revertir el stock sumando la cantidad que la compra había sumado
            $producto->stock -= $detalle->cantidad;  // Si al crear compra sumaste, acá restas
            $producto->save();
        }
     }

     // Eliminar detalles y la compra
     $compra->detalles()->delete();
     $compra->delete();

     return redirect()->route('admin.compras.index')
        ->with('mensaje', 'Se eliminó la compra de manera correcta')
        ->with('icono', 'success');
   }

   
}
