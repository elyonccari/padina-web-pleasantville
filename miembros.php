<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Miembros</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ MIEMBROS █▓▒░꧂☆</h1>
    </header>
    <nav>
        <a href="index.html" class="btn btn-primary">Volver Atrás</a>
    </nav>
    <div class="container">
        <form action="miembros.php" method="GET">
            <input type="text" name="search" placeholder="Buscar Miembro" class="form-control mb-2">
            <button type="submit" class="btn btn-info">Buscar</button>
        </form>
        <form action="miembros.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required class="form-control mb-2">
            <input type="text" name="direccion" placeholder="Dirección" class="form-control mb-2">
            <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-2">
            <input type="email" name="correo_electronico" placeholder="Correo Electrónico" class="form-control mb-2">
            <label class="d-block mb-2">
                <input type="checkbox" name="cuota_pagada"> Cuota Pagada
            </label>
            <button type="submit" class="btn btn-success">Añadir Miembro</button>
        </form>
        <table class="table table-striped mt-3">
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
                // Mostrar miembros
                $sql = "SELECT * FROM Miembro";
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
                    echo "<td>" . ($row['cuota_pagada'] ? 'Sí' : 'No') . "</td>";
                    echo "<td>
                        <a href='miembros.php?delete={$row['id']}' class='btn btn-danger'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        // Manejar adición y eliminación de miembros
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $conn->real_escape_string($_POST['nombre']);
            $direccion = $conn->real_escape_string($_POST['direccion']);
            $telefono = $conn->real_escape_string($_POST['telefono']);
            $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);
            $cuota_pagada = isset($_POST['cuota_pagada']) ? 1 : 0;

            $sql = "INSERT INTO Miembro (nombre, direccion, telefono, correo_electronico, cuota_pagada)
                    VALUES ('$nombre', '$direccion', '$telefono', '$correo_electronico', $cuota_pagada)";
            $conn->query($sql);
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $sql = "DELETE FROM Miembro WHERE id = $id";
            $conn->query($sql);
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
