<?php
session_start();
include "/xampp/htdocs/prueba/conexion/conexion.php";

// Verificar si el usuario está autenticado
$validar = $_SESSION['usuario'];

if ($validar == null || $validar == '') {
    header("Location: ../../../login/login.php");
    die();
}

// Verificar si se ha proporcionado el ID de usuario y de solicitud
if (!isset($_GET['id_usuario']) || empty($_GET['id_usuario']) || !isset($_GET['id_solicitud']) || empty($_GET['id_solicitud'])) {
    $_SESSION['error_message'] = "No se ha proporcionado el ID de usuario o de la solicitud.";
    header("Location: ../sermototaxista.php"); // Redirigir a la página de solicitudes
    exit;
}

$id_usuario = $_GET['id_usuario'];
$id_solicitud = $_GET['id_solicitud'];

// Actualizar el estado de la solicitud a 'aceptada'
$sql_update = "UPDATE solicitudes SET estado='aceptada' WHERE id_solicitud=? AND id_usuarios=?";
$stmt = $conexion->prepare($sql_update);
$stmt->bind_param("ii", $id_solicitud, $id_usuario);

if ($stmt->execute()) {
    // Insertar mensaje en la tabla de mensajes
    $mensaje = "Tu solicitud ha sido aceptada. Enseguida van por ti, espera en el lugar acordado.";
    $sql_insert_mensaje = "INSERT INTO mensajes_temporales (id_solicitud, id_usuario, mensaje, fecha) VALUES (?, ?, ?, NOW())";
    $stmt_insert = $conexion->prepare($sql_insert_mensaje);
    $stmt_insert->bind_param("iis", $id_solicitud, $id_usuario, $mensaje);
    $stmt_insert->execute();
    $stmt_insert->close();

    // Mensaje de éxito para el usuario que aceptó la solicitud
    $_SESSION['success_message'] = "Solicitud aceptada correctamente y notificación enviada al solicitante.";
    header("Location: ../sermototaxista.php"); // Redirigir a la página de solicitudes
    exit;
} else {
    $_SESSION['error_message'] = "Error al aceptar la solicitud: " . $conexion->error;
    header("Location: ../sermototaxista.php"); // Redirigir a la página de solicitudes
    exit;
}

$stmt->close();
$conexion->close();
?>
