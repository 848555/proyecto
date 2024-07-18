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
// Obtener el ID del usuario de la sesión
$id_usuario_sesion = $_SESSION['id_usuario'];

// Consulta para obtener nombres, apellidos y DNI del usuario de la sesión
$sql_usuario_sesion = "SELECT Nombres, Apellidos, DNI FROM usuarios WHERE id_usuarios = ?";
$stmt_usuario_sesion = $conexion->prepare($sql_usuario_sesion);
$stmt_usuario_sesion->bind_param("i", $id_usuario_sesion);
$stmt_usuario_sesion->execute();
$result_usuario_sesion = $stmt_usuario_sesion->get_result();
$usuario_sesion = $result_usuario_sesion->fetch_assoc();

$sql_acciones = "SELECT id_usuarios FROM usuarios";
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
                    
                </ul>
            </div>
        </div>
    </nav>
    <h1 class="text-center p-3">SOLICITUDES DE MOTOTAXI</h1>
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
    }?>
     <!-- Botón para abrir el modal de registrar acciones -->
     <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#accionesModal">Intermediacion</button>

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
     <!-- Modal para acciones -->
<div class="modal fade" id="accionesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenido del formulario de registro de acción -->
                <form action="/admin/acciones_modal/registrar_acciones_soli.php" method="POST">
                <div class="mb-3">
                        <label for="id_administrador" class="form-label">ID del Administrador</label>
                        <input type="text" class="form-control" name="id_administrador" value="<?php echo isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : ''; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres del Administrador</label>
                        <input type="text" class="form-control" name="nombres" value="<?php echo isset($usuario_sesion['Nombres']) ? $usuario_sesion['Nombres'] : ''; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos del Administrador</label>
                        <input type="text" class="form-control" name="apellidos" value="<?php echo isset($usuario_sesion['Apellidos']) ? $usuario_sesion['Apellidos'] : ''; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">Documento del Administrador</label>
                        <input type="num" class="form-control" name="DNI" value="<?php echo isset($usuario_sesion['DNI']) ? $usuario_sesion['DNI'] : ''; ?>" readonly>
                    </div>
                    <div class="mb-3">
                            <label for="tipo_accion" class="form-label">Tipo de Intervención</label>
                            <select class="form-select" name="tipo_accion">
                                <option value="3">Eliminar Solicitud</option>
                            </select>
                        </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de la Acción</label>
                        <textarea class="form-control" name="descripcion" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="id_usuario_objetivo" id="id_usuario_objetivo">
                    <button type="submit" class="btn btn-primary">Registrar Acción</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/admin/js/buscador.js"></script>
</body>
</html>
