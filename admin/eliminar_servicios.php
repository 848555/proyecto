<?php
session_start();
require("/xampp/htdocs/prueba/conexion/conexion.php");

if (isset($_GET['id_solicitud'])) {
    $id_solicitud = $_GET['id_solicitud'];

    // Consulta SQL para eliminar la solicitud
    $sql = "DELETE FROM solicitudes WHERE id_solicitud = ?";

    // Preparar la declaración
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("i", $id_solicitud);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = '<div class="alert alert-success" role="alert">La solicitud con id ' . $id_solicitud . ' se eliminó correctamente.</div>';
        } else {
            $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">Error al eliminar la solicitud: ' . $stmt->error . '</div>';
        }

        // Cerrar la declaración preparada
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">Error en la preparación de la consulta: ' . $conexion->error . '</div>';
    }
} else {
    $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">No se recibió el parámetro "id_solicitud" para eliminar la solicitud.</div>';
}

// Redireccionar a la página servicios_solicitados.php con el mensaje almacenado en la sesión
header("Location: servicios_solicitados.php");
exit(); // Asegurar que se detiene la ejecución después de redirigir
?>
