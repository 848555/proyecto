<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("/xampp/htdocs/prueba/conexion/conexion.php");

    // Validar y limpiar los datos del formulario
    $id_usuario = intval($_POST['id_usuario']); // ID del usuario a actualizar
    $nuevo_estado = $_POST['estadoUsuario']; // Nuevo estado a asignar

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
    $conexion->close();

    // Redirigir a la página deseada
    header("Location: ver_retenciones.php");
    exit();
} else {
    $_SESSION['mensaje'] = 'Acceso denegado.';
    header("Location: ver_retenciones.php");
    exit();
}
?>
