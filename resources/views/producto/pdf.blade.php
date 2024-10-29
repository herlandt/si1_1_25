<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Mecanico - Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffff;
        }

        h3 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #2f295f;
            color: #fff;
        }

        th,
        td {
            padding: 10px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        p {
            padding: 30px 15px;
        }

        th {
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #fff;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }

        .descripcion {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .descripcion p {
            margin: 4px 0;
            font-size: 24px;
            /* Mucho más grande para el nombre del producto */
            font-weight: bold;
        }

        .descripcion span {
            color: #555;
            font-size: 22px;
            /* Mucho más grande para el precio */
        }

        .texto-pequeno {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div>
        <span>C.I. INGENIERIA EN SISTEMAS</span>
    </div>
    <span class="texto-pequeno">FICCT - UAGRM</span>

    <h3>Catálogo de Productos</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Producto</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($productos as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        <img src="{{ $base64EncodeImage('img/' . ($p->img ?? 'imagendefecto.png')) }}"
                            alt="Imagen del producto" style="width: 100px; height: auto;">
                    </td>
                    <td class="descripcion">
                        <p>{{ $p->nombre }} | <span>Precio:</span> {{ $p->precio }} Bs</p>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach

        </tbody>
    </table>
</body>

</html>
