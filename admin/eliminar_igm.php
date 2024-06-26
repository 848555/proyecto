<?php
require("/xampp/htdocs/prueba/conexion/conexion.php");

// Iniciar sesión
session_start();

// Verificar si 'id' está configurado
if (isset($_GET['id'])) {
    // Obtener el valor de 'id' de forma segura
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id === false || $id === null) {
        $_SESSION['error'] = "El ID no es válido.";
    } else {
        // Preparar la consulta SQL
        $sql = "DELETE FROM documentos WHERE id_documentos = ?";
        $stmt = $conexion->prepare($sql);

        // Verificar si la preparación fue exitosa
        if ($stmt) {
            // Bind el parámetro 'id'
            $stmt->bind_param("i", $id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $_SESSION['success'] = "Registro eliminado exitosamente.";
            } else {
                $_SESSION['error'] = "Error al eliminar el registro: " . $stmt->error;
            }
        } else {
            $_SESSION['error'] = "Error al preparar la consulta: " . $conexion->error;
        }
    }
} else {
    $_SESSION['error'] = "ID no configurado.";
}

// Cerrar la conexión
$conexion->close();

// Redirigir
header("Location: mototaxistas.php");
exit();
?>
