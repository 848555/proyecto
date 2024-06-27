<?php 
session_start();
require ("/xampp/htdocs/prueba/conexion/conexion.php");

$sql = "SELECT id_departamentos, departamentos FROM departamentos ";
$resultado = $conexion->query($sql);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSERTAR USUARIOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/35f3448c23.js" crossorigin="anonymous"></script>

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
                        <a class="nav-link" href="/admin/index_principal.php">Inicio</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>



    <form class="col-3 p-3 m-auto" method="POST" action="/admin/insertar.php">
        <h3 class="text-center text-secondary">REGISTRO DE USUARIOS</h3>
        
     <?php
     // Mostrar mensajes de error si existen
     if (isset($_SESSION['error_message'])) {
         echo $_SESSION['error_message'];
         unset($_SESSION['error_message']); // Limpiar la variable de sesión
     }
     ?>
        <!--se incluye la conexion a base de datos-->
        <?php
        include("/xampp/htdocs/prueba/conexion/conexion.php");
        ?>
        <!--formulario de registros de usuario -->
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">NOMBRES</label>
            <input type="text" class="form-control" name="nombres" id="nombres">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">APELLIDOS</label>
            <input type="text" class="form-control" name="apellidos" id="apellidos">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">DNI</label>
            <input type="text" class="form-control" name="dni" id="dni">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">FECHA DE NACIMIENTO</label>
            <input type="date" class="form-control" name="fecha" id="fecha">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">TELEFONO</label>
            <input type="text" class="form-control" name="telefono" id="telefono">
        </div>


       

        <?php
        include("/xampp/htdocs/prueba/conexion/conexion.php");
        $sql = $conexion->query("SELECT id_departamentos,departamentos from departamentos");
        ?>
        <label for="exampleInputEmail1" class="form-label">DEPARTAMENTO</label>
        <select name="departamento" class="form-select form-select-sm">
            <?php
            while ($datos = mysqli_fetch_array($sql)) {
            ?>
                <option value="<?php echo $datos['departamentos'] ?>"><?php echo $datos['departamentos'] ?></option>

            <?php
            } ?>

        </select>
        <?php
        include("/xampp/htdocs/prueba/conexion/conexion.php");
        $sql = $conexion->query("SELECT *from ciudades");
        ?>
        <label for="exampleInputEmail1" class="form-label">CIUDAD</label>
        <select name="ciudad" class="form-select form-select-sm">
            <?php
            while ($datos = mysqli_fetch_array($sql)) {
            ?>
                <option value="<?php echo $datos['ciudades'] ?>"><?php echo $datos['ciudades'] ?></option>

            <?php
            } ?>

        </select>


        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">DIRECCION</label>
            <input type="text" class="form-control" name="direccion" id="direccion">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">USUARIO</label>
            <input type="text" class="form-control" name="usuario" id="usuario">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">CONTRASEÑA</label>
            <input type="password" class="form-control" name="contraseña" id="contraseña">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">ESTADO</label>
            <select name="estado" class="form-select form-select-sm">
                <option  name="estado" value="Activo">Activo</option>
                <option name="estado"  value="Inactivo">Inactivo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rol" class="form-label">Rol de usuario *</label>
            <input type="number" id="rol" name="rol" class="form-control" placeholder="Escribe el rol, 1 admin, 2 usuario..">
            <input type="hidden" name="accion" value="editar_registro">
            <input type="hidden" name="id"><br>

            <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">REGISTRAR</button>
            <button type="button" class="btn btn-primary" name="btnregistrar" onclick="window.location.href='/admin/index.php'" value="ok">CANCELAR</button>

    </form>
</body>
<script>
let departamentos =["Amazonas,Antioquía,Arauca,Atlántico,Bolívar,Boyacá,Caldas,Caquetá,Casanare,Cauca,Cesar,Chocó,Córdoba,Cundinamarca,Guainía,Guaviare,Huila,La Guajira,Magdalena,Meta,Nariño,Norte de Santander,Putumayo,Quindío,Risaralda,San Andrés y Providencia,Santander,Sucre,Tolima,Valle del Cauca,Vaupés,Vichada"];

let ciudades = ["Leticia,Medellín,Arauca,Barranquilla,Cartagena de Indias,Tunja,Manizales,Florencia,Yopal,Popayán,Valledupar,Quibdó,Montería,Bogotá,Inírida,San José del Guaviare,Neiva,Riohacha, Santa Marta,Villavicencio, San Juan de Pasto,San José de Cúcuta,Mocoa,Armenia,Pereira, San Andrés,Bucaramanga,Sincelejo,Ibagué,Cali,Mitú,Puerto Carreño"];


</script>
</html>