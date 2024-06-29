<?php

session_start();

include('/xampp/htdocs/prueba/conexion/conexion.php');

$sql_departamentos = "SELECT id_departamentos, departamentos FROM departamentos";
$resultado_departamentos = $conexion->query($sql_departamentos);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="/login/css/login.css">
</head>

<body>

    <main>

        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Regístrarse</button>
                </div>
            </div>
            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form action="/login/ph/validar.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <?php
                    if (isset($_SESSION['mensaje'])) {
                        echo '<p class="mensaje">' . $_SESSION['mensaje'] . '</p>';
                        unset($_SESSION['mensaje']);
                    }
                    if (isset($_SESSION['error'])) {
                        echo '<p class="error">' . $_SESSION['error'] . '</p>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <input type="text" placeholder="Usuario" name="usuario" id="usuario">
                    <input type="password" placeholder="Contraseña" name="password" id="password">
                    <button type="submit" class="btn btn-primary" name="btn" value="ok">Ingresar</button>
                    <a class="recordar" href="/recuperar_contraseña/cambiar_contraseña.php">Recuperar contraseña</a>
                </form>
                <!--Registro-->

                <form action="/login/ph/registro_bd.php" method="POST" class="formulario__register">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Nombres" name="nombres" id="nombres">

                    <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos">
                    <input type="text" placeholder="Documento de Identidad" name="dni" id="dni">
                    <input type="date" placeholder="Fecha de Nacimiento" name="fecha" id="fecha">
                    <input type="text" placeholder="Telefono" name="telefono" id="telefono"> <br> <br>
                    <!-- Combo box para seleccionar departamento -->
                    <div class="mb-3">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select name="departamento" id="departamento" class="form-select form-select-sm" onchange="getCiudades()">
                            <option value="">Selecciona un departamento</option>
                            <?php
                            while ($departamento = $resultado_departamentos->fetch_assoc()) {
                                echo '<option value="' . $departamento['id_departamentos'] . '">' . $departamento['departamentos'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Combo box para seleccionar ciudad -->
                    <div class="mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <select name="ciudad" id="ciudad" class="form-select form-select-sm">
                            <option value="">Selecciona una ciudad</option>
                        </select>
                    </div>


                    <input type="text" placeholder="Direccion de residencia" name="direccion" id="direccion">
                    <input type="text" placeholder="Usuario" name="usuario" id="usuario">
                    <div class="password-container">
                        <input type="password" placeholder="Contraseña" name="contraseña" id="contraseña" class="password-input">
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('contraseña')"></i>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Regístrarme</button>
                </form>
            </div>
        </div>
    </main>
    <!-- Script JavaScript para obtener ciudades según el departamento seleccionado -->
    <script>
        function getCiudades() {
            var departamentoId = document.getElementById("departamento").value;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/admin/obtener_ciudades.php?departamento=" + departamentoId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var ciudades = JSON.parse(xhr.responseText);
                    var ciudadSelect = document.getElementById("ciudad");
                    ciudadSelect.innerHTML = '<option value="">Selecciona una ciudad</option>';
                    ciudades.forEach(function(ciudad) {
                        var option = document.createElement("option");
                        option.value = ciudad.id_ciudades;
                        option.textContent = ciudad.ciudades;
                        ciudadSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    </script>

    <!-- Scripts necesarios de Bootstrap y JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12cX3mB90+JN1+W8cl/xpRXVlmiHE7fZpL4pacoLHZYNt1w1" crossorigin="anonymous"></script>

    <script src="/login/js/escript.js"></script>

</body>

</html>