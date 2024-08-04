<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Venta de Boletos</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ VENTA DE BOLETOS █▓▒░꧂☆</h1>
    </header>
    <nav>
        <a href="index.html" class="btn btn-blue">Volver Atrás</a>
    </nav>
    <div class="container">
        <!-- Formulario de búsqueda -->
        <form action="venta_boletos.php" method="GET">
            <input type="text" name="search" placeholder="Buscar Boleto">
            <button type="submit" class="btn btn-green">Buscar</button>
        </form>

        <!-- Formulario de adición de boletos -->
        <form action="venta_boletos.php" method="POST">
            <select name="produccion_id" required>
                <option value="" disabled selected>Seleccionar Producción</option>
                <?php
                // Obtener producciones
                $sql = "SELECT id, titulo FROM Producción";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['titulo']}</option>";
                }
                ?>
            </select>
            <select name="patrono_id" required>
                <option value="" disabled selected>Seleccionar Patrocinador</option>
                <?php
                // Obtener patrocinadores
                $sql = "SELECT id, nombre FROM Patrono";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>
            <input type="text" name="fila" placeholder="Fila" required>
            <input type="number" name="asiento" placeholder="Asiento" required>
            <input type="number" name="precio" placeholder="Precio" step="0.01" required>
            <button type="submit" class="btn btn-yellow">Añadir Boleto</button>
        </form>

        <!-- Tabla de boletos -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producción</th>
                    <th>Patrocinador</th>
                    <th>Fila</th>
                    <th>Asiento</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar boletos
                $sql = "SELECT VentaBoletos.id, Producción.titulo AS produccion, Patrono.nombre AS patrocinador, 
                        VentaBoletos.fila, VentaBoletos.asiento, VentaBoletos.precio
                        FROM VentaBoletos
                        JOIN Producción ON VentaBoletos.produccion_id = Producción.id
                        JOIN Patrono ON VentaBoletos.patrono_id = Patrono.id";
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE Producción.titulo LIKE '%$search%' OR Patrono.nombre LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['produccion']}</td>";
                    echo "<td>{$row['patrocinador']}</td>";
                    echo "<td>{$row['fila']}</td>";
                    echo "<td>{$row['asiento']}</td>";
                    echo "<td>{$row['precio']}</td>";
                    echo "<td>
                        <a href='venta_boletos.php?delete={$row['id']}' class='btn btn-red'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Manejar adición y eliminación de boletos
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $produccion_id = intval($_POST['produccion_id']);
            $patrono_id = intval($_POST['patrono_id']);
            $fila = $conn->real_escape_string($_POST['fila']);
            $asiento = intval($_POST['asiento']);
            $precio = floatval($_POST['precio']);

            $sql = "INSERT INTO VentaBoletos (produccion_id, patrono_id, fila, asiento, precio)
                    VALUES ($produccion_id, $patrono_id, '$fila', $asiento, $precio)";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Boleto añadido exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $sql = "DELETE FROM VentaBoletos WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Boleto eliminado exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
