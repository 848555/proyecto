<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    // Manejar el caso donde el usuario no está autenticado
    // Por ejemplo, redirigir a una página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Incluir la conexión a la base de datos
include_once "/xampp/htdocs/prueba/conexion/conexion.php"; // Asegúrate de que el nombre del archivo coincida con el de tu conexión

// Obtener el ID del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario

// Consulta para obtener los datos del perfil del usuario y los documentos asociados
$query = "SELECT * FROM usuarios WHERE id_usuarios = ?";
$stmt = $conexion->prepare($query);

if (!$stmt) {
    die('Error al preparar la consulta: ' . $conexion->error);
}

// Enlazar el parámetro y ejecutar la consulta
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    $perfil_usuario = $result->fetch_assoc();
} else {
    $perfil_usuario = null;
}

// Cerrar la consulta
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/php/css/perfil_style.css">
    <title>Perfil de Usuario</title>
</head>
<body>
    <div class="container">
        <h2>Perfil <?php echo $_SESSION['usuario']; ?></h2>
        <?php if ($perfil_usuario): ?>
            <p><strong>Nombres:</strong> <?php echo $perfil_usuario['Nombres']; ?></p>
            <p><strong>Apellidos:</strong> <?php echo $perfil_usuario['Apellidos']; ?></p>
            <p><strong>DNI:</strong> <?php echo $perfil_usuario['DNI']; ?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?php echo $perfil_usuario['fecha_de_nacimiento']; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $perfil_usuario['telefono']; ?></p>
            <p><strong>Departamento:</strong> <?php echo $perfil_usuario['Departamento']; ?></p>
            <p><strong>Ciudad:</strong> <?php echo $perfil_usuario['Ciudad']; ?></p>
            <p><strong>Dirección:</strong> <?php echo $perfil_usuario['Direccion']; ?></p>
            <p><strong>Usuario:</strong> <?php echo $perfil_usuario['Usuario']; ?></p>
            <p><strong>Contraseña:</strong> *********</p>
            <p><strong>Estado:</strong> <?php echo $perfil_usuario['Estado']; ?></p>

            <br>
            <a href="/php/inicio.php" class="btn btn-regresar">Regresar</a>
            <a href="#" class="btn btn-editar">Editar</a>
            <?php else: ?>
            <p>No se encontraron datos de perfil para el usuario.</p>
        <?php endif; ?>
    </div>
</body>
</html>
