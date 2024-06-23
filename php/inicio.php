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

    <?php if (!empty($mensaje)) : ?>
        <div class="mensaje" id="mensaje">
            <p><?= $mensaje ?></p>
        </div>


        <?php if (isset($_SESSION['mensaje_solicitante'])) : ?>
            <div id='mensaje-solicitante' class='alert-message alert-message-success'>
                <?= $_SESSION['mensaje_solicitante'] ?>
            </div>
            <?php unset($_SESSION['mensaje_solicitante']); // Eliminar el mensaje de sesión después de mostrarlo 
            ?>

        <?php endif; ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['mensaje_solicitante'])) {
        echo "<div id='mensaje-solicitante' class='alert-message alert-message-success'>";
        echo $_SESSION['mensaje_solicitante'];
        echo "</div>";
        unset($_SESSION['mensaje_solicitante']); // Eliminar el mensaje de sesión después de mostrarlo
    } ?>

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
                <li>
                    <a href="#">
                        <ion-icon name="construct-outline"></ion-icon>
                        <span>Configuración</span>
                    </a>
                </li>
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
    </script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></scriptnomodule>
    <script src="/php/js/funcionalidad.js"></script>
    <script src="/php/js/script.js"></script>

</body>

</html>