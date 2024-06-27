<?php
session_start();
include "/xampp/htdocs/prueba/conexion/conexion.php";

// Verificar si el usuario está autenticado
$validar = $_SESSION['usuario'];

if (empty($validar)) {
    header("Location: ../../../login/login.php");
    exit();
}

// Verificar si se ha proporcionado el ID de usuario y de solicitud
if (!isset($_GET['id_usuario']) || empty($_GET['id_usuario']) || !isset($_GET['id_solicitud']) || empty($_GET['id_solicitud'])) {
    $_SESSION['error_message'] = "No se ha proporcionado el ID de usuario o de la solicitud.";
    header("Location: ../sermototaxista.php");
    exit();
}

$id_usuario = intval($_GET['id_usuario']); // Convertir a entero para seguridad
$id_solicitud = intval($_GET['id_solicitud']); // Convertir a entero para seguridad

// Obtener la solicitud y la retención correspondiente
$query = "SELECT * FROM solicitudes WHERE id_solicitud = ? AND estado = 'pendiente'";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_solicitud);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $solicitud = $result->fetch_assoc();
    $retencion_total = $solicitud['retencion_total'];
    
    // Actualizar el estado de la solicitud a 'aceptada'
    $sql_update = "UPDATE solicitudes SET estado='aceptada' WHERE id_solicitud=? AND id_usuarios=?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("ii", $id_solicitud, $id_usuario);

    if ($stmt_update->execute()) {
        // Insertar la retención en la tabla de retenciones
        $sql_insert_retencion = "INSERT INTO retenciones (id_usuarios, id_solicitud, retencion) VALUES (?, ?, ?)";
        $stmt_insert_retencion = $conexion->prepare($sql_insert_retencion);
        $stmt_insert_retencion->bind_param("iid", $id_usuario, $id_solicitud, $retencion_total);
        $stmt_insert_retencion->execute();
        $stmt_insert_retencion->close();

        // Insertar mensaje en la tabla de mensajes
        $mensaje = "Tu solicitud ha sido aceptada. Enseguida van por ti, espera en el lugar acordado.";
        $sql_insert_mensaje = "INSERT INTO mensajes_temporales (id_solicitud, id_usuario, mensaje, fecha) VALUES (?, ?, ?, NOW())";
        $stmt_insert = $conexion->prepare($sql_insert_mensaje);
        $stmt_insert->bind_param("iis", $id_solicitud, $id_usuario, $mensaje);
        $stmt_insert->execute();
        $stmt_insert->close();

        $_SESSION['success_message'] = "Solicitud aceptada correctamente y notificación enviada al solicitante.";
    } else {
        $_SESSION['error_message'] = "Error al aceptar la solicitud: " . $conexion->error;
    }

    $stmt_update->close();
} else {
    $_SESSION['error_message'] = "Solicitud no encontrada o ya aceptada.";
}

$stmt->close();
$conexion->close();

// Redirigir a la página de solicitudes
header("Location: ../sermototaxista.php");
exit();
?>
