<?php

namespace App\Http\Controllers;

use App\Models\TmpVenta;
use Illuminate\Http\Request;
use App\Models\Producto;

class TmpVentaController extends Controller
{
    public function tmp_ventas(Request $request)
    {
        $producto = Producto::where('codigo', $request->codigo)->first();
        $session_id = session()->getId();

        if ($producto) {
        // Verifica si ya está agregado en tmp
        $tmp_venta_existe = TmpVenta::where('producto_id', $producto->id)
                                    ->where('session_id', $session_id)
                                    ->first();

        if ($tmp_venta_existe) {
            $tmp_venta_existe->cantidad += $request->cantidad;
            $tmp_venta_existe->save();
        } else {
            $tmp_venta = new TmpVenta();
            $tmp_venta->cantidad = $request->cantidad;
            $tmp_venta->producto_id = $producto->id;
            $tmp_venta->session_id = $session_id;
            $tmp_venta->save();
        }

        return response()->json(['success' => true, 'message' => 'Producto agregado a la venta']);
     }

      return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TmpVenta  $tmpVenta
     * @return \Illuminate\Http\Response
     */
    public function show(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmpVenta  $tmpVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmpVenta  $tmpVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmpVenta  $tmpVenta
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        $tmp = TmpVenta::find($id);
     if ($tmp) {
        $tmp->delete();
        return response()->json(['success' => true]);
     } else {
        return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
     }
    }
}
