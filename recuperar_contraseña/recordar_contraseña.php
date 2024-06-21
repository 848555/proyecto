<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="/php/css/(recordar contraseña)style.css">
</head>
<body>
    <div class="container">
        <h1>Recuperar contraseña</h1>
        <form action="/php/procesar/recuperar_contraseña.php" method="POST">
            <input type="tel" id="numero" name="numero" placeholder="Numero de Telefono" required>
            <button type="submit">Enviar</button> <br> <br>
            <a class="link1" href="/login/login.php">Regresar</a>
        </form>
    </div>
</body>
</html>
