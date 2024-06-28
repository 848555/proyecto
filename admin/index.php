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

    <h1 class="text-center p-3">BIENVENIDO ADMIN <?php echo $_SESSION['usuario']; ?></h1>

    <!-- Botón para abrir el modal de agregar usuario -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#insertarUsuarioModal">Nuevo usuario</button>

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
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal<?= $datos->id_usuarios ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="/admin/eliminar.php?id=<?= $datos->id_usuarios ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>

                            <!-- Modal para editar usuario -->
                            <div class="modal fade" id="editarUsuarioModal<?= $datos->id_usuarios ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido del formulario de edición -->
                                            <form action="/admin/update.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $datos->id_usuarios ?>">
                                                <div class="mb-3">
                                                    <label for="nombres" class="form-label">Nombres</label>
                                                    <input type="text" class="form-control" name="nombres" value="<?= $datos->Nombres ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="apellidos" class="form-label">Apellidos</label>
                                                    <input type="text" class="form-control" name="apellidos" value="<?= $datos->Apellidos ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dni" class="form-label">DNI</label>
                                                    <input type="text" class="form-control" name="dni" value="<?= $datos->DNI ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                                                    <input type="date" class="form-control" name="fecha" value="<?= $datos->fecha_de_nacimiento ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="telefono" class="form-label">Teléfono</label>
                                                    <input type="text" class="form-control" name="telefono" value="<?= $datos->telefono ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="departamento" class="form-label">Departamento</label>
                                                    <input type="text" class="form-control" name="departamento" value="<?= $datos->Departamento ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ciudad" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control" name="ciudad" value="<?= $datos->Ciudad ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="direccion" class="form-label">Dirección</label>
                                                    <input type="text" class="form-control" name="direccion" value="<?= $datos->Direccion ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="usuario" class="form-label">Usuario</label>
                                                    <input type="text" class="form-control" name="usuario" value="<?= $datos->Usuario ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" name="password" value="<?= $datos->Password ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado</label>
                                                    <input type="text" class="form-control" name="estado" value="<?= $datos->Estado ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rol" class="form-label">Rol</label>
                                                    <input type="text" class="form-control" name="rol" value="<?= $datos->roles ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='13'>No hay usuarios registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar nuevo usuario -->
    <div class="modal fade" id="insertarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario de inserción -->
                    <form action="/admin/insertar.php" method="POST">
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" name="nombres">
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos">
                        </div>
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni">
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono">
                        </div>
                        <?php
        include("/xampp/htdocs/prueba/conexion/conexion.php");
        $sql = $conexion->query("SELECT id_departamentos,departamentos from departamentos");
        ?>
        <label for="exampleInputEmail1" class="form-label">DEPARTAMENTO</label>
        <select name="departamento" class="form-select form-select-sm">
            <?php
            while ($datos = mysqli_fetch_array($sql)) {
            ?>
                <option value="<?php echo $datos['departamentos'] ?>"><?php echo $datos['departamentos'] ?></option>

            <?php
            } ?>

        </select>
        <?php
        include("/xampp/htdocs/prueba/conexion/conexion.php");
        $sql = $conexion->query("SELECT *from ciudades");
        ?>
        <label for="exampleInputEmail1" class="form-label">CIUDAD</label>
        <select name="ciudad" class="form-select form-select-sm">
            <?php
            while ($datos = mysqli_fetch_array($sql)) {
            ?>
                <option value="<?php echo $datos['ciudades'] ?>"><?php echo $datos['ciudades'] ?></option>

            <?php
            } ?>

        </select>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion">
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="contraseña">
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" name="estado">
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <input type="text" class="form-control" name="rol">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/admin/js/buscador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
