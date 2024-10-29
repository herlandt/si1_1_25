<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;
use App\Models\Ventas;
use App\Models\producto;
use App\Models\User;
use App\Models\cliente;
use App\Models\Compras;
use App\Models\Detalleventas;
use App\Models\Gastos;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function calcularGanancias($fechaInicio = null, $fechaFin = null)
{
    // Almacenar la ganancia total
    $gananciaTotal = 0;

    // Obtener todos los productos
    $productos = Producto::all();

    foreach ($productos as $producto) {
        // Crear la consulta para las ventas del producto
        $ventasQuery = Detalleventas::where('producto_id', $producto->id);

        // Aplicar filtro de fechas si se proporcionan
        if ($fechaInicio && $fechaFin) {
            // Asegurar que las fechas cubran todo el día
            $ventasQuery->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }

        // Obtener las ventas filtradas (o todas si no hay fechas)
        $ventas = $ventasQuery->get();

        foreach ($ventas as $venta) {
            // Calcular el precio unitario de venta
            $precioVentaUnitario = $venta->monto / $venta->cantidad;

            // Usar el `preciocompra` almacenado en `detalleventas`
            $precioCompra = $venta->preciocompra ?? 0;
            
            // Asegurarse de que los precios sean numéricos
            $precioVentaUnitario = is_numeric($precioVentaUnitario) ? $precioVentaUnitario : 0;
            $precioCompra = is_numeric($precioCompra) ? $precioCompra : 0;

            // Calcular la ganancia por unidad y total de ganancia para este producto
            $gananciaPorUnidad = $precioVentaUnitario - $precioCompra;
            $gananciaTotalProducto = $gananciaPorUnidad * $venta->cantidad;

            // Acumular la ganancia total
            $gananciaTotal += $gananciaTotalProducto;
        }
    }

    return round($gananciaTotal, 2); // Retornar el resultado final redondeado a 2 decimales
}



    public function index(Request $request)
    {
        $dataFeed = new DataFeed();

        // Obtener las fechas de inicio y fin del request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Si hay fechas, filtrar las ventas, compras, y gastos en el rango; si no, mostrar todos
        if ($fechaInicio && $fechaFin) {
            // Ajustar las fechas para asegurar que cubran todo el rango del día
            $fechaInicio = $fechaInicio . ' 00:00:00';
            $fechaFin = $fechaFin . ' 23:59:59';

            // Filtrar ventas, compras y gastos por fechas
            $ventas = Ventas::whereBetween('created_at', [$fechaInicio, $fechaFin])->sum('total');
            $compras = Compras::whereBetween('created_at', [$fechaInicio, $fechaFin])->sum('total');
            $gastos = Gastos::whereBetween('created_at', [$fechaInicio, $fechaFin])->sum('total');

            // Filtrar las ventas realizadas
            $ventasrealizadas = Ventas::whereBetween('created_at', [$fechaInicio, $fechaFin])->get();

            // Calcular ganancias usando la nueva lógica con fechas, y restar gastos
            $ganancias = $this->calcularGanancias($fechaInicio, $fechaFin) - $gastos;
        } else {
            // Mostrar todos los datos si no se especifica un rango
            $ventas = Ventas::sum('total');
            $compras = Compras::sum('total');
            $gastos = Gastos::sum('total');
            $ventasrealizadas = Ventas::all();

            // Calcular ganancias sin fechas, y restar gastos
            $ganancias = $this->calcularGanancias() - $gastos;
        }

        // Calcular la sumatoria de (precio * cantidad) para todos los productos
        $productos = Producto::sum(DB::raw('precio * cantidad'));

        // Contar la cantidad de clientes y usuarios
        $clientes = Cliente::count();
        $usuario = User::count();

        $ventasPorFecha = Ventas::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
            })
            ->groupBy(DB::raw('DATE(created_at)'))  // Agrupamos solo por la fecha
            ->orderBy('fecha')
            ->get();

        // Transformamos los datos para usarlos en Chart.js
        $fechas = $ventasPorFecha->pluck('fecha')->toArray();
        $totalesVentas = $ventasPorFecha->pluck('total')->toArray();

        // Retornar los datos a la vista
        return view('pages/dashboard/dashboard', compact(
            'dataFeed',
            'ventas',
            'usuario',
            'compras',
            'gastos',      // Incluimos el total de gastos
            'ganancias',
            'clientes',
            'productos',
            'ventasrealizadas',
            'fechaInicio',
            'fechaFin',
            'fechas',
            'totalesVentas'
        ));
    }






    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
