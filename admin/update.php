<?php
// Iniciar sesión para utilizar $_SESSION
session_start();

// Conexión a la base de datos
require("/xampp/htdocs/prueba/conexion/conexion.php");

// Recibir datos del formulario
$id = $_POST["id"];
$nombres = mysqli_real_escape_string($conexion, $_POST["nombres"]);
$apellidos = mysqli_real_escape_string($conexion, $_POST["apellidos"]);
$dni = mysqli_real_escape_string($conexion, $_POST["dni"]);
$fecha = mysqli_real_escape_string($conexion, $_POST["fecha"]);
$telefono = mysqli_real_escape_string($conexion, $_POST["telefono"]);
$departamento = mysqli_real_escape_string($conexion, $_POST["departamento"]);
$ciudad = mysqli_real_escape_string($conexion, $_POST["ciudad"]);
$direccion = mysqli_real_escape_string($conexion, $_POST["direccion"]);
$estado = mysqli_real_escape_string($conexion, $_POST["estado"]);
$rol = mysqli_real_escape_string($conexion, $_POST["rol"]);

// Consulta para obtener los datos actuales del usuario
$sql_select = "SELECT * FROM usuarios WHERE id_usuarios='$id'";
$resultado_select = $conexion->query($sql_select);

if ($resultado_select->num_rows > 0) {
    $fila = $resultado_select->fetch_assoc();

    // Comparar cada campo y actualizar sólo si es diferente
    $update_fields = [];

    if ($nombres != $fila['Nombres']) {
        $update_fields[] = "Nombres='$nombres'";
    }
    if ($apellidos != $fila['Apellidos']) {
        $update_fields[] = "Apellidos='$apellidos'";
    }
    if ($dni != $fila['DNI']) {
        $update_fields[] = "DNI='$dni'";
    }
    if ($fecha != $fila['fecha_de_nacimiento']) {
        $update_fields[] = "fecha_de_nacimiento='$fecha'";
    }
    if ($telefono != $fila['telefono']) {
        $update_fields[] = "telefono='$telefono'";
    }
    if ($departamento != $fila['Departamento']) {
        $update_fields[] = "Departamento='$departamento'";
    }
    if ($ciudad != $fila['Ciudad']) {
        $update_fields[] = "Ciudad='$ciudad'";
    }
    if ($direccion != $fila['Direccion']) {
        $update_fields[] = "Direccion='$direccion'";
    }
    if ($estado != $fila['Estado']) {
        $update_fields[] = "Estado='$estado'";
    }
    if ($rol != $fila['rol']) {
        $update_fields[] = "rol='$rol'";
    }

    // Si hay campos para actualizar, realizar la consulta de actualización
    if (!empty($update_fields)) {
        $update_query = "UPDATE usuarios SET " . implode(', ', $update_fields) . " WHERE id_usuarios='$id'";
        $resultado_update = $conexion->query($update_query);

        if ($resultado_update) {
            $_SESSION['success_message'] = "<p style='color: green;'>Usuario actualizado correctamente.</p>";
            header("Location: ../../../admin/index.php");
            exit; // Asegurar que se detiene la ejecución después de redirigir
        } else {
            $_SESSION['error_message'] = "Error al actualizar el usuario: " . $conexion->error;
        }
    } else {
        // Si no hay campos para actualizar, redirigir directamente
        header("Location: ../../../admin/index.php");
        exit; // Asegurar que se detiene la ejecución después de redirigir
    }
} else {
    $_SESSION['error_message'] = "Usuario no encontrado.";
    header("Location: ../../../admin/index.php");
    exit; // Asegurar que se detiene la ejecución después de redirigir
}

// Cerrar la conexión
$conexion->close();
?>
