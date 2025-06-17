<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;




class ArqueoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arqueos = Arqueo::all();
        return view('admin.arqueos.index',compact('arqueos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.arqueos.create');
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
          'fecha_apertura' => 'required|date',
          'monto_inicial' => 'required|numeric',
          'descripcion' => 'nullable|string|max:255',
        ]);

      Arqueo::create([
         'fecha_apertura' => $request->fecha_apertura,
         'monto_inicial' => $request->monto_inicial,
         'descripcion' => $request->descripcion,
         'empresa_id' => auth()->user()->empresa_id,
      ]);

      return redirect()->route('admin.arqueos.index')->with('success', 'Arqueo creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Arqueo  $arqueo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $arqueo = Arqueo::findorFail($id);

        return view('admin.arqueos.show',compact('arqueo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Arqueo  $arqueo
     * @return \Illuminate\Http\Response
     */
    public function edit(Arqueo $arqueo, $id)
    {
        $arqueo = Arqueo::find($id)->first();

        return view('admin.arqueos.edit',compact('arqueo'));
    }

    public function ingresoegreso($id)
    {
        $arqueo = Arqueo::with('movimientos')->findOrFail($id);

       return view('admin.arqueos.ingreso-egreso', compact('arqueo'));

    }

    public function guardarMovimiento(Request $request, $id)
    {
        $request->validate([
          'fecha' => 'required|date',
          'tipo' => 'required|in:ingreso,egreso',
          'monto' => 'required|numeric|min:0.01',
          'descripcion' => 'nullable|string|max:255',
      ]);

       $arqueo = Arqueo::findOrFail($id);

       $arqueo->movimientos()->create([
          'fecha' => $request->fecha,
          'tipo' => $request->tipo,
          'monto' => $request->monto,
          'descripcion' => $request->descripcion,
       ]);

     return redirect()->route('admin.arqueos.ingresoegreso', $id)
        ->with('success', 'Movimiento registrado correctamente.');
    }

    public function cerrarForm($id)
   {
      $arqueo = Arqueo::findOrFail($id);
      return view('admin.arqueos.cierre', compact('arqueo'));
   }

   public function cerrar(Request $request, $id)
   {
      $request->validate([
           'monto_final' => 'required|numeric|min:0',
           
       ]);

       $arqueo = Arqueo::findOrFail($id);
       $arqueo->fecha_cierre = Carbon::now();
       $arqueo->monto_final = $request->monto_final;
       
       $arqueo->save();

      return redirect()->route('admin.arqueos.index')->with('success', 'Caja cerrada correctamente.');
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Arqueo  $arqueo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
           'fecha_apertura' => 'required|date',
           'monto_inicial' => 'required|numeric',
          'descripcion' => 'nullable|string|max:255',
        ]);

    
      $arqueo = Arqueo::findOrFail($id);

   
      $arqueo->update([
           'fecha_apertura' => $request->fecha_apertura,
           'monto_inicial' => $request->monto_inicial,
           'descripcion' => $request->descripcion,
        ]);

     return redirect()->route('admin.arqueos.index')->with('success', 'Arqueo actualizado correctamente.');
    }

    public function reporte($id)
   {
       $arqueo = Arqueo::with('movimientos')->findOrFail($id);

       $ingresos = $arqueo->movimientos->where('tipo', 'ingreso')->sum('monto');
       $egresos = $arqueo->movimientos->where('tipo', 'egreso')->sum('monto');
       $total = $arqueo->monto_inicial + $ingresos - $egresos;

       $pdf = Pdf::loadView('admin.arqueos.reporte', compact('arqueo', 'ingresos', 'egresos', 'total'));
       return $pdf->download('reporte_arqueo_'.$arqueo->id.'.pdf');
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Arqueo  $arqueo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arqueo $arqueo)
    {
        //
    }
}
