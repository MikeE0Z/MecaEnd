<?php
include 'conexion.php';

// Crear un nuevo registro
if (isset($_POST['create'])) {
    $nombre_guia = $_POST['nombre_guia'];
    $numero_identificacion = $_POST['numero_identificacion'];
    $longevidad = $_POST['longevidad'];
    $salario = $_POST['salario'];
    $id_cliente = $_POST['id_cliente'];

    $sql = "INSERT INTO guias (nombre_guia, numero_identificacion, longevidad, salario, id_cliente)
            VALUES ('$nombre_guia', '$numero_identificacion', '$longevidad', '$salario', '$id_cliente')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Guía creada correctamente.</p>";
    } else {
        echo "<p>Error al crear la guía: " . $conn->error . "</p>";
    }
}

// Editar un registro existente
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre_guia = $_POST['nombre_guia'];
    $numero_identificacion = $_POST['numero_identificacion'];
    $longevidad = $_POST['longevidad'];
    $salario = $_POST['salario'];
    $id_cliente = $_POST['id_cliente'];

    $sql = "UPDATE guias SET 
            nombre_guia='$nombre_guia', 
            numero_identificacion='$numero_identificacion', 
            longevidad='$longevidad', 
            salario='$salario',
            id_cliente='$id_cliente'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Guía actualizada correctamente.</p>";
    } else {
        echo "<p>Error al actualizar la guía: " . $conn->error . "</p>";
    }
}

// Eliminar un registro
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM guias WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Guía eliminada correctamente.</p>";
    } else {
        echo "<p>Error al eliminar la guía: " . $conn->error . "</p>";
    }
}

// Obtener todos los registros
$result = $conn->query("SELECT g.*, c.nombre_usuario AS cliente_nombre 
                        FROM guias g
                        LEFT JOIN clientes c ON g.id_cliente = c.id");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Guías</title>
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
        .form-container input, .form-container select, .form-container button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }
    </style>
</head>
<body>

<h1>Gestión de Guías</h1>

<!-- Formulario para crear guías -->
<div class="form-container">
    <h2>Crear Nueva Guía</h2>
    <form method="POST" action="">
        <input type="text" name="nombre_guia" placeholder="Nombre del Guía" required>
        <input type="text" name="numero_identificacion" placeholder="Número de Identificación" required>
        <input type="number" name="longevidad" placeholder="Longevidad (años)">
        <input type="number" step="0.01" name="salario" placeholder="Salario" required>
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
        <button type="submit" name="create">Crear</button>
    </form>
</div>

<!-- Tabla de guías -->
<h2>Lista de Guías</h2>
<table>
    <tr>
        <th>Nombre</th>
        <th>Número de Identificación</th>
        <th>Longevidad</th>
        <th>Salario</th>
        <th>Cliente Asociado</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['nombre_guia']; ?></td>
        <td><?php echo $row['numero_identificacion']; ?></td>
        <td><?php echo $row['longevidad']; ?></td>
        <td><?php echo $row['salario']; ?></td>
        <td><?php echo $row['cliente_nombre'] ? $row['cliente_nombre'] : "Sin cliente"; ?></td>
        <td>
            <a href="?edit=<?php echo $row['id']; ?>">Editar</a>
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta guía?');">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
// Mostrar el formulario de edición si se selecciona una guía para editar
if (isset($_GET['edit'])):
    $id = $_GET['edit'];
    $guia = $conn->query("SELECT * FROM guias WHERE id='$id'")->fetch_assoc();
?>
<div class="form-container">
    <h2>Editar Guía</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $guia['id']; ?>">
        <input type="text" name="nombre_guia" value="<?php echo $guia['nombre_guia']; ?>" required>
        <input type="text" name="numero_identificacion" value="<?php echo $guia['numero_identificacion']; ?>" required>
        <input type="number" name="longevidad" value="<?php echo $guia['longevidad']; ?>">
        <input type="number" step="0.01" name="salario" value="<?php echo $guia['salario']; ?>" required>
        <select name="id_cliente" required>
            <option value="">Seleccionar Cliente</option>
            <?php
            $clientes = $conn->query("SELECT id, nombre_usuario FROM clientes");
            while ($cliente = $clientes->fetch_assoc()) {
                $selected = $cliente['id'] == $guia['id_cliente'] ? "selected" : "";
                echo "<option value='" . $cliente['id'] . "' $selected>" . $cliente['nombre_usuario'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="update">Actualizar</button>
    </form>
</div>
<?php endif; ?>

</body>
</html>
