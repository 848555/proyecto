<?php
session_start();
include("/xampp/htdocs/prueba/conexion/conexion.php");

if (isset($_GET['id_retencion'])) {
    $id_retencion = intval($_GET['id_retencion']); // ID de la retención

    // Consulta preparada para obtener el ID de usuario desde la tabla de retenciones
    $query = "SELECT id_usuarios FROM retenciones WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_retencion);

    if ($stmt->execute()) {
        $stmt->bind_result($id_usuario);
        $stmt->fetch();
        $stmt->close();

        // Consulta preparada para sancionar al usuario específico
        $query_sancion = "UPDATE usuarios SET Estado = 'Sancionado' WHERE id_usuarios = ?";
        $stmt_sancion = $conexion->prepare($query_sancion);
        $stmt_sancion->bind_param("i", $id_usuario);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt_sancion->execute()) {
            $_SESSION['mensaje'] = "Usuario sancionado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al sancionar al usuario.";
        }

        // Cerrar la consulta
        $stmt_sancion->close();
    } else {
        $_SESSION['mensaje'] = "Error al obtener el ID de usuario desde la tabla de retenciones.";
    }

} else {
    $_SESSION['mensaje'] = "ID de retención no proporcionado.";
}

// Cerrar la conexión
$conexion->close();

// Redirigir a la página de retenciones
header("Location: ver_retenciones.php");
exit();
?>
