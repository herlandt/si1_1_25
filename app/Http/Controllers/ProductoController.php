<?php

namespace App\Http\Controllers;

use App\Exports\Productoexport;
use App\Imports\Productoimport;
use App\Models\producto;
use App\Models\Compras;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los productos
        $productos = Producto::all();
        // Pasar tanto productos como compras a la vista
        return view('producto.index', compact('productos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function base64EncodeImage($path)
    {
        $imgData = file_get_contents(public_path($path));
        return 'data:image/jpeg;base64,' . base64_encode($imgData);
    }

    // En el controlador
    public function exportPdf()
    {
        // Obtener todos los productos
        $productos = Producto::all();

        // Pasar la función para convertir imágenes a Base64 a la vista
        $pdf = Pdf::loadView('producto.pdf', [
            'productos' => $productos,
            'base64EncodeImage' => function ($path) {
                // Ruta de la imagen predeterminada
                $defaultPath = public_path('img/imagendefecto.png');

                // Verificar si la imagen del producto existe, si no, usar la predeterminada
                $fullPath = file_exists(public_path($path)) ? public_path($path) : $defaultPath;

                // Convertir a base64 y retornar
                if (file_exists($fullPath)) {
                    $imgData = file_get_contents($fullPath);
                    return 'data:image/jpeg;base64,' . base64_encode($imgData);
                }

                return ''; // Retorna vacío si no se encuentra ninguna imagen
            }
        ]);

        // Mostrar el PDF en el navegador
        return $pdf->stream('productos.pdf');
    }





    public function import(Request $request)
    {
        $file = $request->file('documento');
        Excel::import(new Productoimport, $file);
        activity()
            ->causedBy(auth()->user())
            ->log('Se importaron productos');
        return back()->with('status', 'Productos importados con éxito');
    }
    public function export()
    {
        return Excel::download(new Productoexport(), 'productos.xlsx');
    }

    public function actualizarProductos(Request $request)
    {
        // Obtener todos los productos
        $productos = Producto::all();
        // Actualizar el estado de todos los productos a "activado"
        Producto::query()->update(['estado' => 'activado']);

        // Iterar a través de todos los productos
        foreach ($productos as $producto) {
            // Verificar si la cantidad del producto es 0
            if ($producto->cantidad == 0) {
                // Obtener la primera compra realizada para este producto (la más antigua) que no esté agotada
                $compra = Compras::where('producto_id', $producto->id)
                    ->where('estado', '!=', 'agotado')
                    ->oldest()
                    ->first();

                if ($compra) {
                    // Actualizar los datos del producto con los datos de la compra
                    $producto->nombre = $compra->nombre; // Actualizar el nombre si es necesario
                    $producto->precio = $compra->precioventa; // Usar el precio de venta de la compra
                    $producto->cantidad = $compra->cantidad; // Actualizar la cantidad desde la compra
                    $producto->estado = 'Actualizado'; // Ajustar el estado según corresponda
                    $producto->save();

                    // Marcar la compra como agotado
                    $compra->estado = 'agotado';
                    $compra->save();
                }
            }
        }
        activity()
            ->causedBy(auth()->user())
            ->performedOn($producto)
            ->log('Se actualizo un nuevo producto: ' . $producto->id . ' nombre:  ' . $producto->nombre);
        return redirect()->route('productos.index')->with('success', 'Productos actualizados correctamente con datos de las compras.');
    }






    public function store(Request $request)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'codigo' => 'required|string|max:155',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'estado' => 'required|in:activado,desactivado',
            'multimedia' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Validar el archivo multimedia
        ]);

        // Inicializar una variable para la ruta de la imagen
        $imagePath = 'default.png'; // Valor predeterminado en caso de que no se cargue una imagen

        // Verificar si se ha subido un archivo
        if ($request->hasFile('multimedia')) {
            $file = $request->file('multimedia');

            // Definir la ruta de destino
            $destinationPath = public_path('img');

            // Generar un nombre único para el archivo
            $fileName = time() . '-' . $file->getClientOriginalName();

            // Mover el archivo a la carpeta 'public/images'
            $file->move($destinationPath, $fileName);

            // Actualizar la ruta de la imagen
            $imagePath = 'img/' . $fileName;
        }

        // Crear un nuevo producto con los datos validados
        $producto = new Producto([
            'codigo' => $validatedData['codigo'],
            'nombre' => $validatedData['nombre'],
            'precio' => $validatedData['precio'],
            'cantidad' => $validatedData['cantidad'],
            'estado' => $validatedData['estado'],
            'img' => basename($imagePath), // Usar solo el nombre del archivo guardado
        ]);

        // Guardar el producto en la base de datos
        $producto->save();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($producto)
            ->log('Se creo un nuevo producto: ' . $producto->id . ' nombre:  ' . $producto->nombre);
        // Redirigir con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }








    /**
     * Display the specified resource.
     */
    public function show(producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        // Pasar el producto a la vista
        return view('producto.editar', ['producto' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validar la entrada del formulario
        $validated = $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'estado' => 'required|in:activo,desactivado',
            'multimedia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        // Inicializar una variable para la ruta de la imagen
        $imagePath = $producto->img; // Mantener la imagen actual por defecto

        // Verificar si se ha subido un archivo
        if ($request->hasFile('multimedia')) {
            $file = $request->file('multimedia');

            // Definir la ruta de destino
            $destinationPath = public_path('img');

            // Generar un nombre único para el archivo
            $fileName = time() . '-' . $file->getClientOriginalName();

            // Mover el archivo a la carpeta 'public/img'
            $file->move($destinationPath, $fileName);

            // Actualizar la ruta de la imagen
            $imagePath = $fileName;

            // Eliminar la imagen antigua si existe
            if ($producto->img && file_exists(public_path($producto->img))) {
                unlink(public_path($producto->img));
            }
        }

        // Actualizar los datos del producto en la base de datos
        $producto->update([
            'codigo' => $validated['codigo'],
            'nombre' => $validated['nombre'],
            'precio' => $validated['precio'],
            'cantidad' => $validated['cantidad'],
            'estado' => $validated['estado'],
            'img' => $imagePath, // Actualizar la ruta de la imagen
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($producto)
            ->log('Se edito un producto: ' . $producto->id);
        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Verificar si existe una imagen asociada
        if ($producto->img) {
            // Definir la ruta completa de la imagen
            $imagePath = public_path('img/' . $producto->img);

            // Verificar si el archivo existe antes de eliminarlo
            if (file_exists($imagePath)) {
                // Eliminar la imagen del almacenamiento
                unlink($imagePath);
            }
        }
        // Eliminar el producto de la base de datos
        $producto->delete();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($producto)
            ->log('Se elimino un producto: ' . $producto->id . ' nombre:  ' . $producto->nombre);
        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }
}
