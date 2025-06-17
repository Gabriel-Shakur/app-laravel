<?php

namespace App\Http\Controllers;

use App\Models\TmpCompra;
use App\Models\Producto;
use Illuminate\Http\Request;

class TmpCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function tmp_compras(Request $request){
        $producto = Producto::where('codigo',$request->codigo) ->first();
        
        $session_id = session()->getId();
                            
        if($producto){

            $tmp_compra_existe = TmpCompra::where('producto_id',$producto->id)
                                          ->where('session_id',$session_id)
                                          ->first();
            if($tmp_compra_existe){
                $tmp_compra_existe->cantidad += $request->cantidad;
                $tmp_compra_existe->save();
                return response()->json(['success'=>true,'message'=>'El producto fue encontrado']);
            }else{
                $tmp_compra = new TmpCompra();

                $tmp_compra->cantidad = $request->cantidad;
                $tmp_compra->producto_id = $producto->id;
                $tmp_compra->session_id = $session_id;
                $tmp_compra->save();

                return response ()->json(['success'=>true,'message'=>'El producto fue encontrado']);
            }
           

            

            
        }else{
                          return response ()->json(['success'=>false,'message'=>'El producto no fue encontrado']);
        }
        
           


    }

     
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
     * @param  \App\Models\TmpCompra  $tmpCompra
     * @return \Illuminate\Http\Response
     */
    public function show(TmpCompra $tmpCompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TmpCompra  $tmpCompra
     * @return \Illuminate\Http\Response
     */
    public function edit(TmpCompra $tmpCompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TmpCompra  $tmpCompra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TmpCompra $tmpCompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TmpCompra  $tmpCompra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       

        $tmp = TmpCompra::find($id);

         if ($tmp) {
        $tmp->delete();
        return response()->json(['success' => true]);
        } else {
        return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
      }


    }
}
