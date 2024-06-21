<?php
// Iniciar sesión
session_start();

// Incluir el archivo de conexión
include("/xampp/htdocs/prueba/conexion/conexion.php");

// Establecer cabeceras
header("Content-Type: application/json");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            // Obtener un usuario
            $id = intval($_GET["id"]);
            get_user($id);
        } else {
            // Obtener todos los usuarios
            get_users();
        }
        break;

    case 'POST':
        // Crear un nuevo usuario
        create_user();
        break;

    case 'PUT':
        // Actualizar un usuario existente
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data["id"])) {
            $id = intval($data["id"]);
            update_user($id, $data);
        } else {
            echo json_encode(["message" => "ID de usuario no proporcionado para la actualización."]);
        }
        break;

    case 'DELETE':
        // Eliminar un usuario
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data["id"])) {
            $id = intval($data["id"]);
            delete_user($id);
        } else {
            echo json_encode(["message" => "ID de usuario no proporcionado para la eliminación."]);
        }
        break;

    case 'DELETE_SOLICITUD':
        // Eliminar una solicitud
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            delete_solicitud($id);
        } else {
            echo json_encode(["message" => "ID de solicitud no proporcionado para la eliminación."]);
        }
        break;

    case 'DELETE_DOCUMENTO':
        // Eliminar un documento
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            delete_documento($id);
        } else {
            echo json_encode(["message" => "ID de documento no proporcionado para la eliminación."]);
        }
        break;

    default:
        // Método no soportado
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_users() {
    global $conexion;
    $query = "SELECT * FROM usuarios";
    $result = $conexion->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
    $conexion->close();
}

function get_user($id) {
    global $conexion;
    $query = "SELECT * FROM usuarios WHERE id_usuarios=$id";
    $result = $conexion->query($query);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["message" => "Usuario no encontrado."]);
    }
    $conexion->close();
}

function create_user() {
    global $conexion;
    $data = json_decode(file_get_contents('php://input'), true);
    $nombres = $data["nombres"];
    $apellidos = $data["apellidos"];
    $dni = $data["dni"];
    $fecha = $data["fecha"];
    $telefono = $data["telefono"];
    $departamento = $data["departamento"];
    $ciudad = $data["ciudad"];
    $direccion = $data["direccion"];
    $usuario = $data["usuario"];
    $contraseña = $data["contraseña"];
    $estado = $data["estado"];
    $rol = $data["rol"];

    // Verificar duplicados
    $check_query = "SELECT * FROM usuarios WHERE DNI=? OR telefono=? OR Usuario=?";
    $stmt = $conexion->prepare($check_query);
    $stmt->bind_param("sss", $dni, $telefono, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["message" => "Usuario con DNI, teléfono o nombre de usuario ya existe."]);
        $conexion->close();
        return;
    }

    // Insertar datos
    $query = "INSERT INTO usuarios (Nombres, Apellidos, DNI, fecha_de_nacimiento, telefono, Departamento, Ciudad, Direccion, Usuario, Password, Estado, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssssssss", $nombres, $apellidos, $dni, $fecha, $telefono, $departamento, $ciudad, $direccion, $usuario, $contraseña, $estado, $rol);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Usuario creado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al crear usuario."]);
    }
    $conexion->close();
}

function update_user($id, $data) {
    global $conexion;
    $nombres = $data["nombres"];
    $apellidos = $data["apellidos"];
    $dni = $data["dni"];
    $fecha = $data["fecha"];
    $telefono = $data["telefono"];
    $departamento = $data["departamento"];
    $ciudad = $data["ciudad"];
    $direccion = $data["direccion"];
    $estado = $data["estado"];
    $rol = $data["rol"];

    // Verificar duplicados
    $check_query = "SELECT * FROM usuarios WHERE (DNI=? OR telefono=? OR Usuario=?) AND id_usuarios!=?";
    $stmt = $conexion->prepare($check_query);
    $stmt->bind_param("sssi", $dni, $telefono, $usuario, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["message" => "Usuario con DNI, teléfono o nombre de usuario ya existe."]);
        $conexion->close();
        return;
    }

    // Actualizar datos
    $query = "UPDATE usuarios SET Nombres=?, Apellidos=?, DNI=?, fecha_de_nacimiento=?, telefono=?, Departamento=?, Ciudad=?, Direccion=?, Estado=?, rol=? WHERE id_usuarios=?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssssssi", $nombres, $apellidos, $dni, $fecha, $telefono, $departamento, $ciudad, $direccion, $estado, $rol, $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Usuario actualizado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al actualizar usuario."]);
    }
    $conexion->close();
}

function delete_user($id) {
    global $conexion;
    $query = "DELETE FROM usuarios WHERE id_usuarios=?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Usuario eliminado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al eliminar usuario."]);
    }
    $conexion->close();
}

function delete_solicitud($id) {
    global $conexion;
    $query = "DELETE FROM solicitudes WHERE id=?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Solicitud eliminada exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al eliminar solicitud."]);
    }
    $conexion->close();
}

function delete_documento($id) {
    global $conexion;
    $query = "DELETE FROM documentos WHERE id=?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Documento eliminado exitosamente."]);
    } else {
        echo json_encode(["message" => "Error al eliminar documento."]);
    }
    $conexion->close();
}
?>
