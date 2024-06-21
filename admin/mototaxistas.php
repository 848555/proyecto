<?php
include("/xampp/htdocs/prueba/conexion/conexion.php");

$sql = $conexion->query("
    SELECT d.id_documentos, 
           d.licencia_de_conducir, 
           d.tarjeta_de_propiedad, 
           d.soat, 
           d.tecno_mecanica, 
           d.placa, 
           d.marca, 
           d.modelo, 
           d.color, 
           u.nombres AS nombre_usuario, 
           u.apellidos AS apellido_usuario
    FROM documentos d
    INNER JOIN usuarios u ON d.id_usuarios = u.id_usuarios
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/admin/css/mototaxista.css">
    <script src="https://kit.fontawesome.com/35f3448c23.js" crossorigin="anonymous"></script>
    <title>DOCUMENTOS DE MOTOTAXISTAS</title>
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
    <h1 class="text-center p-3">DOCUMENTOS DE MOTOTAXISTAS</h1>
    <div class="container-fluid"><br>
        <form class="d-flex">
            <input class="form-control me-2 light-table-filter" data-table="table" type="text" placeholder="Buscar">
            <hr>
            <script>
                function eliminar() {
                    var respuesta = confirm("Estas seguro que quieres eliminar estos documentos?");
                    return respuesta
                }
            </script>
        </form>
    </div>

    <div class="container-fluid row m-auto">
        <div class="col-20 p-4 color-row ">
            <table class="table ">
                <thead class="bg bg-info ">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Licencia de conducir</th>
                        <th scope="col">TARGETA DE PROPIEDAD</th>
                        <th scope="col">SOAT</th>
                        <th scope="col">TECNO MECANICA</th>
                        <th scope="col">PLACA </th>
                        <th scope="col">MARCA</th>
                        <th scope="col">MODELO</th>
                        <th scope="col">COLOR</th>
                        <th scope="col">USUARIO QUE SUBIO LOS DOCUMENTOS</th>
                        <th scope="col">ACCION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($sql->num_rows > 0) {
                        while ($datos = $sql->fetch_object()) {
                    ?>
                            <tr>
                                <td><?= $datos->id_documentos ?></td>
                                <td><img src="http://localhost/prueba/documentos/imagen/<?= $datos->licencia_de_conducir ?>" width="100"></td>
                                <td><img src="http://localhost/prueba/documentos/imagen/<?= $datos->tarjeta_de_propiedad ?>" width="100"></td>
                                <td><img src="http://localhost/prueba/documentos/imagen/<?= $datos->soat ?>" width="100"></td>
                                <td><img src="http://localhost/prueba/documentos/imagen/<?= $datos->tecno_mecanica ?>" width="100"></td>
                                <td><?= $datos->placa ?></td>
                                <td><?= $datos->marca ?></td>
                                <td><?= $datos->modelo ?></td>
                                <td><?= $datos->color ?></td>
                                <td><?= $datos->nombre_usuario . ' ' . $datos->apellido_usuario ?></td>
                                <td>
                                    <a onclick="return eliminar()" href="/admin/eliminar_igm.php?id=<?= $datos->id_documentos ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                    <?php
                        }
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
