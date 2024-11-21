<?php
session_start();

// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "123";
$base_datos = "MecaYuca";

$conn = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT id, rol, contrasena FROM clientes WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->bind_result($id, $rol, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if ($hashed_password && password_verify($contrasena, $hashed_password)) {
        $_SESSION['id'] = $id;
        $_SESSION['rol'] = $rol;

        if ($rol === 'admin') {
            header("Location: admin.html");
        } else {
            header("Location: clientes.html");
        }
        exit();
    } else {
        echo "<p>Usuario o contraseña incorrectos.</p>";
    }
}

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $rol = 'usuario'; // Todos los registros nuevos serán "usuario" por defecto
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $query = "INSERT INTO clientes (rol, nombre_usuario, correo, contrasena) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $rol, $nombre_usuario, $correo, $contrasena);

    if ($stmt->execute()) {
        echo "<p>Usuario registrado exitosamente.</p>";
    } else {
        echo "<p>Error al registrar usuario: " . $conn->error . "</p>";
    }
    $stmt->close();
}

$conn->close();
?>
