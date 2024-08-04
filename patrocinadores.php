<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Patrocinadores</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ PATROCINADORES █▓▒░꧂☆</h1>
    </header>
    <nav>
        <a href="index.html" class="btn btn-blue">Volver Atrás</a>
    </nav>
    <div class="container">
        <!-- Formulario de búsqueda -->
        <form action="patrocinadores.php" method="GET">
            <input type="text" name="search" placeholder="Buscar Patrocinador">
            <button type="submit" class="btn btn-green">Buscar</button>
        </form>

        <!-- Formulario de adición de patrocinadores -->
        <form action="patrocinadores.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="direccion" placeholder="Dirección">
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="email" name="correo_electronico" placeholder="Correo Electrónico">
            <button type="submit" class="btn btn-green">Añadir Patrocinador</button>
        </form>

        <!-- Tabla de patrocinadores -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar patrocinadores
                $sql = "SELECT * FROM Patrono";
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE nombre LIKE '%$search%' OR direccion LIKE '%$search%' OR telefono LIKE '%$search%' OR correo_electronico LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['nombre']}</td>";
                    echo "<td>{$row['direccion']}</td>";
                    echo "<td>{$row['telefono']}</td>";
                    echo "<td>{$row['correo_electronico']}</td>";
                    echo "<td>
                        <a href='patrocinadores.php?delete={$row['id']}' class='btn btn-red'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Manejar adición y eliminación de patrocinadores
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $conn->real_escape_string($_POST['nombre']);
            $direccion = $conn->real_escape_string($_POST['direccion']);
            $telefono = $conn->real_escape_string($_POST['telefono']);
            $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);

            $sql = "INSERT INTO Patrono (nombre, direccion, telefono, correo_electronico)
                    VALUES ('$nombre', '$direccion', '$telefono', '$correo_electronico')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Patrocinador añadido exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $sql = "DELETE FROM Patrono WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Patrocinador eliminado exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
