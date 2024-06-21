<?php
include("/xampp/htdocs/prueba/conexion/conexion.php");
session_start();

// Verifica que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso no autorizado");
}

// Definir la variable $user_id desde la sesión
$user_id = $_SESSION['id_usuario'];

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nueva_contraseña = $_POST['nueva_contraseña'];

    // Preparar la declaración SQL para evitar inyección SQL
    $stmt = $conexion->prepare("UPDATE usuarios SET Password = ? WHERE id_usuarios = ?");
    $stmt->bind_param("si", $nueva_contraseña, $user_id);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Contraseña actualizada exitosamente
        $_SESSION['mensaje'] = "Contraseña actualizada exitosamente.";
        header("location:../../../../login/login.php");
        exit();
    } else {
        // Error al actualizar la contraseña
        $_SESSION['error'] = "Error al actualizar la contraseña: " . $stmt->error;
        header("location:../../../../login/login.php");
        exit();
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conexion->close();
} else {
    // Si no es una solicitud POST, redireccionar de vuelta al formulario
    header("location: ../../cambiar_contraseña.php");
    exit();
}
?>
