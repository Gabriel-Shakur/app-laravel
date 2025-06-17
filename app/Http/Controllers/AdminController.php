<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Categoria;
use App\Models\Compras;
use App\Models\Producto;
use App\Models\Proveedores;
use App\Models\Cliente;
use App\Models\Arqueo;
use App\Models\Venta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $empresa_id = Auth::user()->empresa_id;

        // Contadores para tarjetas
        $total_roles = Role::count();
        $total_usuarios = User::count();
        $total_categorias = Categoria::count();
        $total_productos = Producto::count();
        $total_proveedores = Proveedores::count();
        $total_compras = Compras::count();
        $total_clientes = Cliente::count();
        $total_arqueos = Arqueo::count();

        // Datos de la empresa
        $empresa = Empresa::where('id', $empresa_id)->first();

        // Ventas de esta empresa
        $ventas = Venta::where('empresa_id', $empresa_id)->get();

        // Preparar datos para el gráfico (por mes)
        $ventasPorMes = Venta::selectRaw('MONTH(fecha) as mes, COUNT(*) as cantidad, SUM(precio_total) as total')
            ->where('empresa_id', $empresa_id)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Etiquetas y valores para los gráficos
        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $labels = [];
        $ventasData = [];
        $costoData = [];

        foreach ($ventasPorMes as $venta) {
            $labels[] = $meses[$venta->mes];
            $ventasData[] = $venta->cantidad;
            $costoData[] = $venta->total;
        }

        return view('admin.index', compact(
            'empresa',
            'total_roles',
            'total_usuarios',
            'total_categorias',
            'total_productos',
            'total_proveedores',
            'total_compras',
            'total_clientes',
            'total_arqueos',
            'ventas',
            'labels',
            'ventasData',
            'costoData',
            'ventasPorMes'
        ));
    }
}

