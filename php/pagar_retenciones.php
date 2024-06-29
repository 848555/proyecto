<?php
session_start();
include "/xampp/htdocs/prueba/conexion/conexion.php";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['error_message'] = "No se ha iniciado sesión.";
    header("Location: ../../../../login/login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Inicializar $total_retencion
$total_retencion = 0;

// Obtener las retenciones pendientes si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simular el pago a través de Nequi (aquí deberías integrar la lógica real de pago)
    $numero_cuenta_empresa = "XXXXXXX"; // Número de cuenta de la empresa para Nequi
    $mensaje_usuario = "El número de cuenta para pagar las retenciones es: $numero_cuenta_empresa";

    // Marcar retenciones como pagadas (simulación)
    $sql_update = "UPDATE retenciones SET pagado = 1 WHERE id_usuarios = ? AND pagado = 0";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("i", $id_usuario);
    if ($stmt_update->execute()) {
        $_SESSION['success_message'] = "Retenciones pagadas correctamente. $mensaje_usuario";
    } else {
        $_SESSION['error_message'] = "Error al pagar las retenciones: " . $conexion->error;
    }
    $stmt_update->close();
    header("Location: pagar_retenciones.php");
    exit();
} else {
    // Obtener las retenciones pendientes si no es una solicitud POST
    $sql = "SELECT * FROM retenciones WHERE id_usuarios = ? AND pagado = 0";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $total_retencion += $row['retencion'];
    }
    $stmt->close();
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar Retenciones</title>
    <link rel="stylesheet" href="/php/css/retenciones.css">
</head>
<body>
   <div class="contenedor">
        <h1>Pagar Retenciones</h1>
        <?php if (isset($_SESSION['success_message'])): ?>
        <p class="messaje"><?php echo $_SESSION['success_message']; ?></p>
        <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
        <p class="messaje"><?php echo $_SESSION['error_message']; ?></p>
        <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?php if ($_SERVER['REQUEST_METHOD'] != 'POST'): ?>
        <p>Total de retenciones pendientes: <?php echo $total_retencion; ?> pesos</p>
        <form method="post" action="/php/pagar_retenciones.php">
            <button class="button" type="submit">Pagar Retenciones</button>
            <a class="regresar" href="/php/inicio.php">Regresar</a>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
