<?php
// Iniciar sesión (si no está iniciada)
session_start();

// Incluir el archivo de conexión
include("/xampp/htdocs/prueba/conexion/conexion.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y asignar los datos del formulario a variables
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $dni = $_POST["dni"];
    $fecha = $_POST["fecha"];
    $telefono = $_POST["telefono"];
    $departamento = $_POST["departamento"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];
    $estado = $_POST["estado"];
    $rol = $_POST["rol"];

    // Verificar si el usuario ya existe
    $sql_usuario = "SELECT COUNT(*) as total FROM usuarios WHERE Usuario = ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param("s", $usuario);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();
    $row_usuario = $result_usuario->fetch_assoc();

    if ($row_usuario['total'] > 0) {
        $error_message .= "<p style='color: red;'>El usuario ya existe. Por favor, elija otro.</p>";
    }

    // Verificar si el teléfono ya existe
    $sql_telefono = "SELECT COUNT(*) as total FROM usuarios WHERE telefono = ?";
    $stmt_telefono = $conexion->prepare($sql_telefono);
    $stmt_telefono->bind_param("s", $telefono);
    $stmt_telefono->execute();
    $result_telefono = $stmt_telefono->get_result();
    $row_telefono = $result_telefono->fetch_assoc();

    if ($row_telefono['total'] > 0) {
        $error_message .= "<p style='color: red;'>El teléfono ya está registrado.</p>";
    }

    // Verificar si el DNI ya existe
    $sql_dni = "SELECT COUNT(*) as total FROM usuarios WHERE DNI = ?";
    $stmt_dni = $conexion->prepare($sql_dni);
    $stmt_dni->bind_param("s", $dni);
    $stmt_dni->execute();
    $result_dni = $stmt_dni->get_result();
    $row_dni = $result_dni->fetch_assoc();

    if ($row_dni['total'] > 0) {
        $error_message .= "<p style='color: red;'>El DNI ya está registrado.</p>";
    }

    // Si hay algún mensaje de error, lo almacenamos en sesión y redireccionamos
    if (!empty($error_message)) {
        $_SESSION['error_message'] = $error_message;

        // Guardar los datos del formulario en sesión para mantenerlos en caso de redireccionar
        $_SESSION['datos_formulario'] = compact('nombres', 'apellidos', 'dni', 'fecha', 'telefono', 'departamento', 'ciudad', 'direccion', 'usuario', 'contraseña', 'estado', 'rol');

        // Redireccionar de vuelta a la página de agregar_usuarios.php
        header("location: agregar_usuarios.php");
        exit();
    } else {
        // Preparar la consulta SQL para insertar los datos en la tabla usuarios
        $sql_insert = "INSERT INTO usuarios (Nombres, Apellidos, DNI, fecha_de_nacimiento, telefono, Departamento, Ciudad, Direccion, Usuario, Password, Estado, rol)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt_insert = $conexion->prepare($sql_insert);

        // Enlazar parámetros
        $stmt_insert->bind_param("ssssssssssss", $nombres, $apellidos, $dni, $fecha, $telefono, $departamento, $ciudad, $direccion, $usuario, $contraseña, $estado, $rol);

        // Ejecutar la consulta de inserción
        $resultados = $stmt_insert->execute();

        // Verificar si la consulta se ejecutó correctamente
        if ($resultados) {
            $_SESSION['success_message'] = "<p style='color: green;'>Registro insertado correctamente.</p>";
        } else {
            $_SESSION['error_message'] = "Error al ejecutar la consulta: " . $conexion->error;
        }

        // Cerrar la conexión
        $stmt_insert->close();
        $conexion->close();

        // Redirigir al usuario de vuelta a la página principal
        header("location: index.php");
        exit();
    }
}

?>