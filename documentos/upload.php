<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar sesión si no está iniciada

include("/xampp/htdocs/prueba/conexion/conexion.php");

// Ruta donde se guardan las imágenes
$target_dir = "imagen/";

$placa = isset($_POST["placa"]) ? $_POST["placa"] : "";
$marca = isset($_POST["marca"]) ? $_POST["marca"] : "";
$modelo = isset($_POST["modelo"]) ? $_POST["modelo"] : "";
$color = isset($_POST["color"]) ? $_POST["color"] : "";

// Obtener el id_usuarios de la sesión
$id_usuarios = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuarios)) {
    die('Error: el id_usuarios no está definido.');
}

$uploadOk = 1;

// Verifica si id_usuarios existe en la tabla documentos
$sql_check = "SELECT * FROM documentos WHERE id_usuarios = $id_usuarios LIMIT 1";
$result = $conexion->query($sql_check);

if ($result->num_rows > 0) {
    $_SESSION['message'] = "<p style='color: green;'>Ya existe un registro de documentos para este usuario, ya puedes prestar el servicio.</p>";
    header("Location: ../../../php/sermototaxista.php");
    exit();
}

// Verifica si la placa ya existe en la base de datos
$sql_check_placa = "SELECT * FROM documentos WHERE placa = '$placa' LIMIT 1";
$result_placa = $conexion->query($sql_check_placa);

if ($result_placa->num_rows > 0) {
    $_SESSION['error'] = "La placa ya está registrada, ya subiste los documentos!.";
    header("Location: registro_de_documentos.php");
    exit();
}

if (isset($_POST["submit"])) {
    $files = [
        'licencia_de_conducir' => $_FILES["licencia_de_conducir"],
        'tarjeta_de_propiedad' => $_FILES["tarjeta_de_propiedad"],
        'soat' => $_FILES["soat"],
        'tecno_mecanica' => $_FILES["tecno_mecanica"]
    ];

    $allowed_types = ['jpg', 'jpeg', 'png'];

    foreach ($files as $key => $file) {
        $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_types)) {
            $_SESSION['error_archivo'] = "El archivo " . $file["name"] . " no es un archivo permitido.";
            $uploadOk = 0;
            break;
        }

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            $_SESSION['error_archivo'] = "El archivo " . $file["name"] . " no es una imagen válida.";
            $uploadOk = 0;
            break;
        }
    }

    if ($uploadOk == 1) {
        $sql = "INSERT INTO documentos (placa, marca, modelo, color, id_usuarios) VALUES ('$placa', '$marca', '$modelo', '$color', '$id_usuarios')";
        if ($conexion->query($sql) === TRUE) {
            $last_id = $conexion->insert_id;

            $licencia_de_conducir_name = $last_id . "_licencia." . pathinfo($_FILES["licencia_de_conducir"]["name"], PATHINFO_EXTENSION);
            $tarjeta_de_propiedad_name = $last_id . "_tarjeta." . pathinfo($_FILES["tarjeta_de_propiedad"]["name"], PATHINFO_EXTENSION);
            $soat_name = $last_id . "_soat." . pathinfo($_FILES["soat"]["name"], PATHINFO_EXTENSION);
            $tecno_mecanica_name = $last_id . "_tecno." . pathinfo($_FILES["tecno_mecanica"]["name"], PATHINFO_EXTENSION);

            $licencia_de_conducir_path = $target_dir . $licencia_de_conducir_name;
            $tarjeta_de_propiedad_path = $target_dir . $tarjeta_de_propiedad_name;
            $soat_path = $target_dir . $soat_name;
            $tecno_mecanica_path = $target_dir . $tecno_mecanica_name;

            if (
                move_uploaded_file($_FILES["licencia_de_conducir"]["tmp_name"], $licencia_de_conducir_path) &&
                move_uploaded_file($_FILES["tarjeta_de_propiedad"]["tmp_name"], $tarjeta_de_propiedad_path) &&
                move_uploaded_file($_FILES["soat"]["tmp_name"], $soat_path) &&
                move_uploaded_file($_FILES["tecno_mecanica"]["tmp_name"], $tecno_mecanica_path)
            ) {
                $sql_update = "UPDATE documentos SET 
                                licencia_de_conducir='$licencia_de_conducir_name', 
                                tarjeta_de_propiedad='$tarjeta_de_propiedad_name', 
                                soat='$soat_name', 
                                tecno_mecanica='$tecno_mecanica_name' 
                               WHERE id_documentos=$last_id";

                if ($conexion->query($sql_update) === TRUE) {
                    $_SESSION['success_message'] = "<p style='color: green;'>Documentos insertados correctamente, ya puedes aceptar un servicio.</p>";
                    header("Location: ../../../php/sermototaxista.php");
                    exit();
                } else {
                    echo "Error: " . $sql_update . "<br>" . $conexion->error;
                }
            } else {
                $_SESSION['error'] = "Lo siento, hubo un error subiendo tus archivos.";
                header('Location: registro_de_documentos.php');
                exit();
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    } else {
        $_SESSION['error'] = "Lo siento, tu archivo no fue subido.";
        header('Location: registro_de_documentos.php');
        exit();
    }
} else {
    echo "No se ha enviado el formulario";
}
?>
