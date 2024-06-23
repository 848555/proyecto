<?php
// Iniciar la sesión
session_start();

// Definir la variable $user_id desde la sesión
$user_id = $_SESSION['id_usuario'];

// Verificar si el usuario tiene acceso al contenido de esta página
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 2) {
    // Redireccionar a la página de inicio de sesión si no hay sesión iniciada o el rol no es correcto
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/php/css/paginainiciostyle.css"> <!--enlace a estilos css-->
    <title>Página de Inicio</title>
</head>

<body>
    <?php
// Verificar si hay un mensaje de error al eliminar la cuenta
if (isset($_SESSION['error_message'])) {
    echo '<div id="error-message" class="error-message">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Limpiar el mensaje de error después de mostrarlo
}
?>

    <div class="menu" id="menu">
        <ion-icon name="menu-outline" id="menuIcon"></ion-icon>
        <ion-icon name="close-outline" id="closeIcon" style="display: none;"></ion-icon>
    </div>

    <div class="barra-lateral" id="barraLateral">
        <div class="nombre-pagina">
            <ion-icon id="cloud" name="cloud-outline"></ion-icon>
            <span>Menu</span>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a href="/php/perfil.php">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span>Perfil</span>
                    </a>
                </li>

                <li>
                    <a href="#" id="openModalBtn">
                        <ion-icon name="paper-plane-outline"></ion-icon>
                        <span>Mis mensajes</span>
                    </a>
                    <?php include '/xampp/htdocs/prueba/conexion/conexion.php'; ?>
                </li>

                <!-- Modal -->
                <div id="mensajeModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <div id="mensajesContainer"></div> <!-- Contenedor para mensajes -->
                    </div>
                </div>


                <li>
                    <a href="/php/documentos_mototaxistas_usu.php">
                        <ion-icon name="newspaper-outline"></ion-icon>
                        <span>Mis documentos</span>
                    </a>
                </li>


                <div class="dropdown">
                    <span id="configLink" class="dropbtn">
                        <ion-icon name="construct-outline"></ion-icon>
                        Configuración
                    </span>
                    <div class="dropdown-content">
                        <a href="#" id="eliminarCuentaLink">Eliminar cuenta</a>
                        <a href="#" id="politicasLink">Políticas y privacidad</a>
                    </div>
                </div>

              <!-- Modal para eliminar cuenta -->
<div id="eliminarCuentaModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Eliminar cuenta</h2>
        <form method="POST" action="/php/procesar/eliminar_cuenta.php">
            <ul class="modal-ul">
                <li>
                    <span class="mensa">Ingresa tu contraseña para eliminar</span> 
                    <input class="password" type="password" name="password" id="passwordInput" required>
                </li>
                <li><button type="submit" id="confirmarEliminarBtn">Confirmar</button></li>
            </ul>
        </form>
    </div>
</div>


                <!-- Modal para mostrar políticas y privacidad -->
                <div id="politicasModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Políticas y privacidad</h2>
                        <p>Aquí van las políticas y la información de privacidad.</p>
                    </div>
                </div>

                <li>
                    <a href="/login/login.php?vista=logout">
                        <ion-icon name="power-outline"></ion-icon>
                        <span>Salir</span>
                    </a>
                </li>
            </ul> <br> <br> <br>
            <div class="usuario">
                <div class="info-usuario">
                    <div class="nombre">
                        <span class="usuario"><?php echo $_SESSION['usuario']; ?></span>
                    </div>
                    <ion-icon name="person-circle-outline"></ion-icon>
                </div>
            </div>

        </nav>

        <div class="linea"></div>

        <div class="modo-oscuro">
            <div class="info">
                <ion-icon name="moon-outline"></ion-icon>
                <span>Modo oscuro</span>
            </div>
            <div class="switch">
                <div class="base">
                    <div class="circulo"></div>
                </div>
            </div>
        </div>


    </div>


    <div class="contenedor">

        <div class="info">

            <h2>Bienvenido <?php echo $_SESSION['usuario']; ?></h2>
            <?php
            if (isset($_SESSION['messaje'])) {
                echo '<p class="messaje">' . $_SESSION['messaje'] . '</p>';
                unset($_SESSION['messaje']);
            }
            ?>
            <hr>
            <p class="txt">
                ¿QUÉ QUIERES HACER HOY?
            </p>
        </div>

        <div class="logo"></div>
        <div class="bottom_part"></div>
        <div class="salir"></div>

        <div class="cliente">
            <a href="/php/solicitud.php" id="ser-cliente">Quiero Ser Cliente</a>
            <a onclick="mostrarAlerta(event)" href="#" id="ser-mototaxista">Quiero Ser Mototaxista</a>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    </script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js">
    </scriptnomodule>
    <script src="/php/js/funcionalidad.js"></script>
    <script src="/php/js/script.js"></script>

</body>

</html>