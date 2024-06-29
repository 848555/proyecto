<?php
session_start();
require("/xampp/htdocs/prueba/conexion/conexion.php");

// Verificar si hay un mensaje en la sesión
if (isset($_SESSION['mensaje'])) {
    // Mostrar el mensaje
    echo '<div class="alert alert-info">' . $_SESSION['mensaje'] . '</div>';
    
    // Limpiar el mensaje de la sesión para evitar que se muestre nuevamente
    unset($_SESSION['mensaje']);
}

// Consulta SQL para obtener las solicitudes de mototaxi con nombres y apellidos asociados
$sql = "SELECT s.id_solicitud, s.origen, s.destino, s.cantidad_personas, s.cantidad_motos, s.metodo_pago, s.estado, u.Nombres, u.Apellidos
        FROM solicitudes s
        INNER JOIN usuarios u ON s.id_usuarios = u.id_usuarios";

$resultado = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/admin/css/mototaxista.css">
    <script src="https://kit.fontawesome.com/35f3448c23.js" crossorigin="anonymous"></script>
    <title>SERVICIOS</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login/login.php?vista=logout">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h1 class="text-center p-3">SOLICITUDES DE MOTOTAXI</h1>
    <div class="container-fluid"><br>
        <form class="d-flex">
            <input class="form-control me-2 light-table-filter" data-table="table" type="text" placeholder="Buscar">
            <hr>
            <script>
                function eliminar() {
                    var respuesta = confirm("¿Estás seguro que quieres eliminar esta solicitud?");
                    return respuesta;
                }
            </script>
        </form>
    </div>

    <div class="container-fluid row m-auto">
        <div class="col-20 p-4 color-row ">
            <table class="table">
                <thead class="bg bg-info">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOMBRES</th>
                        <th scope="col">APELLIDOS</th>
                        <th scope="col">ORIGEN</th>
                        <th scope="col">DESTINO</th>
                        <th scope="col">CANTIDAD DE PERSONAS</th>
                        <th scope="col">CANTIDAD DE MOTOS</th>
                        <th scope="col">METODO DE PAGO</th>
                        <th scope="col">ESTADO</th>
     
                        <th scope="col">ACCION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado->num_rows > 0) {
                        while ($datos = $resultado->fetch_object()) {
                    ?>
                            <tr>
                                <td><?= $datos->id_solicitud ?></td>
                                <td><?= $datos->Nombres ?></td>
                                <td><?= $datos->Apellidos ?></td>
                                <td><?= $datos->origen ?></td>
                                <td><?= $datos->destino ?></td>
                                <td><?= $datos->cantidad_personas ?></td>
                                <td><?= $datos->cantidad_motos ?></td>
                                <td><?= $datos->metodo_pago ?></td>
                                <td><?= $datos->estado ?></td>
                                
                                <td>
                                    <a onclick="return eliminar()" href="/admin/eliminar_servicios.php?id_solicitud=<?= $datos->id_solicitud ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="10" class="text-center">No hay solicitudes registradas.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/admin/js/buscador.js"></script>
</body>
</html>
