<?php
session_start();
include("/xampp/htdocs/prueba/conexion/conexion.php");

// Preparar consulta SQL para obtener retenciones agrupadas por usuario
$query = "
    SELECT 
        retenciones.id,
        retenciones.id_usuarios,
        usuarios.Nombres,
        usuarios.Apellidos,
        usuarios.Estado,
        GROUP_CONCAT(retenciones.id_solicitud SEPARATOR ', ') AS id_solicitudes,
        SUM(retenciones.retencion) AS total_retencion,
        MAX(retenciones.fecha) AS fecha_ultima_retencion,
        MAX(retenciones.pagado) AS pagado
    FROM 
        retenciones
    INNER JOIN 
        usuarios ON retenciones.id_usuarios = usuarios.id_usuarios
    GROUP BY 
        retenciones.id_usuarios
";
$sql = $conexion->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/admin/css/mototaxista.css">
    <script src="https://kit.fontawesome.com/35f3448c23.js" crossorigin="anonymous"></script>
    <title>Retenciones de Usuarios</title>
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
    <h1 class="text-center p-3">Retenciones de Usuarios</h1>
    <div class="container-fluid"><br>
        <form class="d-flex">
            <input class="form-control me-2 light-table-filter" data-table="table" type="text" placeholder="Buscar">
            <hr>
            <script>
                function eliminar() {
                    return confirm("¿Estás seguro que quieres eliminar esta retención?");
                }

                function sancionar() {
                    return confirm("¿Estás seguro que quieres sancionar a este usuario?");
                }
            </script>
        </form>
    </div>

    <div class="container-fluid row m-auto">
        <div class="col-20 p-4 color-row">
            <table class="table">
                <thead class="bg bg-info">
                    <tr>
                        <th scope="col">ID Retención</th>
                        <th scope="col">ID Usuario</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">ID Solicitud(es)</th>
                        <th scope="col">Total Retención</th>
                        <th scope="col">Fecha Última Retención</th>
                        <th scope="col">Pagado</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($sql && $sql->num_rows > 0) {
                        while ($datos = $sql->fetch_object()) {
                    ?>
                            <tr>
                                <td><?= $datos->id ?></td>
                                <td><?= $datos->id_usuarios ?></td>
                                <td><?= $datos->Nombres ?></td>
                                <td><?= $datos->Apellidos ?></td>
                                <td><?= $datos->id_solicitudes ?></td>
                                <td><?= $datos->total_retencion ?></td>
                                <td><?= $datos->fecha_ultima_retencion ?></td>
                                <td><?= $datos->pagado ? 'Sí' : 'No' ?></td>
                                <td><?= $datos->Estado ?></td>
                                <td>
                                    <a onclick="return eliminar()" href="/admin/eliminar_retencion.php?id=<?= $datos->id ?>" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    <?php if (!$datos->pagado) { ?>
                                        <a onclick="return sancionar()" href="/admin/sancionar_usuario.php?id_usuario=<?= $datos->id_usuarios ?>&id_retencion=<?= $datos->id ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-exclamation-triangle"></i> Sancionar</a>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarEstadoModal<?= $datos->id ?>">Editar Estado</button>
                                    <?php } ?>
                                </td>
                            </tr>

                            <!-- Modal para editar estado -->
                            <div class="modal fade" id="editarEstadoModal<?= $datos->id ?>" tabindex="-1" aria-labelledby="editarEstadoModalLabel<?= $datos->id ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarEstadoModalLabel<?= $datos->id ?>">Editar Estado de Usuario</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/admin/editar_estado_usuario.php" method="POST">
                                                <input type="hidden" name="id_usuario" value="<?= $datos->id_usuarios ?>">
                                                <label for="estadoUsuario" class="form-label">Nuevo Estado:</label>
                                                <select class="form-select" id="estadoUsuario" name="estadoUsuario">
                                                    <option value="activo">Activo</option>
                                                    <option value="inactivo">Inactivo</option>
                                                </select>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="10" class="text-center">No hay retenciones registradas</td></tr>';
                    }
                    // Mostrar mensaje si existe
                    if (isset($_SESSION['mensaje'])) {
                        echo '<script>alert("' . $_SESSION['mensaje'] . '");</script>';
                        unset($_SESSION['mensaje']);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Incluye jQuery y scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/admin/js/buscador.js"></script>
</body>

</html>