<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Actores</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ ACTORES █▓▒░꧂☆</h1>
    </header>
    <nav>
        <a href="index.html" class="btn btn-primary">Volver Atrás</a>
    </nav>
    <div class="container">
        <!-- Formulario de búsqueda -->
        <form action="actores.php" method="GET">
            <input type="text" name="search" placeholder="Buscar Actor" class="form-control mb-2">
            <button type="submit" class="btn btn-info">Buscar</button>
        </form>

        <!-- Formulario de adición de actores -->
        <form action="actores.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required class="form-control mb-2">
            <input type="text" name="direccion" placeholder="Dirección" class="form-control mb-2">
            <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-2">
            <input type="email" name="correo_electronico" placeholder="Correo Electrónico" class="form-control mb-2">
            <button type="submit" class="btn btn-success">Añadir Actor</button>
        </form>

        <!-- Formulario de edición de actores -->
        <?php
        if (isset($_GET['edit'])) {
            $id = intval($_GET['edit']);
            $sql = "SELECT * FROM Actor WHERE id = $id";
            $result = $conn->query($sql);
            $actor = $result->fetch_assoc();
        }
        ?>
        <?php if (isset($actor)): ?>
            <h2>Editar Actor</h2>
            <form action="actores.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $actor['id']; ?>">
                <input type="text" name="nombre" value="<?php echo $actor['nombre']; ?>" required class="form-control mb-2">
                <input type="text" name="direccion" value="<?php echo $actor['direccion']; ?>" required class="form-control mb-2">
                <input type="text" name="telefono" value="<?php echo $actor['telefono']; ?>" required class="form-control mb-2">
                <input type="email" name="correo_electronico" value="<?php echo $actor['correo_electronico']; ?>" required class="form-control mb-2">
                <button type="submit" class="btn btn-warning">Actualizar Actor</button>
            </form>
        <?php endif; ?>

        <!-- Tabla de actores -->
        <table class="table table-striped mt-3">
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
                // Consultar actores
                $sql = "SELECT * FROM Actor";
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
                        <a href='actores.php?edit={$row['id']}' class='btn btn-warning'>Editar</a>
                        <a href='actores.php?delete={$row['id']}' class='btn btn-danger'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Manejar adición, eliminación y edición de actores
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id'])) {
                // Editar actor
                $id = intval($_POST['id']);
                $nombre = $conn->real_escape_string($_POST['nombre']);
                $direccion = $conn->real_escape_string($_POST['direccion']);
                $telefono = $conn->real_escape_string($_POST['telefono']);
                $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);

                $sql = "UPDATE Actor SET nombre='$nombre', direccion='$direccion', telefono='$telefono', correo_electronico='$correo_electronico' WHERE id=$id";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Actor editado exitosamente.</p>";
                } else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
            } else {
                // Añadir actor
                $nombre = $conn->real_escape_string($_POST['nombre']);
                $direccion = $conn->real_escape_string($_POST['direccion']);
                $telefono = $conn->real_escape_string($_POST['telefono']);
                $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);

                $sql = "INSERT INTO Actor (nombre, direccion, telefono, correo_electronico)
                        VALUES ('$nombre', '$direccion', '$telefono', '$correo_electronico')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Actor añadido exitosamente.</p>";
                } else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
            }
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $sql = "DELETE FROM Actor WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Actor eliminado exitosamente.</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

