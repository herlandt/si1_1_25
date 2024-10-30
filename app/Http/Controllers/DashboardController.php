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
use Carbon\Carbon;

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

    // Obtener la última fecha de compra o asignar una fecha por defecto
    $ultimaFechaCompra = Compras::latest('created_at')->value('created_at') ?? Carbon::now();
    $ultimaFechaCompra = Carbon::parse($ultimaFechaCompra)->format('Y-m-d');

    // Obtener la fecha actual
    $fechaActual = Carbon::now()->format('Y-m-d');

    // Obtener las fechas de inicio y fin del request o usar las fechas por defecto
    $fechaInicio = $request->input('fecha_inicio', $ultimaFechaCompra);
    $fechaFin = $request->input('fecha_fin', $fechaActual);
    $fechaInicioCompleta = $fechaInicio . ' 00:00:00';
    $fechaFinCompleta = $fechaFin . ' 23:59:59';
    // Filtrar ventas, compras, y gastos según las fechas y calcular los datos necesarios
    if ($fechaInicio && $fechaFin) {
        $fechaInicioCompleta = $fechaInicio . ' 00:00:00';
        $fechaFinCompleta = $fechaFin . ' 23:59:59';

        $ventas = Ventas::whereBetween('created_at', [$fechaInicioCompleta, $fechaFinCompleta])->sum('total');
        $compras = Compras::whereBetween('created_at', [$fechaInicioCompleta, $fechaFinCompleta])->sum('total');
        $gastos = Gastos::whereBetween('created_at', [$fechaInicioCompleta, $fechaFinCompleta])->sum('total');

        $ventasrealizadas = Ventas::whereBetween('created_at', [$fechaInicioCompleta, $fechaFinCompleta])->get();
        $ganancias = $this->calcularGanancias($fechaInicioCompleta, $fechaFinCompleta) - $gastos;
    } else {
        $ventas = Ventas::sum('total');
        $compras = Compras::sum('total');
        $gastos = Gastos::sum('total');
        $ventasrealizadas = Ventas::all();
        $ganancias = $this->calcularGanancias() - $gastos;
    }

    // Obtener lista completa de productos
     // Filtrar productos por cantidad vendida en el rango de fechas
     $productos = DB::table('productos')
     ->join('detalleventas', 'productos.id', '=', 'detalleventas.producto_id')
     ->whereBetween('detalleventas.created_at', [$fechaInicioCompleta, $fechaFinCompleta])
     ->select('productos.id', 'productos.nombre', 'productos.precio', DB::raw('SUM(detalleventas.cantidad) as cantidad_vendida'))
     ->groupBy('productos.id', 'productos.nombre', 'productos.precio')
     ->orderByDesc('cantidad_vendida')
     ->get();

    $clientes = Cliente::count();
    $usuario = User::count();

    $ventasPorFecha = Ventas::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
        ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicioCompleta, $fechaFinCompleta) {
            return $query->whereBetween('created_at', [$fechaInicioCompleta, $fechaFinCompleta]);
        })
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('fecha')
        ->get();

    $fechas = $ventasPorFecha->pluck('fecha')->toArray();
    $totalesVentas = $ventasPorFecha->pluck('total')->toArray();
    return view('pages.dashboard.dashboard', compact(
        'dataFeed',
        'ventas',
        'usuario',
        'compras',
        'gastos',
        'ganancias',
        'clientes',
        'productos', // Ahora contiene la cantidad total vendida por producto
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
