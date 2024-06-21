<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar código</title>
    <link rel="stylesheet" href="/php/css/(recordar contraseña)style.css">
</head>
<body>
    <div class="container">
        <h1>Verificar código</h1>
        <form action="/php/procesar/verificar_codigo.php" method="POST">
            <input type="text" id="codigo" name="codigo" placeholder="Ingrese el código" required>
            <button type="submit">Verificar</button> <br> <br>
            <a class="link1" href="/login/login.php">Salir</a>
        </form>
    </div>
</body>
</html>
