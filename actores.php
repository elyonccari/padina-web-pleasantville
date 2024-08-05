<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Inicializa variables de alerta
$alertMessage = '';
$alertClass = '';

// Procesar formularios y operaciones con la base de datos
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
            $alertMessage = 'Actor editado exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    } else {
        // Añadir actor
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $direccion = $conn->real_escape_string($_POST['direccion']);
        $telefono = $conn->real_escape_string($_POST['telefono']);
        $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);

        $sql = "INSERT INTO Actor (nombre, direccion, telefono, correo_electronico) VALUES ('$nombre', '$direccion', '$telefono', '$correo_electronico')";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Actor añadido exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Eliminar las filas relacionadas en producciónactor
    $sql = "DELETE FROM producciónactor WHERE actor_id = $id";
    $conn->query($sql);

    // Eliminar el actor
    $sql = "DELETE FROM Actor WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $alertMessage = 'Actor eliminado exitosamente.';
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
    <title>Gestionar Actores</title>
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
        <h1>☆꧁░▒▓█ ACTORES █▓▒░꧂☆</h1>
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
                <!-- Botón para añadir actor -->
                <button type="button" class="btn btn-success btn-icon" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Añadir Actor
                </button>
            </div>
            <div class="col text-right">
                <!-- Botón para buscar actor -->
                <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#searchModal">
                    <i class="bi bi-search"></i> Buscar Actor
                </button>
            </div>
        </div>

        <!-- Modal para añadir actor -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Añadir Actor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="actores.php" method="POST">
                            <input type="text" name="nombre" placeholder="Nombre" required class="form-control mb-2">
                            <input type="text" name="direccion" placeholder="Dirección" class="form-control mb-2">
                            <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-2">
                            <input type="email" name="correo_electronico" placeholder="Correo Electrónico" class="form-control mb-2">
                            <button type="submit" class="btn btn-success btn-icon">
                                <i class="bi bi-plus"></i> Añadir Actor
                            </button>
                            <small class="form-text text-muted">¡Tu nuevo actor está a punto de entrar en escena! 🎭</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para buscar actor -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Actor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="actores.php" method="GET">
                            <input type="text" name="search" placeholder="Buscar..." class="form-control mb-2">
                            <select name="filter" class="form-control mb-2">
                                <option value="nombre">Nombre</option>
                                <option value="direccion">Dirección</option>
                                <option value="telefono">Teléfono</option>
                                <option value="correo_electronico">Correo Electrónico</option>
                            </select>
                            <button type="submit" class="btn btn-info btn-icon">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                            <small class="form-text text-muted">¡No es magia, solo un poco de búsqueda inteligente! 🔍</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de actores -->
        <table class="table table-bordered mt-3">
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
                if (isset($_GET['search']) && isset($_GET['filter'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $filter = $conn->real_escape_string($_GET['filter']);
                    $sql .= " WHERE $filter LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['nombre']}</td>";
                    echo "<td>{$row['direccion']}</td>";
                    echo "<td>{$row['telefono']}</td>";
                    echo "<td>{$row['correo_electronico']}</td>";
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

        <!-- Modal para editar actor -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Actor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="actores.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required class="form-control mb-2">
                                <input type="text" name="direccion" value="<?php echo $row['direccion']; ?>" required class="form-control mb-2">
                                <input type="text" name="telefono" value="<?php echo $row['telefono']; ?>" required class="form-control mb-2">
                                <input type="email" name="correo_electronico" value="<?php echo $row['correo_electronico']; ?>" required class="form-control mb-2">
                                <button type="submit" class="btn btn-warning btn-icon">
                                    <i class="bi bi-pencil"></i> Actualizar Actor
                                </button>
                                <small class="form-text text-muted">¡No te preocupes, no vamos a hacer que actúe como un robot! 😄</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Modal para eliminar actor -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Eliminar Actor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que quieres eliminar a <strong><?php echo $row['nombre']; ?></strong>? ¡Prometemos no llorar mucho! 😢</p>
                        </div>
                        <div class="modal-footer">
                            <a href="actores.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
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



