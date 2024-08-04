<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Suscriptores</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ SUSCRIPTORES █▓▒░꧂☆</h1>
    </header>
    <nav>
        <a href="index.html" class="btn btn-blue">Volver Atrás</a>
    </nav>
    <div class="container">
        <!-- Formulario de búsqueda -->
        <form action="suscriptores.php" method="GET">
            <input type="text" name="search" placeholder="Buscar Suscriptor">
            <button type="submit" class="btn btn-green">Buscar</button>
        </form>

        <!-- Formulario de adición de suscriptores -->
        <form action="suscriptores.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="direccion" placeholder="Dirección">
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="email" name="correo_electronico" placeholder="Correo Electrónico">
            <button type="submit" class="btn btn-yellow">Añadir Suscriptor</button>
        </form>

        <!-- Tabla de suscriptores -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Cuota Pagada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar suscriptores
                $sql = "SELECT * FROM Suscriptor";
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE nombre LIKE '%$search%' OR direccion LIKE '%$search%' OR telefono LIKE '%$search%' OR correo_electronico LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['nombre']}</td>";
                    echo "<td>{$row['direccion']}</td>";
                    echo "<td>{$row['telefono']}</td>";
                    echo "<td>{$row['correo_electronico']}</td>";
                    echo "<td>" . ($row['cuota_pagada'] ? 'Sí' : 'No') . "</td>";
                    echo "<td>
                        <a href='suscriptores.php?delete={$row['id']}' class='btn btn-red'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Manejar adición y eliminación de suscriptores
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $conn->real_escape_string($_POST['nombre']);
            $direccion = $conn->real_escape_string($_POST['direccion']);
            $telefono = $conn->real_escape_string($_POST['telefono']);
            $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);
            $cuota_pagada = isset($_POST['cuota_pagada']) ? 1 : 0;

            $sql = "INSERT INTO Suscriptor (nombre, direccion, telefono, correo_electronico, cuota_pagada)
                    VALUES ('$nombre', '$direccion', '$telefono', '$correo_electronico', $cuota_pagada)";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Suscriptor añadido exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $sql = "DELETE FROM Suscriptor WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Suscriptor eliminado exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
