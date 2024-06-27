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

            <div class="table-container" id="solicitudes-container">
                <!-- Aquí se cargarán las solicitudes -->
            </div>

            <!-- Mostrar enlaces de paginación -->
            <div class="pagination" id="pagination">
                <!-- Aquí se cargarán los enlaces de paginación -->
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
    <script>
        function fetchSolicitudes(page = 1) {
            const solicitudesContainer = document.getElementById('solicitudes-container');
            const paginationContainer = document.getElementById('pagination');
            
            fetch(`/php/procesar/obtener_solicitudes.php?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar contenedor
                    solicitudesContainer.innerHTML = '';
                    
                    // Verificar si hay datos
                    if (data.solicitudes.length > 0) {
                        data.solicitudes.forEach(row => {
                            const solicitudDiv = document.createElement('div');
                            solicitudDiv.classList.add('solicitud');
                            solicitudDiv.innerHTML = `
                                <h3>${row.Nombres}</h3>
                                <h3>${row.Apellidos}</h3>
                                <p><strong>Origen:</strong> ${row.origen}</p>
                                <p><strong>Destino:</strong> ${row.destino}</p>
                                <p><strong>Cantidad Personas:</strong> ${row.cantidad_personas}</p>
                                <p><strong>Cantidad Motos:</strong> ${row.cantidad_motos}</p>
                                <p><strong>Método de Pago:</strong> ${row.metodo_pago}</p>
                                <p><a href='/php/procesar/aceptar_solicitud.php?id_solicitud=${row.id_solicitud}&id_usuario=${row.id_usuarios}'>Aceptar Solicitud</a></p>
                            `;
                            solicitudesContainer.appendChild(solicitudDiv);
                        });
                    } else {
                        solicitudesContainer.innerHTML = '<p>No se encontraron registros.</p>';
                    }
                    
                    // Actualizar paginación
                    paginationContainer.innerHTML = '';
                    if (data.total_pages > 1) {
                        for (let i = 1; i <= data.total_pages; i++) {
                            const pageLink = document.createElement('a');
                            pageLink.classList.add('page-link');
                            if (i === page) pageLink.classList.add('active');
                            pageLink.href = `javascript:fetchSolicitudes(${i})`;
                            pageLink.textContent = i;
                            paginationContainer.appendChild(pageLink);
                        }
                    }
                })
                .catch(error => console.error('Error fetching solicitudes:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchSolicitudes(); // Fetch initial solicitudes
            setInterval(fetchSolicitudes, 5 * 60 * 1000); // Update every 5 minutes
        });
    </script>
</body>
</html>
