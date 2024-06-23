
    var modal = document.getElementById('mensajeModal');
    var openModalBtn = document.getElementById('openModalBtn');
    var closeModal = document.getElementsByClassName('close')[0];
    var mensajesContainer = document.getElementById('mensajesContainer');

    openModalBtn.onclick = function() {
        // Cargar mensajes utilizando AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    mensajesContainer.innerHTML = xhr.responseText;
                    modal.style.display = 'block';
                    
                    // Marcar mensajes como leídos al mostrarlos
                    marcarMensajesLeidos();
                } else {
                    alert('Hubo un problema al cargar los mensajes.');
                }
            }
        };
        xhr.open('GET', '/php/procesar/mostrar_mensajes.php', true); 
        xhr.send();
    };

    closeModal.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

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

        // Ocultar mensaje después de 5 segundos si existe
        var mensajeDiv = document.getElementById('mensaje-solicitante');
        if (mensajeDiv) {
            setTimeout(function() {
                mensajeDiv.style.display = 'none';
            }, 5000); // 5000 milisegundos = 5 segundos
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        var mensajeDiv = document.getElementById('mensaje-solicitante');
        if (mensajeDiv) {
            setTimeout(function() {
                mensajeDiv.style.display = 'none';
            }, 5000); // 5000 milisegundos = 5 segundos
        }
    });


    // modal de configuracion
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener elementos del DOM
        const eliminarCuentaLink = document.getElementById('eliminarCuentaLink');
        const politicasLink = document.getElementById('politicasLink');
        const eliminarCuentaModal = document.getElementById('eliminarCuentaModal');
        const politicasModal = document.getElementById('politicasModal');

        // Mostrar modal para eliminar cuenta al hacer clic en "Eliminar cuenta"
        eliminarCuentaLink.addEventListener('click', function(e) {
            e.preventDefault();
            eliminarCuentaModal.style.display = 'block';
        });

        // Mostrar modal de políticas y privacidad al hacer clic en "Políticas y privacidad"
        politicasLink.addEventListener('click', function(e) {
            e.preventDefault();
            politicasModal.style.display = 'block';
        });

        // Cerrar modales al hacer clic en la 'X' de cada modal
        const closeButtons = document.getElementsByClassName('close');
        for (let i = 0; i < closeButtons.length; i++) {
            closeButtons[i].addEventListener('click', function() {
                eliminarCuentaModal.style.display = 'none';
                politicasModal.style.display = 'none';
            });
        }

        // Cerrar modales al hacer clic fuera del contenido del modal
        window.onclick = function(event) {
            if (event.target == eliminarCuentaModal) {
                eliminarCuentaModal.style.display = 'none';
            }
            if (event.target == politicasModal) {
                politicasModal.style.display = 'none';
            }
        }
    });


    // Función para ocultar el mensaje de error después de 5 segundos
setTimeout(function() {
    var errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        errorMessage.style.display = 'none';
    }
}, 5000); // 5000 milisegundos = 5 segundos