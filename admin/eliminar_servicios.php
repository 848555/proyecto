<?php
require("/xampp/htdocs/prueba/conexion/conexion.php");
    $id = $_GET['id'];
    $sql = "DELETE FROM solicitudes WHERE id=$id";
    $resultados = $conexion->query($sql);
    header ("location: servicios_solicitados.php");