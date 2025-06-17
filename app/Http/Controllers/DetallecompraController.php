<?php

namespace App\Http\Controllers;

use App\Models\detallecompra;
use Illuminate\Http\Request;

class DetallecompraController extends Controller
{
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
     * @param  \App\Models\detallecompra  $detallecompra
     * @return \Illuminate\Http\Response
     */
    public function show(detallecompra $detallecompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\detallecompra  $detallecompra
     * @return \Illuminate\Http\Response
     */
    public function edit(detallecompra $detallecompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\detallecompra  $detallecompra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, detallecompra $detallecompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\detallecompra  $detallecompra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $detalle = DetalleCompra::findOrFail($id);

      // Opcional: podrías validar que la compra no esté cerrada/finalizada

      $detalle->delete();
 
      return back()->with('info', 'Producto eliminado de la compra.');
    }
}
