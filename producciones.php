<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Inicializa variables de alerta
$alertMessage = '';
$alertClass = '';

// Procesar formularios y operaciones con la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        // Editar producción
        $id = intval($_POST['id']);
        $titulo = $conn->real_escape_string($_POST['titulo']);
        $autor = $conn->real_escape_string($_POST['autor']);
        $tipo = $conn->real_escape_string($_POST['tipo']);
        $numero_actos = intval($_POST['numero_actos']);
        $temporada = $conn->real_escape_string($_POST['temporada']);
        $año = intval($_POST['año']);
        $productor_id = intval($_POST['productor_id']);

        $sql = "UPDATE Producción SET titulo='$titulo', autor='$autor', tipo='$tipo', numero_actos=$numero_actos, temporada='$temporada', año=$año, productor_id=$productor_id WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Producción actualizada exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    } else {
        // Añadir producción
        $titulo = $conn->real_escape_string($_POST['titulo']);
        $autor = $conn->real_escape_string($_POST['autor']);
        $tipo = $conn->real_escape_string($_POST['tipo']);
        $numero_actos = intval($_POST['numero_actos']);
        $temporada = $conn->real_escape_string($_POST['temporada']);
        $año = intval($_POST['año']);
        $productor_id = intval($_POST['productor_id']);

        $sql = "INSERT INTO Producción (titulo, autor, tipo, numero_actos, temporada, año, productor_id) VALUES ('$titulo', '$autor', '$tipo', $numero_actos, '$temporada', $año, $productor_id)";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Producción añadida exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Eliminar la producción
    $sql = "DELETE FROM Producción WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $alertMessage = 'Producción eliminada exitosamente.';
        $alertClass = 'alert-success';
    } else {
        $alertMessage = 'Error: ' . $conn->error;
        $alertClass = 'alert-danger';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Producciones</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="scripts.js" defer></script>
    <style>
        .btn-icon {
            display: flex;
            align-items: center;
            font-size: 1rem; /* Tamaño del texto */
            padding: 0.5rem; /* Padding alrededor del icono */
        }
        .btn-icon i {
            margin-right: 0.5rem; /* Espacio entre el icono y el texto */
        }
        .btn-back {
            display: flex;
            justify-content: center;
            margin: 1rem 0; /* Margen arriba y abajo */
        }
        .table-bordered {
            border: 2px solid #007bff; /* Color del borde azul */
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #007bff; /* Bordes de celdas en color azul */
        }
        .btn-container {
            display: flex;
            gap: 0.5rem; /* Espacio entre los botones */
        }
    </style>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ PRODUCCIONES █▓▒░꧂☆</h1>
    </header>
    <nav class="btn-back">
        <a href="index.html" class="btn btn-primary btn-icon">
            <i class="bi bi-arrow-left"></i> Volver Atrás
        </a>
    </nav>
    <div class="container">
        <?php
        // Mostrar alertas
        if (!empty($alertMessage)) {
            echo "<div class='alert $alertClass' role='alert'>$alertMessage</div>";
        }
        ?>

        <!-- Fila para los botones de añadir y buscar -->
        <div class="row mb-3">
            <div class="col">
                <!-- Botón para añadir producción -->
                <button type="button" class="btn btn-success btn-icon" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Añadir Producción
                </button>
            </div>
            <div class="col text-right">
                <!-- Botón para buscar producción -->
                <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#searchModal">
                    <i class="bi bi-search"></i> Buscar Producción
                </button>
            </div>
        </div>

        <!-- Modal para añadir producción -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Añadir Producción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="producciones.php" method="POST">
                            <input type="text" name="titulo" placeholder="Título" required class="form-control mb-2">
                            <input type="text" name="autor" placeholder="Autor" class="form-control mb-2">
                            <input type="text" name="tipo" placeholder="Tipo" class="form-control mb-2">
                            <input type="number" name="numero_actos" placeholder="Número de Actos" class="form-control mb-2">
                            <select name="temporada" class="form-control mb-2">
                                <option value="otoño">Otoño</option>
                                <option value="primavera">Primavera</option>
                            </select>
                            <input type="number" name="año" placeholder="Año" required class="form-control mb-2">
                            <input type="number" name="productor_id" placeholder="ID del Productor" required class="form-control mb-2">
                            <button type="submit" class="btn btn-success btn-icon">
                                <i class="bi bi-plus"></i> Añadir Producción
                            </button>
                            <small class="form-text text-muted">¡Tu nueva producción está a punto de subir al escenario! 🎭</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para buscar producción -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Producción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="producciones.php" method="GET">
                            <input type="text" name="search" placeholder="Buscar..." class="form-control mb-2">
                            <select name="filter" class="form-control mb-2">
                                <option value="titulo">Título</option>
                                <option value="autor">Autor</option>
                                <option value="tipo">Tipo</option>
                                <option value="numero_actos">Número de Actos</option>
                                <option value="temporada">Temporada</option>
                                <option value="año">Año</option>
                                <option value="productor_id">ID del Productor</option>
                            </select>
                            <button type="submit" class="btn btn-info btn-icon">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                            <small class="form-text text-muted">¡Encuentra la producción perfecta con solo unos clics! 🔍</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de producciones -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Tipo</th>
                    <th>Número de Actos</th>
                    <th>Temporada</th>
                    <th>Año</th>
                    <th>ID del Productor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar producciones
                $sql = "SELECT * FROM Producción";
                if (isset($_GET['search']) && isset($_GET['filter'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $filter = $conn->real_escape_string($_GET['filter']);
                    $sql .= " WHERE $filter LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
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
                        <div class='btn-container'>
                            <a href='javascript:void(0);' data-toggle='modal' data-target='#editModal{$row['id']}' class='btn btn-warning btn-icon'>
                                <i class='bi bi-pencil'></i> Editar
                            </a>
                            <a href='javascript:void(0);' data-toggle='modal' data-target='#deleteModal{$row['id']}' class='btn btn-danger btn-icon'>
                                <i class='bi bi-trash'></i> Eliminar
                            </a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal para editar producción -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Producción</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="producciones.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>" required class="form-control mb-2">
                                <input type="text" name="autor" value="<?php echo $row['autor']; ?>" required class="form-control mb-2">
                                <input type="text" name="tipo" value="<?php echo $row['tipo']; ?>" required class="form-control mb-2">
                                <input type="number" name="numero_actos" value="<?php echo $row['numero_actos']; ?>" required class="form-control mb-2">
                                <select name="temporada" class="form-control mb-2">
                                    <option value="otoño" <?php if ($row['temporada'] == 'otoño') echo 'selected'; ?>>Otoño</option>
                                    <option value="primavera" <?php if ($row['temporada'] == 'primavera') echo 'selected'; ?>>Primavera</option>
                                </select>
                                <input type="number" name="año" value="<?php echo $row['año']; ?>" required class="form-control mb-2">
                                <input type="number" name="productor_id" value="<?php echo $row['productor_id']; ?>" required class="form-control mb-2">
                                <button type="submit" class="btn btn-warning btn-icon">
                                    <i class="bi bi-pencil"></i> Actualizar Producción
                                </button>
                                <small class="form-text text-muted">¡No te preocupes, no vamos a hacer que actúe como un robot! 😄</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Modal para eliminar producción -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Eliminar Producción</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que quieres eliminar la producción <strong><?php echo $row['titulo']; ?></strong>? ¡Prometemos no llorar mucho! 😢</p>
                        </div>
                        <div class="modal-footer">
                            <a href="producciones.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

