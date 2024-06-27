<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Ayuda</title>
    <link rel="stylesheet" href="/php/css/(ayuda)style.css">
    <script>
        // Función para subir al inicio de la página
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Centro de Ayuda</h1>
            <p>Encuentra respuestas a las preguntas más frecuentes y guías para ayudarte a aprovechar al máximo nuestra aplicación.</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="/php/inicio.php">Regresar</a></li>
                <li><a href="#primeros-pasos">Primeros Pasos</a></li>
                <li><a href="#uso-aplicacion">Uso de la Aplicación</a></li>
                <li><a href="#mototaxistas">Mototaxistas</a></li>
                <li><a href="#pagos">Pagos</a></li>
                <li><a href="#soporte">Soporte</a></li>
            </ul>
        </nav>
        
        <main>
            <section id="primeros-pasos">
                <h2>Primeros Pasos</h2>
                <h3>¿Cómo registrarse?</h3>
                <p>1. Ve a la página principal de la aplicación.</p>
                <p>2. Haz clic en el botón "Registrarse".</p>
                <p>3. Completa el formulario con tus datos personales.</p>
                <p>4. Recibirás un correo de confirmación para activar tu cuenta.</p>

                <h3>¿Cómo iniciar sesión?</h3>
                <p>1. Ve a la página principal de la aplicación.</p>
                <p>2. Haz clic en el botón "Iniciar Sesión".</p>
                <p>3. Introduce tu correo electrónico y contraseña.</p>
                <p>4. Haz clic en "Entrar".</p>

                <h3>¿Cómo recuperar la contraseña?</h3>
                <p>1. En la página de inicio de sesión, haz clic en "¿Olvidaste tu contraseña?".</p>
                <p>2. Introduce tu correo electrónico registrado.</p>
                <p>3. Recibirás un correo con las instrucciones para restablecer tu contraseña.</p>
            </section>
            
            <section id="uso-aplicacion">
                <h2>Uso de la Aplicación</h2>
                <h3>¿Cómo solicitar un servicio?</h3>
                <p>1. Inicia sesión en la aplicación.</p>
                <p>2. Selecciona la opción "Solicitar Servicio" en el menú principal.</p>
                <p>3. Introduce los detalles del origen, destino y otros parámetros requeridos.</p>
                <p>4. Selecciona el método de pago y confirma la solicitud.</p>

                <h3>¿Cómo pagar por un servicio?</h3>
                <p>1. Durante la solicitud del servicio, selecciona el método de pago preferido (Efectivo o Nequi).</p>
                <p>2. Si seleccionaste Nequi, sigue las instrucciones para completar el pago a través de la plataforma Nequi.</p>
                <p>3. Recibirás una confirmación del pago y la solicitud.</p>

                <h3>¿Cómo ver el historial de solicitudes?</h3>
                <p>1. Inicia sesión en la aplicación.</p>
                <p>2. Ve a tu perfil y selecciona "Historial de Solicitudes".</p>
                <p>3. Aquí podrás ver todas las solicitudes anteriores y su estado.</p>
            </section>
            
            <section id="mototaxistas">
                <h2>Mototaxistas</h2>
                <h3>¿Cómo convertirse en mototaxista?</h3>
                <p>1. Inicia sesión en la aplicación.</p>
                <p>2. En el menú principal, selecciona "Quiero ser mototaxista".</p>
                <p>3. Completa el formulario con la información requerida.</p>
                <p>4. Espera la confirmación de tu registro como mototaxista.</p>

                <h3>¿Cómo aceptar un servicio?</h3>
                <p>1. Una vez registrado como mototaxista, inicia sesión en la aplicación.</p>
                <p>2. Ve a la sección de "Servicios Disponibles".</p>
                <p>3. Selecciona el servicio que deseas aceptar y confirma tu disponibilidad.</p>
            </section>
            
            <section id="pagos">
                <h2>Pagos</h2>
                <h3>Métodos de pago disponibles</h3>
                <p>Actualmente, ofrecemos los siguientes métodos de pago:</p>
                <ul>
                    <li>Efectivo</li>
                    <li>Nequi</li>
                </ul>

                <h3>¿Cómo funciona el pago con Nequi?</h3>
                <p>1. Selecciona Nequi como método de pago al solicitar un servicio.</p>
                <p>2. Serás redirigido a la plataforma de Nequi para completar el pago.</p>
                <p>3. Una vez confirmado el pago, recibirás una notificación en la aplicación.</p>

                <h3>¿Cómo se gestionan las retenciones?</h3>
                <p>Las retenciones se aplican de acuerdo con las políticas de la aplicación. Puedes ver el estado de tus retenciones en la sección de "Retenciones" de tu perfil.</p>
            </section>
            
            <section id="soporte">
                <h2>Soporte</h2>
                <h3>Contacto y soporte técnico</h3>
                <p>Si necesitas ayuda adicional, puedes contactarnos a través de:</p>
                <ul>
                    <li>Correo electrónico: soporte@tuapp.com</li>
                    <li>Teléfono: +123 456 7890</li>
                </ul>
                <p>Estamos disponibles de lunes a viernes, de 9:00 a 18:00.</p>
            </section>
        </main>
        <button onclick="scrollToTop()" id="scrollToTopBtn" title="Subir">
        &#8679;
    </button>
    </div>
</body>
</html>
