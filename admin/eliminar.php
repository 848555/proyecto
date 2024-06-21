<?php
session_start();

// Verificar si el usuario está autenticado
$validar = $_SESSION['usuario'];

// Si el usuario no está autenticado, redirigir al formulario de inicio de sesión
if ($validar == null || $validar == '') {
    header("Location: ../../../login/login.php");
    die();
}

// Verificar si se ha proporcionado un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "Error: ID de usuario no válido.";
    header("Location: index.php"); // Redirigir a la página de inicio
    exit();
}

// Obtener el ID del usuario a eliminar
$id_usuario = $_GET['id'];

// Confirmar eliminación
if (isset($_GET['confirm'])) {
    require("/xampp/htdocs/prueba/conexion/conexion.php");

    // Eliminar el usuario
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id_usuarios = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Usuario eliminado correctamente.";
    } else {
        $_SESSION['error_message'] = "Error al eliminar el usuario.";
    }

    $stmt->close();
    $conexion->close();

    // Redirigir a la página de inicio con el mensaje correspondiente
    header("Location: index.php");
    exit();
}

// Mostrar mensaje de confirmación
$_SESSION['confirm_message'] = "¿Estás seguro que quieres eliminar a este usuario?";
header("Location: index.php?id=$id_usuario&confirm=1");
exit();
?>
