
<?php
include("/xampp/htdocs/prueba/conexion/conexion.php");
$id = $_GET["id"];
$nombres = $_GET["nombres"];
$apellidos = $_GET["apellidos"];
$dni = $_GET["dni"];
$fecha = $_GET["fecha"];
$telefono = $_GET["telefono"];
$departamento = $_GET["departamento"];
$ciudad = $_GET["ciudad"];
$direccion = $_GET["direccion"];
$estado = $_GET["estado"];
$rol = $_GET["rol"];
$sql = $conexion->query("SELECT * FROM usuarios WHERE id_usuarios=$id,");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/mototaxistas.php">Mototaxistas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        function editar() {
            var respuesta = confirm("Estas seguro que quieres editar este usuario?");
            return respuesta
        }
    </script>

    <!--formulario para editar usuarios-->
    <form class="col-3 p-3 m-auto" action="/admin/update.php" method="POST">
        <h3 class="text-center text-secondary">EDITAR USUARIOS</h3> <br>
        <div class="mb-3">
            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">NOMBRES</label>
            <input type="text" class="form-control" name="nombres" id="nombres" value="<?php echo $nombres ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">APELLIDOS</label>
            <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?php echo $apellidos ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">DNI</label>
            <input type="text" class="form-control" name="dni" id="dni" value="<?php echo $dni ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">FECHA DE NACIMIENTO</label>
            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">TELEFONO</label>
            <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono ?>">
        </div>
       
       
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">DEPARTAMENTO</label>
            <input type="text" class="form-control" name="departamento" id="departamento" value="<?php echo $departamento ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">CIUDAD</label>
            <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?php echo $ciudad ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">DIRECCION</label>
            <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $direccion ?>">
        </div>
       
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">ESTADO</label>
            <input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado ?>">
        </div>
        <div class="form-group">
            <label for="rol" class="form-label">Rol de usuario</label>
            <input type="text" class="form-control" name="rol" id="rol" value="<?php echo $rol ?>">
        </div> <br>


        <button type="submit" onclick="return editar()" class="btn btn-primary" name="btnregistrar" value="ok">EDITAR</button>

        <a class="btn btn-primary" href="/admin/index.php" type="button">CANCELAR</a>
    </form>

</body>

</html>