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

// Consulta para obtener los documentos del usuario actual
$query = "SELECT * FROM documentos WHERE id_usuarios = ?";
// Preparar la consulta
$stmt = $conexion->prepare($query);

if (!$stmt) {
    die('Error al preparar la consulta: ' . $conexion->error);
}

// Vincular parámetros
$stmt->bind_param("i", $id_usuario);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado de la consulta
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener los datos del primer documento (asumiendo que solo debe haber uno por usuario)
    $documentos_moto = $result->fetch_assoc();
} else {
    $documentos_moto = null;
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
    <title>Documentos de los que quieren ser mototaxistas</title>
</head>
<body>
    <h2>Perfil <?php echo $_SESSION['usuario']; ?></h2>
    <?php if ($documentos_moto): ?>
        <p><strong>Placa:</strong> <?php echo $documentos_moto['placa']; ?></p>
        <p><strong>Marca:</strong> <?php echo $documentos_moto['marca']; ?></p>
        <p><strong>Modelo:</strong> <?php echo $documentos_moto['modelo']; ?></p>
        <p><strong>Color:</strong> <?php echo $documentos_moto['color']; ?></p>
        <p><strong>Licencia:</strong> <?php echo $documentos_moto['licencia_de_conducir']; ?></p>
        <p><strong>Tarjeta de propiedad:</strong> <?php echo $documentos_moto['tarjeta_de_propiedad']; ?></p>
        <p><strong>Soat:</strong> <?php echo $documentos_moto['soat']; ?></p>
        <p><strong>Tecnomecanica:</strong> <?php echo $documentos_moto['tecno_mecanica']; ?></p>
        
        <br>
        <a href="/php/inicio.php" class="btn btn-regresar">Regresar</a> <!-- Enlace para regresar -->
        <a href="#" class="btn btn-editar">Editar</a> <!-- Enlace para editar el perfil -->
    <?php else: ?>
        <p>Lo siento no se encontraron documentos para mostrar, no has subido documentos.</p>
    <?php endif; ?>
    <a  href="/php/inicio.php" class="btn-regresar">Regresar</a>
</body>
</html>
