@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenido {{ $empresa->nombre_empresa }}</h1>
    <hr>
@stop

@section('content')
    <div class="row">
        @php
            $boxes = [
                ['url' => '/admin/roles', 'color' => 'info', 'icon' => 'user-check', 'label' => 'Roles Registrados', 'count' => $total_roles, 'text' => 'Roles'],
                ['url' => '/admin/usuarios', 'color' => 'primary', 'icon' => 'user', 'label' => 'Usuarios Registrados', 'count' => $total_usuarios, 'text' => 'Usuarios'],
                ['url' => '/admin/categorias', 'color' => 'success', 'icon' => 'tags', 'label' => 'Categorías Registradas', 'count' => $total_categorias, 'text' => 'Categorías'],
                ['url' => '/admin/productos', 'color' => 'warning', 'icon' => 'list', 'label' => 'Productos Registrados', 'count' => $total_productos, 'text' => 'Productos'],
                ['url' => '/admin/proovedores', 'color' => 'danger', 'icon' => 'truck-loading', 'label' => 'Proveedores Registrados', 'count' => $total_proveedores, 'text' => 'Proveedores'],
                ['url' => '/admin/compras', 'color' => 'teal', 'icon' => 'shopping-cart', 'label' => 'Compras Registradas', 'count' => $total_compras, 'text' => 'Compras'],
                ['url' => '/admin/clientes', 'color' => 'purple', 'icon' => 'users', 'label' => 'Clientes Registrados', 'count' => $total_clientes, 'text' => 'Clientes'],
                ['url' => '/admin/arqueos', 'color' => 'orange', 'icon' => 'cash-register', 'label' => 'Arqueos Registrados', 'count' => $total_arqueos, 'text' => 'Arqueos'],
            ];
        @endphp

        @foreach($boxes as $box)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <a href="{{ url($box['url']) }}" class="info-box-icon bg-{{ $box['color'] }}">
                        <i class="fas fa-{{ $box['icon'] }}"></i>
                    </a>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ $box['label'] }}</span>
                        <span class="info-box-number">{{ $box['count'] }} {{ $box['text'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Aquí va el gráfico de ventas por mes --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ventas por Mes</h3>
                </div>
                <div class="card-body">
                    <canvas id="ventasChart" style="width:100%; height:400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Puedes agregar CSS personalizado aquí si quieres --}}
@stop

@section('js')
    {{-- Incluir Chart.js desde CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ventasPorMes = @json($ventasPorMes);

        const meses = ventasPorMes.map(item => {
            const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            return nombresMeses[item.mes - 1] || 'Mes ' + item.mes;
        });
        const cantidades = ventasPorMes.map(item => item.cantidad);
        const totales = ventasPorMes.map(item => item.total);

        const ctx = document.getElementById('ventasChart').getContext('2d');

        const ventasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [
                    {
                        label: 'Cantidad de Ventas',
                        data: cantidades,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Precio ($)',
                        data: totales,
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1500,
                    easing: 'easeOutBounce',
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
@stop
