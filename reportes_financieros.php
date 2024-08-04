<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Reportes Financieros</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ REPORTE FINANCIERO █▓▒░꧂☆</h1>
    </header>
    <nav>
        <a href="index.html" class="btn btn-blue">Volver Atrás</a>
    </nav>
    <div class="container">
        <!-- Formulario de búsqueda -->
        <form action="reportes_financieros.php" method="GET">
            <input type="text" name="search" placeholder="Buscar Reporte">
            <button type="submit" class="btn btn-green">Buscar</button>
        </form>

        <!-- Formulario de adición de reportes -->
        <form action="reportes_financieros.php" method="POST">
            <select name="tipo" required>
                <option value="" disabled selected>Seleccionar Tipo</option>
                <option value="ingreso">Ingreso</option>
                <option value="gasto">Gasto</option>
            </select>
            <input type="number" name="monto" placeholder="Monto" step="0.01" required>
            <input type="text" name="descripcion" placeholder="Descripción" required>
            <input type="date" name="fecha" required>
            <button type="submit" class="btn btn-yellow">Añadir Reporte</button>
        </form>

        <!-- Tabla de reportes -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar reportes financieros
                $sql = "SELECT * FROM ReporteFinanciero";
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE descripcion LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['tipo']}</td>";
                    echo "<td>{$row['monto']}</td>";
                    echo "<td>{$row['descripcion']}</td>";
                    echo "<td>{$row['fecha']}</td>";
                    echo "<td>
                        <a href='reportes_financieros.php?delete={$row['id']}' class='btn btn-red'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Manejar adición y eliminación de reportes financieros
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipo = $conn->real_escape_string($_POST['tipo']);
            $monto = floatval($_POST['monto']);
            $descripcion = $conn->real_escape_string($_POST['descripcion']);
            $fecha = $conn->real_escape_string($_POST['fecha']);

            $sql = "INSERT INTO ReporteFinanciero (tipo, monto, descripcion, fecha)
                    VALUES ('$tipo', $monto, '$descripcion', '$fecha')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Reporte financiero añadido exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $sql = "DELETE FROM ReporteFinanciero WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Reporte financiero eliminado exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
