<?php 
session_start();

// Definir la variable $user_id desde la sesión
$user_id = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="/php/css/(recordar contraseña)style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Cambiar contraseña</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form id="cambiarContraseñaForm" action="/recuperar_contraseña/procesar/cambiar_contraseña.php" method="POST" onsubmit="return validarContraseñas()">
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $user_id; ?>">
            <div class="password-container">
                <label for="nueva_contraseña">Ingresa la contraseña nueva</label>
                <input type="password" id="nueva_contraseña" name="nueva_contraseña" placeholder="Nueva contraseña" required>
                <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('nueva_contraseña')"></i>
            </div> <br>
            <div class="password-container">
                <label for="verificar_contraseña">Verificar nueva contraseña</label>
                <input type="password" id="verificar_contraseña" name="verificar_contraseña" placeholder="Verificar nueva contraseña" required>
                <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('verificar_contraseña')"></i>
            </div>
            <p id="errorMensaje" class="error"></p>
            <button type="submit">Cambiar</button> <br> <br>
            <a class="link1" href="/login/login.php">Salir</a>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(id) {
            var input = document.getElementById(id);
            var icon = input.nextElementSibling;

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function validarContraseñas() {
            var nuevaContraseña = document.getElementById("nueva_contraseña").value;
            var verificarContraseña = document.getElementById("verificar_contraseña").value;
            var errorMensaje = document.getElementById("errorMensaje");

            if (nuevaContraseña !== verificarContraseña) {
                errorMensaje.textContent = "Las contraseñas no coinciden.";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
