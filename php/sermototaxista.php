<?php 

session_start();

// Verificar si el usuario tiene acceso al contenido de esta página
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 2) {
    // Redireccionar a la página de inicio de sesión si no hay sesión iniciada o el rol no es correcto
    header("Location: /php/login.php");
    exit;
}

$user_id = $_SESSION['id_usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/php/css/sermototaxista.css"> <!-- Enlace a estilos CSS -->
    <style>
      
    </style>
    <title>Aceptar servicio</title>
</head>
<body>

    <div class="contenedor">
        <form id="verSolicitudes" action="/php/procesar/aceptar_solicitud.php" method="post">
        <a href="/php/inicio.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>&uid=<?php echo uniqid(); ?>">
    <img src="/php/css/imagenes/images.png" alt="" class="retroceder">
</a>
        <h1>Solicitudes Por aceptar</h1><br>
            <?php
            if (isset($_SESSION['success_message'])) {
                echo "<div id='success-message' class='alert-message alert-message-success'>";
                echo $_SESSION['success_message'];
                echo "</div>";
                unset($_SESSION['success_message']); // Eliminar el mensaje de sesión después de mostrarlo
            }
            if (isset($_SESSION['error_message'])) {
                echo "<div id='error-message' class='alert-message alert-message-error'>";
                echo $_SESSION['error_message'];
                echo "</div>";
                unset($_SESSION['error_message']); // Eliminar el mensaje de sesión después de mostrarlo
            }
            ?>
            </div>

            <div class="table-container">
                <?php
                include "/xampp/htdocs/prueba/conexion/conexion.php";

                // Verificar la conexión
                if ($conexion->connect_error) {
                    die("La conexión falló: " . $conexion->connect_error);
                }

                $limit = 20; // Número de registros por página
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Obtener el número total de registros
                $sql = "SELECT COUNT(*) as total FROM solicitudes";
                $result = $conexion->query($sql);

                if (!$result) {
                    die("Error al obtener el número total de registros: " . $conexion->error);
                }

                $total_records = $result->fetch_assoc()['total'];
                $total_pages = ceil($total_records / $limit);

                // Obtener los registros para la página actual, incluyendo datos de usuarios
                $sql = "SELECT s.*, u.Nombres, u.Apellidos
                        FROM solicitudes s
                        INNER JOIN usuarios u ON s.id_usuarios = u.id_usuarios
                        LIMIT $offset, $limit";
                $result = $conexion->query($sql);

                if (!$result) {
                    die("Error al obtener las solicitudes: " . $conexion->error);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='solicitud'>
                                <h3>{$row['Nombres']}</h3>
                                 <h3>{$row['Apellidos']}</h3>
                                <p><strong>Origen:</strong> {$row['origen']}</p>
                                <p><strong>Destino:</strong> {$row['destino']}</p>
                                <p><strong>Cantidad Personas:</strong> {$row['cantidad_personas']}</p>
                                <p><strong>Cantidad Motos:</strong> {$row['cantidad_motos']}</p>
                                <p><strong>Método de Pago:</strong> {$row['metodo_pago']}</p>
                                <p><a href='/php/procesar/aceptar_solicitud.php?id_solicitud={$row['id_solicitud']}&id_usuario={$row['id_usuarios']}'>Aceptar Solicitud</a></p>
                              </div>";
                    }
                } else {
                    echo "<p>No se encontraron registros.</p>";
                }

                $conexion->close();
                ?>
            </div>

            <!-- Mostrar enlaces de paginación -->
            <div class="pagination">
                <?php
                if ($total_pages > 1) {
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Mostrar enlace "Anterior"
                    if ($current_page > 1) {
                        echo "<a class='page-link' href='/php/sermototaxista.php?page=" . ($current_page - 1) . "'>&laquo; Anterior</a>";
                    }

                    // Mostrar números de página
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active_class = ($current_page == $i) ? "active" : "";
                        echo "<a class='page-link $active_class' href='/php/sermototaxista.php?page=$i'>$i</a>";
                    }

                    // Mostrar enlace "Siguiente"
                    if ($current_page < $total_pages) {
                        echo "<a class='page-link' href='/php/sermototaxista.php?page=" . ($current_page + 1) . "'>Siguiente &raquo;</a>";
                    }
                }
                ?>
            </div>

        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar el mensaje durante 5 segundos
            var successMessage = document.getElementById('success-message');
            var errorMessage = document.getElementById('error-message');

            if (successMessage) {
                successMessage.style.display = 'block';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000); // Ocultar después de 5 segundos
            }

            if (errorMessage) {
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 5000); // Ocultar después de 5 segundos
            }
        });
    </script>
</body>
</html>
