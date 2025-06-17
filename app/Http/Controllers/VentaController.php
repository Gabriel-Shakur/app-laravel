<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use App\Models\TmpVenta;
use App\Models\Empresa;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Arqueo;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arqueoAbierto = Arqueo::whereNull('fecha_cierre')->first();
        $ventas = Venta::with('detalleventa.producto','cliente')->get();
        return view('admin.ventas.index',compact('ventas','arqueoAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::where('empresa_id',Auth::user()->empresa_id)->get();
        $clientes = Cliente::where('empresa_id',Auth::user()->empresa_id)->get();

        $session_id = session()->getId();
        $tmp_ventas = TmpVenta::where('session_id',$session_id)->get();

        return view('admin.ventas.create',compact('productos','clientes','tmp_ventas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tmp_ventas(Request $request)
   {
       // Aquí tu lógica para agregar productos a TmpVenta vía AJAX
        $producto = Producto::where('codigo', $request->codigo)->first();
        $session_id = session()->getId();

        if ($producto) {
            $tmp_venta_existe = TmpVenta::where('producto_id', $producto->id)
                                        ->where('session_id', $session_id)
                                        ->first();

            if ($tmp_venta_existe) {
                $tmp_venta_existe->cantidad += $request->cantidad;
                $tmp_venta_existe->save();
                return response()->json(['success' => true, 'message' => 'Producto actualizado']);
            } else {
                $tmp_venta = new TmpVenta();
                $tmp_venta->cantidad = $request->cantidad;
                $tmp_venta->producto_id = $producto->id;
                $tmp_venta->session_id = $session_id;
                $tmp_venta->save();

                return response()->json(['success' => true, 'message' => 'Producto agregado']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
          'fecha' => 'required|date',
          'cliente_id' => 'required|exists:clientes,id',
        ]);

        $session_id = session()->getId();
        $tmp_ventas = TmpVenta::where('session_id', $session_id)->get();

       if ($tmp_ventas->isEmpty()) {
           return back()->withErrors(['productos' => 'Debe agregar al menos un producto a la venta.']);
        }

        $total = 0;
        foreach ($tmp_ventas as $tmp_venta) {
          $producto = Producto::find($tmp_venta->producto_id);
          $total += $tmp_venta->cantidad * $producto->precio_venta;
        }

      if ($total <= 0) {
          return back()->withErrors(['total' => 'El total de la venta debe ser mayor a cero.']);
        }

       $venta = new Venta();
       $venta->fecha = $request->fecha;
       $venta->cliente_id = $request->cliente_id;
       $venta->precio_total = $total;  // <- aquí debe tener un valor válido
       $venta->empresa_id = Auth::user()->empresa_id;
       $venta->save();

       foreach ($tmp_ventas as $tmp_venta) {
        $producto = Producto::find($tmp_venta->producto_id);

           $detalle = new DetalleVenta();
           $detalle->venta_id = $venta->id;
           $detalle->producto_id = $producto->id;
           $detalle->cantidad = $tmp_venta->cantidad;
           $detalle->precio_venta = $producto->precio_venta;
           $detalle->save();

           $producto->stock -= $tmp_venta->cantidad;
           $producto->save();
        }

        TmpVenta::where('session_id', $session_id)->delete();
         
        //Arqueo abierto
         $arqueo = Arqueo::where('empresa_id', auth()->user()->empresa_id)
                    ->whereNull('fecha_cierre')
                    ->latest()
                    ->first();
        //Arqueo abierto

        // Registrar movimiento en arqueo si existe
            if ($arqueo) {
               $arqueo->movimientos()->create([
                  'tipo' => 'ingreso',
                  'monto' => $venta->precio_total,
                   'descripcion' => 'Venta registrada (ID: ' . $venta->id . ')',
               ]);
           }

       

       // resto del código...

       return redirect()->route('admin.ventas.index')->with('success', 'Venta registrada correctamente.');
   }


   public function pdf($id){

    $id_empresa = Auth::user()->empresa_id;
    $empresa = Empresa::findOrFail($id_empresa);
    $venta = Venta::with('detalleventa','cliente')->findorFail($id);
     

    $pdf = PDF::loadView("admin.ventas.pdf",compact('empresa','venta'));
    return $pdf->stream();
   }
    
    
 


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Traer venta con cliente y detalles con sus productos
        $venta = Venta::with('cliente', 'detalleventa.producto')->findOrFail($id);

        return view('admin.ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venta = Venta::with('detalleventa.producto', 'cliente')->findOrFail($id);
        $clientes = Cliente::all();

        return view('admin.ventas.edit', compact('venta', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
          'fecha' => 'required|date',
          'cliente_id' => 'required|exists:clientes,id',
       ]);

       $venta = Venta::findOrFail($id);
       $venta->fecha = $request->fecha;
       $venta->cliente_id = $request->cliente_id;
       $venta->save();

     return redirect()->route('admin.ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);

      // Opcional: Restaurar stock antes de eliminar detalles
        foreach ($venta->detalleventa as $detalle) {
           $producto = $detalle->producto;
            if ($producto) {
              $producto->stock += $detalle->cantidad;
              $producto->save();
           }
        }

       // Eliminar detalles de venta
      $venta->detalleventa()->delete();

      // Eliminar la venta
      $venta->delete();

     return redirect()->route('admin.ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
    
}
