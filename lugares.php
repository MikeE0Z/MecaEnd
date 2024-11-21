<?php
include 'conexion.php';

// Crear un nuevo lugar
if (isset($_POST['create'])) {
    $nombre_lugar = $_POST['nombre_lugar'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $costo_por_persona = $_POST['costo_por_persona'];
    $descuento = $_POST['descuento'];
    $anticipo = $_POST['anticipo'];
    $guia_especializado = $_POST['guia_especializado'];

    $sql = "INSERT INTO lugares (nombre_lugar, fecha_inicio, fecha_fin, costo_por_persona, descuento, anticipo, guia_especializado)
            VALUES ('$nombre_lugar', '$fecha_inicio', '$fecha_fin', '$costo_por_persona', '$descuento', '$anticipo', '$guia_especializado')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Lugar creado correctamente.</p>";
    } else {
        echo "<p>Error al crear el lugar: " . $conn->error . "</p>";
    }
}

// Editar un lugar existente
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre_lugar = $_POST['nombre_lugar'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $costo_por_persona = $_POST['costo_por_persona'];
    $descuento = $_POST['descuento'];
    $anticipo = $_POST['anticipo'];
    $guia_especializado = $_POST['guia_especializado'];

    $sql = "UPDATE lugares SET 
            nombre_lugar='$nombre_lugar', 
            fecha_inicio='$fecha_inicio', 
            fecha_fin='$fecha_fin', 
            costo_por_persona='$costo_por_persona', 
            descuento='$descuento', 
            anticipo='$anticipo', 
            guia_especializado='$guia_especializado'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Lugar actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar el lugar: " . $conn->error . "</p>";
    }
}

// Eliminar un lugar
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM lugares WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Lugar eliminado correctamente.</p>";
    } else {
        echo "<p>Error al eliminar el lugar: " . $conn->error . "</p>";
    }
}

// Obtener todos los registros
$result = $conn->query("SELECT l.*, c.nombre_usuario AS guia_nombre 
                        FROM lugares l
                        LEFT JOIN clientes c ON l.guia_especializado = c.id");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Lugares</title>
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

<h1>Gestión de Lugares</h1>

<!-- Formulario para crear lugares -->
<div class="form-container">
    <h2>Crear Nuevo Lugar</h2>
    <form method="POST" action="">
        <input type="text" name="nombre_lugar" placeholder="Nombre del Lugar" required>
        <input type="date" name="fecha_inicio" required>
        <input type="date" name="fecha_fin" required>
        <input type="number" step="0.01" name="costo_por_persona" placeholder="Costo por Persona" required>
        <input type="number" step="0.01" name="descuento" placeholder="Descuento (opcional)">
        <input type="number" step="0.01" name="anticipo" placeholder="Anticipo (opcional)">
        <select name="guia_especializado">
            <option value="">Seleccionar Guía Especializado</option>
            <?php
            // Obtener lista de guías
            $guias = $conn->query("SELECT id, nombre_usuario FROM clientes");
            while ($guia = $guias->fetch_assoc()) {
                echo "<option value='" . $guia['id'] . "'>" . $guia['nombre_usuario'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="create">Crear</button>
    </form>
</div>

<!-- Tabla de lugares -->
<h2>Lista de Lugares</h2>
<table>
    <tr>
        <th>Nombre</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Costo</th>
        <th>Descuento</th>
        <th>Anticipo</th>
        <th>Guía Especializado</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['nombre_lugar']; ?></td>
        <td><?php echo $row['fecha_inicio']; ?></td>
        <td><?php echo $row['fecha_fin']; ?></td>
        <td><?php echo $row['costo_por_persona']; ?></td>
        <td><?php echo $row['descuento'] ?: "N/A"; ?></td>
        <td><?php echo $row['anticipo'] ?: "N/A"; ?></td>
        <td><?php echo $row['guia_nombre'] ?: "Sin Asignar"; ?></td>
        <td>
            <a href="?edit=<?php echo $row['id']; ?>">Editar</a>
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este lugar?');">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
// Mostrar el formulario de edición si se selecciona un lugar para editar
if (isset($_GET['edit'])):
    $id = $_GET['edit'];
    $lugar = $conn->query("SELECT * FROM lugares WHERE id='$id'")->fetch_assoc();
?>
<div class="form-container">
    <h2>Editar Lugar</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $lugar['id']; ?>">
        <input type="text" name="nombre_lugar" value="<?php echo $lugar['nombre_lugar']; ?>" required>
        <input type="date" name="fecha_inicio" value="<?php echo $lugar['fecha_inicio']; ?>" required>
        <input type="date" name="fecha_fin" value="<?php echo $lugar['fecha_fin']; ?>" required>
        <input type="number" step="0.01" name="costo_por_persona" value="<?php echo $lugar['costo_por_persona']; ?>" required>
        <input type="number" step="0.01" name="descuento" value="<?php echo $lugar['descuento']; ?>">
        <input type="number" step="0.01" name="anticipo" value="<?php echo $lugar['anticipo']; ?>">
        <select name="guia_especializado">
            <option value="">Seleccionar Guía Especializado</option>
            <?php
            $guias = $conn->query("SELECT id, nombre_usuario FROM clientes");
            while ($guia = $guias->fetch_assoc()) {
                $selected = $guia['id'] == $lugar['guia_especializado'] ? "selected" : "";
                echo "<option value='" . $guia['id'] . "' $selected>" . $guia['nombre_usuario'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="update">Actualizar</button>
    </form>
</div>
<?php endif; ?>

</body>
</html>
