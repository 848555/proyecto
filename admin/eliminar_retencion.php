<?php
session_start();
include("/xampp/htdocs/prueba/conexion/conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para eliminar el registro
    $sql = $conexion->prepare("DELETE FROM retenciones WHERE id = ?");
    $sql->bind_param("i", $id);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($sql->execute()) {
        $_SESSION['mensaje'] = "Retención eliminada correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar la retención.";
    }

    // Cerrar la consulta
    $sql->close();
} else {
    $_SESSION['mensaje'] = "ID de retención no proporcionado.";
}

// Redirigir a la página de retenciones
header("Location: ver_retenciones.php");
exit();
?>
