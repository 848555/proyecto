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

        <script>
            // Mostrar el mensaje si existe
            document.addEventListener('DOMContentLoaded', function() {
                var mensajeDiv = document.getElementById('mensaje');
                if (mensajeDiv && mensajeDiv.innerText.trim() !== '') {
                    mensajeDiv.style.display = 'block';
                    // Ocultar el mensaje después de 5 segundos
                    setTimeout(function() {
                        mensajeDiv.style.display = 'none';
                    }, 5000); // 5000 milisegundos = 5 segundos
                }
            });
        </script>
         <?php if (isset($_SESSION['mensaje_solicitante'])) : ?>
        <div id='mensaje-solicitante' class='alert-message alert-message-success'>
            <?= $_SESSION['mensaje_solicitante'] ?>
        </div>
        <?php unset($_SESSION['mensaje_solicitante']); // Eliminar el mensaje de sesión después de mostrarlo ?>
       
    <?php endif; ?>
    <?php endif; ?>
    <?php   if (isset($_SESSION['mensaje_solicitante'])) {
                echo "<div id='mensaje-solicitante' class='alert-message alert-message-success'>";
                echo $_SESSION['mensaje_solicitante'];
                echo "</div>";
                unset($_SESSION['mensaje_solicitante']); // Eliminar el mensaje de sesión después de mostrarlo
            }?>

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
                    <a href="#">
                        <ion-icon name="paper-plane-outline"></ion-icon>
                        <span>Mis solicitudes</span>
                    </a>
                </li>
                <li>
                    <a href="#">
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
    <!--permite que el usuario pueda registrar sus documentos solo una vez-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el ID del usuario desde PHP
            var userId = "<?php echo $user_id; ?>";
            var mensajeKey = 'mensajeVisto_' + userId;

            // Función para mostrar la alerta y redirigir al formulario
            function mostrarAlerta(event) {
                event.preventDefault(); // Prevenir el comportamiento por defecto del enlace

                console.log('Iniciando función mostrarAlerta');
                console.log('ID de usuario:', userId);
                console.log('Clave de mensaje en localStorage:', mensajeKey);

                // Verificar si el usuario ya ha visto el mensaje
                var mensajeVisto = localStorage.getItem(mensajeKey);
                console.log('Valor de mensajeVisto en localStorage:', mensajeVisto);

                if (mensajeVisto !== 'true') {
                    console.log('El mensaje no ha sido visto. Mostrando confirmación.');
                    var respuesta = confirm("Para nosotros es de gran importancia conocer con qué documentos de tu vehículo cuentas, ya que estos son solicitados por las autoridades de tránsito. Por esta razón, te invitamos a llenar el siguiente formulario para que puedas prestar el servicio de mototaxi.");
                    console.log('Confirmación de usuario:', respuesta);

                    if (respuesta) {
                        // Marcar que el usuario ya ha visto el mensaje
                        localStorage.setItem(mensajeKey, 'true');
                        console.log('Mensaje marcado como visto en localStorage');

                        // Redirigir al formulario
                        window.location.href = '/documentos/registro_de_documentos.php';
                    } else {
                        console.log('Usuario canceló la confirmación.');
                    }
                } else {
                    console.log('El mensaje ya ha sido visto. Redirigiendo a sermototaxista.php');
                    // Si el mensaje ya fue visto, redirigir directamente a la otra página
                    window.location.href = '/php/sermototaxista.php';
                }
            }

            // Asignar la función al enlace
            document.getElementById('ser-mototaxista').onclick = mostrarAlerta;
        });
    </script>
       <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mensajeDiv = document.getElementById('mensaje-solicitante');
            if (mensajeDiv) {
                setTimeout(function() {
                    mensajeDiv.style.display = 'none';
                }, 5000); // 5000 milisegundos = 5 segundos
            }
        });
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/php/js/script.js"></script>

</body>

</html>