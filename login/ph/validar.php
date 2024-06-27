<?php
include("/xampp/htdocs/prueba/conexion/conexion.php");

// Iniciar la sesión
session_start();

// Verificar si existen las claves 'usuario' y 'password' en el POST
if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta SQL de forma segura para prevenir inyecciones SQL
    $consulta = "SELECT * FROM usuarios WHERE Usuario=? AND Password=?";
    $stmt = mysqli_prepare($conexion, $consulta);

    // Verificar si la preparación de la consulta fue exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "ss", $usuario, $password);
    mysqli_stmt_execute($stmt);

    // Obtener el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Verificar si la consulta se ejecutó correctamente
    if (!$resultado) {
        die("Error en la ejecución de la consulta: " . mysqli_error($conexion));
    }

    $filas = mysqli_fetch_array($resultado);

    // Verificar el resultado de la consulta
    if ($filas) {
        // Verificar el estado del usuario
        $estado_usuario = $filas['Estado'];

        if ($estado_usuario == 'Sancionado') {
            $_SESSION['error'] = "El usuario está sancionado y no puede iniciar sesión.";
            header('Location: ../login.php');
            exit();
        } 
         elseif ($estado_usuario == 'Inactivo') {
            $_SESSION['error'] = "El usuario está inactivo y no puede iniciar sesión.";
            header('Location: ../login.php');
            exit();
        }

        // Guardar datos en la sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id_usuario'] = $filas['id_usuarios'];
        $_SESSION['rol'] = $filas['rol'];

        // Redirigir según el rol del usuario
        if ($filas['rol'] == 1) { // administrador
            header('Location: ../../../../admin/index.php');
            exit();
        } elseif ($filas['rol'] == 2) { // usuario
            $_SESSION['mensaje'] = "¡Inicio de sesión exitoso!";
            header('Location: ../../../../php/inicio.php');
            exit();
        }
    } else {
        // Manejar inicio de sesión incorrecto  
        $_SESSION['error'] = "Error: El usuario o la contraseña son incorrectos, por favor verifica e intenta de nuevo.";
        header('Location: ../login.php');
        exit();
    }
} else {
    // Manejar datos POST faltantes
    header("Location: ../login.php");
    exit();
}
?>
