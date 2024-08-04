<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Producciones</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ PRODUCCIONES █▓▒░꧂☆</h1>
    </header>
    <nav>
        <a href="index.html" class="btn btn-blue">Volver Atrás</a>
    </nav>
    <div class="container">
        <form action="producciones.php" method="GET">
            <input type="text" name="search" placeholder="Buscar Producción">
            <button type="submit" class="btn btn-green">Buscar</button>
        </form>
        <form action="producciones.php" method="POST">
            <input type="text" name="titulo" placeholder="Título" required>
            <input type="text" name="autor" placeholder="Autor">
            <input type="text" name="tipo" placeholder="Tipo">
            <input type="number" name="numero_actos" placeholder="Número de Actos">
            <select name="temporada">
                <option value="otoño">Otoño</option>
                <option value="primavera">Primavera</option>
            </select>
            <input type="number" name="año" placeholder="Año" required>
            <input type="number" name="productor_id" placeholder="ID del Productor" required>
            <button type="submit" class="btn btn-yellow">Añadir Producción</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Tipo</th>
                    <th>Número de Actos</th>
                    <th>Temporada</th>
                    <th>Año</th>
                    <th>Productor ID</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar producciones
                $sql = "SELECT * FROM Producción";
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE titulo LIKE '%$search%' OR autor LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['titulo']}</td>";
                    echo "<td>{$row['autor']}</td>";
                    echo "<td>{$row['tipo']}</td>";
                    echo "<td>{$row['numero_actos']}</td>";
                    echo "<td>{$row['temporada']}</td>";
                    echo "<td>{$row['año']}</td>";
                    echo "<td>{$row['productor_id']}</td>";
                    echo "<td>
                        <a href='producciones.php?delete={$row['id']}' class='btn btn-red'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        // Manejar adición y eliminación de producciones
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $conn->real_escape_string($_POST['titulo']);
            $autor = $conn->real_escape_string($_POST['autor']);
            $tipo = $conn->real_escape_string($_POST['tipo']);
            $numero_actos = intval($_POST['numero_actos']);
            $temporada = $conn->real_escape_string($_POST['temporada']);
            $año = intval($_POST['año']);
            $productor_id = intval($_POST['productor_id']);

            $sql = "INSERT INTO Producción (titulo, autor, tipo, numero_actos, temporada, año, productor_id)
                    VALUES ('$titulo', '$autor', '$tipo', $numero_actos, '$temporada', $año, $productor_id)";
            $conn->query($sql);
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $sql = "DELETE FROM Producción WHERE id = $id";
            $conn->query($sql);
        }
        ?>
    </div>
</body>
</html>
