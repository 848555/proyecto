<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está autenticado
$validar = $_SESSION['usuario'];

// Si el usuario no está autenticado, redirigir al formulario de inicio de sesión
if ($validar == null || $validar == '') {
    header("Location:../login/login.php");
    die();
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/35f3448c23.js" crossorigin="anonymous"></script>
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
                        <a class="nav-link" href="/admin/mototaxistas.php">Mototaxistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/servicios_solicitados.php">Servicios solicitados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/ver_retenciones.php">Retenciones</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/login/login.php?vista=logout">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--mensaje  que sale al querer elimiar un usuario-->

    <h1 class="text-center p-3">BIENVENIDO ADMIN <?php echo $_SESSION['usuario']; ?></h1>

    <a class="btn btn-success " href="/admin/agregar_usuarios.php">Nuevo usuario </a> <br>
    <?php
    // Mostrar mensajes de error si existen
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger alert-message">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
    }

    // Mostrar mensaje de usuario actualizado si existe
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success alert-message">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']); // Limpiar el mensaje después de mostrarlo
    }
    // Mostrar mensaje de confirmación
    if (isset($_SESSION['confirm_message'])) {
        echo '<script>
            if (confirm("' . $_SESSION['confirm_message'] . '")) {
                window.location.href = "eliminar.php?id=' . $_GET['id'] . '&confirm=1";
            } else {
                window.location.href = "index.php";
            }
          </script>';
        unset($_SESSION['confirm_message']); // Limpiar el mensaje después de mostrarlo
    }

    ?>

    <div class="container-fluid"><br>
        <form class="d-flex">
            <input class="form-control me-2 light-table-filter" data-table="table" type="text" placeholder="Buscar">
            <hr>
        </form>
    </div>

    <div class="container-fluid row m-auto">

        <div class="col-20 p-4 color-row ">
            <table class="table ">
                <thead class="bg bg-info ">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOMBRES</th>
                        <th scope="col">APELLIDOS</th>
                        <th scope="col">DNI</th>
                        <th scope="col">FECHA DE NACIMIENTO</th>
                        <th scope="col">TELEFONO</th>
                        <th scope="col">DEPARTAMENTO</th>
                        <th scope="col">CIUDAD</th>
                        <th scope="col">DIRECCION</th>
                        <th scope="col">USUARIO</th>
                        <th scope="col">CONTRASEÑA</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ROL</th>
                        <th scope="col">ACCION</th>

                    </tr>
                </thead>
                <tbody>
                    <!--se tomas los datos de la base de datos en la tabla usuarios y se relaciona con la tabla roles-->

                    <?php
                    include("/xampp/htdocs/prueba/conexion/conexion.php");
                    $sql = $conexion->query("
    SELECT u.id_usuarios,
           u.nombres AS Nombres,
           u.apellidos AS Apellidos,
           u.DNI,
           u.fecha_de_nacimiento,
           u.telefono,
           u.Departamento,
           u.Ciudad,
           u.Direccion,
           u.Usuario,
           u.Password,
           u.Estado,
           r.roles
    FROM usuarios u
    INNER JOIN roles r ON u.rol = r.id
");


                    if ($sql->num_rows > 0) {
                        while ($datos = $sql->fetch_object()) {

                    ?>
                            <tr>
                                <td><?= $datos->id_usuarios ?></td>
                                <td><?= $datos->Nombres ?></td>
                                <td><?= $datos->Apellidos ?></td>
                                <td><?= $datos->DNI ?></td>
                                <td><?= $datos->fecha_de_nacimiento ?></td>
                                <td><?= $datos->telefono ?></td>
                                <td><?= $datos->Departamento ?></td>
                                <td><?= $datos->Ciudad ?></td>
                                <td><?= $datos->Direccion ?></td>
                                <td><?= $datos->Usuario ?></td>
                                <td><?= $datos->Password ?></td>
                                <td><?= $datos->Estado ?></td>
                                <td><?= $datos->roles ?></td>



                                <td>

                                    <a href="/admin/editar_usuarios.php?id=<?= $datos->id_usuarios ?>&estado=<?= $datos->Estado ?>&nombres=<?= $datos->Nombres ?>&apellidos=<?= $datos->Apellidos ?>&dni=<?= $datos->DNI ?>&fecha=<?= $datos->fecha_de_nacimiento ?>&telefono=<?= $datos->telefono ?>&departamento=<?= $datos->Departamento ?>&rol=<?= $datos->rol ?>&ciudad=<?= $datos->Ciudad ?>&direccion=<?= $datos->Direccion ?>&usuario=<?= $datos->Usuario ?>&contraseña=<?= $datos->Password ?>&rol=<?= $datos->rol ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="/admin/eliminar.php?id=<?= $datos->id_usuarios ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>

                                </td>
                            </tr>


                        <?php
                        }
                    } else {

                        ?>
                        <tr class="text-center">
                            <td colspan="16">No existen registros</td>
                        </tr>


                    <?php

                    }

                    ?>






                </tbody>
            </table>



        </div>

    </div>
    <script>
        // Función para ocultar automáticamente el mensaje después de 5 segundos
        function hideMessage() {
            setTimeout(function() {
                document.querySelectorAll('.alert-message').forEach(function(element) {
                    element.style.display = 'none';
                });
            }, 5000); // Ocultar después de 5 segundos (5000 ms)
        }

        // Llamar a la función para ocultar mensajes
        hideMessage();
    </script>

    <script src="/admin/js/buscador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>