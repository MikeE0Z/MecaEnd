<?php
include 'conexion.php';

// Crear un nuevo comentario
if (isset($_POST['create'])) {
    $id_cliente = $_POST['id_cliente'];
    $comentario_usuario = $_POST['comentario_usuario'];

    $sql = "INSERT INTO comentarios (id_cliente, comentario_usuario)
            VALUES ('$id_cliente', '$comentario_usuario')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Comentario creado correctamente.</p>";
    } else {
        echo "<p>Error al crear el comentario: " . $conn->error . "</p>";
    }
}

// Editar un comentario existente
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $comentario_usuario = $_POST['comentario_usuario'];
    $comentario_admin = $_POST['comentario_admin'];

    $sql = "UPDATE comentarios SET 
            comentario_usuario='$comentario_usuario', 
            comentario_admin='$comentario_admin'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Comentario actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar el comentario: " . $conn->error . "</p>";
    }
}

// Eliminar un comentario
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM comentarios WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Comentario eliminado correctamente.</p>";
    } else {
        echo "<p>Error al eliminar el comentario: " . $conn->error . "</p>";
    }
}

// Obtener todos los registros
$result = $conn->query("SELECT c.*, cl.nombre_usuario 
                        FROM comentarios c
                        LEFT JOIN clientes cl ON c.id_cliente = cl.id");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Comentarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f7f2;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #008080;
            color: white;
        }
        button {
            background-color: #008080;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #006060;
        }
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-container input, .form-container textarea, .form-container select, .form-container button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }
    </style>
</head>
<body>

<h1>Gestión de Comentarios</h1>

<!-- Formulario para crear comentarios -->
<div class="form-container">
    <h2>Crear Nuevo Comentario</h2>
    <form method="POST" action="">
        <select name="id_cliente" required>
            <option value="">Seleccionar Cliente</option>
            <?php
            // Obtener lista de clientes
            $clientes = $conn->query("SELECT id, nombre_usuario FROM clientes");
            while ($cliente = $clientes->fetch_assoc()) {
                echo "<option value='" . $cliente['id'] . "'>" . $cliente['nombre_usuario'] . "</option>";
            }
            ?>
        </select>
        <textarea name="comentario_usuario" placeholder="Comentario del Usuario" required></textarea>
        <button type="submit" name="create">Crear</button>
    </form>
</div>

<!-- Tabla de comentarios -->
<h2>Lista de Comentarios</h2>
<table>
    <tr>
        <th>Cliente</th>
        <th>Comentario Usuario</th>
        <th>Comentario Admin</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['nombre_usuario']; ?></td>
        <td><?php echo $row['comentario_usuario']; ?></td>
        <td><?php echo $row['comentario_admin'] ? $row['comentario_admin'] : "Sin respuesta"; ?></td>
        <td><?php echo $row['fecha_comentario']; ?></td>
        <td>
            <a href="?edit=<?php echo $row['id']; ?>">Editar</a>
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este comentario?');">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
// Mostrar el formulario de edición si se selecciona un comentario para editar
if (isset($_GET['edit'])):
    $id = $_GET['edit'];
    $comentario = $conn->query("SELECT * FROM comentarios WHERE id='$id'")->fetch_assoc();
?>
<div class="form-container">
    <h2>Editar Comentario</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $comentario['id']; ?>">
        <textarea name="comentario_usuario" required><?php echo $comentario['comentario_usuario']; ?></textarea>
        <textarea name="comentario_admin"><?php echo $comentario['comentario_admin']; ?></textarea>
        <button type="submit" name="update">Actualizar</button>
    </form>
</div>
<?php endif; ?>

</body>
</html>
