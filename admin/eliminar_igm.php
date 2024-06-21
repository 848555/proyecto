<?php
require("/xampp/htdocs/prueba/conexion/conexion.php");

// Verificar si 'id' está configurado
if (isset($_GET['id'])) {
    // Obtener el valor de 'id' de forma segura
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id === false || $id === null) {
        echo "El ID no es válido.";
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
                // Redirigir si la eliminación fue exitosa
                header("Location: mototaxistas.php");
                exit();
            } else {
                echo "Error al eliminar el registro: " . $stmt->error;
            }
        } else {
            echo "Error al preparar la consulta: " . $conexion->error;
        }
    }
} else {
    echo "ID no configurado.";
}

// Cerrar la conexión
$conexion->close();
?>
