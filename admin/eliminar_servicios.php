<?php
session_start();
require("/xampp/htdocs/prueba/conexion/conexion.php");

if (isset($_GET['id_solicitud'])) {
    $id_solicitud = $_GET['id_solicitud'];

    // Consulta SQL para eliminar las retenciones asociadas a la solicitud
    $sql_delete_retenciones = "DELETE FROM retenciones WHERE id_solicitud = ?";

    // Preparar la declaración para eliminar retenciones
    $stmt_delete_retenciones = $conexion->prepare($sql_delete_retenciones);

    if ($stmt_delete_retenciones) {
        // Vincular parámetros para la consulta de retenciones
        $stmt_delete_retenciones->bind_param("i", $id_solicitud);

        // Ejecutar la consulta para eliminar retenciones
        if ($stmt_delete_retenciones->execute()) {
            // Después de eliminar retenciones, proceder a eliminar la solicitud
            $sql_delete_solicitud = "DELETE FROM solicitudes WHERE id_solicitud = ?";

            // Preparar la declaración para eliminar la solicitud
            $stmt_delete_solicitud = $conexion->prepare($sql_delete_solicitud);

            if ($stmt_delete_solicitud) {
                // Vincular parámetros para la consulta de solicitud
                $stmt_delete_solicitud->bind_param("i", $id_solicitud);

                // Ejecutar la consulta para eliminar la solicitud
                if ($stmt_delete_solicitud->execute()) {
                    $_SESSION['mensaje'] = '<div class="alert alert-success" role="alert">La solicitud con id ' . $id_solicitud . ' y sus retenciones asociadas se eliminaron correctamente.</div>';
                } else {
                    $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">Error al eliminar la solicitud: ' . $stmt_delete_solicitud->error . '</div>';
                }

                // Cerrar la declaración preparada para solicitud
                $stmt_delete_solicitud->close();
            } else {
                $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">Error en la preparación de la consulta para eliminar la solicitud: ' . $conexion->error . '</div>';
            }
        } else {
            $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">Error al eliminar las retenciones asociadas a la solicitud: ' . $stmt_delete_retenciones->error . '</div>';
        }

        // Cerrar la declaración preparada para retenciones
        $stmt_delete_retenciones->close();
    } else {
        $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">Error en la preparación de la consulta para eliminar las retenciones: ' . $conexion->error . '</div>';
    }
} else {
    $_SESSION['mensaje'] = '<div class="alert alert-danger" role="alert">No se recibió el parámetro "id_solicitud" para eliminar la solicitud.</div>';
}

// Redireccionar a la página servicios_solicitados.php con el mensaje almacenado en la sesión
header("Location: servicios_solicitados.php");
exit(); // Asegurar que se detiene la ejecución después de redirigir
?>
