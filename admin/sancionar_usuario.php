<?php
session_start();
include("/xampp/htdocs/prueba/conexion/conexion.php");

if (isset($_GET['id_retencion']) && isset($_GET['id_usuario'])) {
    $id_retencion = intval($_GET['id_retencion']);
    $id_usuario = intval($_GET['id_usuario']);

    // Validar que los valores sean válidos
    if ($id_retencion <= 0 || $id_usuario <= 0) {
        $_SESSION['mensaje'] = "Los parámetros id_retencion e id_usuario deben ser números positivos.";
        header("Location: ver_retenciones.php");
        exit();
    }

    // Verificar si la retención existe para ese usuario
    $query_check = "SELECT * FROM retenciones WHERE id = ? AND id_usuarios = ?";
    $stmt_check = $conexion->prepare($query_check);
    $stmt_check->bind_param("ii", $id_retencion, $id_usuario);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Actualizar estado del usuario a 'Sancionado'
        $query_update = "UPDATE usuarios SET Estado = 'Sancionado' WHERE id_usuarios = ?";
        $stmt_update = $conexion->prepare($query_update);
        $stmt_update->bind_param("i", $id_usuario);

        if ($stmt_update->execute()) {
            $_SESSION['mensaje'] = "El usuario con ID $id_usuario ha sido sancionado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al sancionar al usuario con ID $id_usuario: " . $stmt_update->error;
        }

        $stmt_update->close();
    } else {
        $_SESSION['mensaje'] = "No se encontró la retención correspondiente para la retención ID $id_retencion y usuario ID $id_usuario.";
    }

    $stmt_check->close();
} else {
    $_SESSION['mensaje'] = "Faltan parámetros necesarios para sancionar al usuario.";
}

$conexion->close();

header("Location: ver_retenciones.php");
exit();
?>
