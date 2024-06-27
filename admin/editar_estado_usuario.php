<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("/xampp/htdocs/prueba/conexion/conexion.php");

    // Validar y limpiar los datos del formulario
    $id_retencion = intval($_POST['id_retencion']); // ID de la retención
    $nuevo_estado = $_POST['estadoUsuario']; // Nuevo estado a asignar

    // Consulta preparada para obtener el ID de usuario desde la tabla de retenciones
    $query = "SELECT id_usuarios FROM retenciones WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_retencion);
    
    if ($stmt->execute()) {
        $stmt->bind_result($id_usuario);
        $stmt->fetch();
        $stmt->close();

        // Consulta preparada para actualizar el estado del usuario
        $query_update = "UPDATE usuarios SET Estado = ? WHERE id_usuarios = ?";
        $stmt_update = $conexion->prepare($query_update);
        $stmt_update->bind_param("si", $nuevo_estado, $id_usuario);

        if ($stmt_update->execute()) {
            $_SESSION['mensaje'] = 'Estado de usuario actualizado correctamente a ' . $nuevo_estado . '.';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el estado de usuario: ' . $stmt_update->error;
        }

        $stmt_update->close();
    } else {
        $_SESSION['mensaje'] = 'Error al obtener el ID de usuario desde la tabla de retenciones.';
    }

    // Cerrar la conexión
    $conexion->close();

    // Redirigir a la página deseada
    header("Location: retenciones.php");
    exit();
} else {
    $_SESSION['mensaje'] = 'Acceso denegado.';
    header("Location: retenciones.php");
    exit();
}
?>
