<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Inicializa variables de alerta
$alertMessage = '';
$alertClass = '';

// Procesar formularios y operaciones con la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        // Editar patrocinador
        $id = intval($_POST['id']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $direccion = $conn->real_escape_string($_POST['direccion']);
        $telefono = $conn->real_escape_string($_POST['telefono']);
        $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);

        $sql = "UPDATE Patrono SET nombre='$nombre', direccion='$direccion', telefono='$telefono', correo_electronico='$correo_electronico' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Patrocinador editado exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    } else {
        // Añadir patrocinador
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $direccion = $conn->real_escape_string($_POST['direccion']);
        $telefono = $conn->real_escape_string($_POST['telefono']);
        $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);

        $sql = "INSERT INTO Patrono (nombre, direccion, telefono, correo_electronico) VALUES ('$nombre', '$direccion', '$telefono', '$correo_electronico')";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Patrocinador añadido exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Eliminar las filas relacionadas en venta de boletos
    $sql = "DELETE FROM ventaboletos WHERE patrono_id = $id";
    if ($conn->query($sql) !== TRUE) {
        die("Error al eliminar los registros relacionados en ventaboletos: " . $conn->error);
    }

    // Eliminar el patrocinador
    $sql = "DELETE FROM Patrono WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $alertMessage = 'Patrocinador eliminado exitosamente.';
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
    <title>Gestionar Patrocinadores</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="scripts.js" defer></script>
    <style>
        .btn-icon {
            display: flex;
            align-items: center;
            font-size: 1rem;
            padding: 0.5rem;
        }
        .btn-icon i {
            margin-right: 0.5rem;
        }
        .btn-back {
            display: flex;
            justify-content: center;
            margin: 1rem 0;
        }
        .table-bordered {
            border: 2px solid #007bff;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #007bff;
        }
        .btn-container {
            display: flex;
            gap: 0.5rem;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem; /* Espacio entre los botones */
        }
    </style>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ PATROCINADORES █▓▒░꧂☆</h1>
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
                <!-- Botón para añadir patrocinador -->
                <button type="button" class="btn btn-success btn-icon" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Añadir Patrocinador
                </button>
            </div>
            <div class="col text-right">
                <!-- Botón para buscar patrocinador -->
                <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#searchModal">
                    <i class="bi bi-search"></i> Buscar Patrocinador
                </button>
            </div>
        </div>

        <!-- Modal para añadir patrocinador -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Añadir Patrocinador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="patrocinadores.php" method="POST">
                            <input type="text" name="nombre" placeholder="Nombre" required class="form-control mb-2">
                            <input type="text" name="direccion" placeholder="Dirección" class="form-control mb-2">
                            <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-2">
                            <input type="email" name="correo_electronico" placeholder="Correo Electrónico" class="form-control mb-2">
                            <button type="submit" class="btn btn-success btn-icon">
                                <i class="bi bi-plus"></i> Añadir Patrocinador
                            </button>
                            <small class="form-text text-muted">¡Tu nuevo patrocinador está a punto de hacer una gran entrada! 🎉</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para buscar patrocinador -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Patrocinador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="patrocinadores.php" method="GET">
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

        <!-- Tabla de patrocinadores -->
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
                // Consultar patrocinadores
                $sql = "SELECT * FROM Patrono";
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $filter = $conn->real_escape_string($_GET['filter']);
                    $sql .= " WHERE $filter LIKE '%$search%'";
                }
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['direccion']}</td>";
                        echo "<td>{$row['telefono']}</td>";
                        echo "<td>{$row['correo_electronico']}</td>";
                        echo "<td class='btn-container'>";
                        echo "<button type='button' class='btn btn-warning btn-icon' data-toggle='modal' data-target='#editModal{$row['id']}'>
                            <i class='bi bi-pencil'></i> Editar
                        </button>";
                        echo "<button type='button' class='btn btn-danger btn-icon' data-toggle='modal' data-target='#deleteModal{$row['id']}'>
                            <i class='bi bi-trash'></i> Eliminar
                        </button>";
                        echo "</td>";
                        echo "</tr>";

                        // Modal de edición
                        echo "<div class='modal fade' id='editModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='editModalLabel'>Editar Patrocinador</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='patrocinadores.php' method='POST'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <input type='text' name='nombre' value='{$row['nombre']}' placeholder='Nombre' required class='form-control mb-2'>
                                            <input type='text' name='direccion' value='{$row['direccion']}' placeholder='Dirección' class='form-control mb-2'>
                                            <input type='text' name='telefono' value='{$row['telefono']}' placeholder='Teléfono' class='form-control mb-2'>
                                            <input type='email' name='correo_electronico' value='{$row['correo_electronico']}' placeholder='Correo Electrónico' class='form-control mb-2'>
                                            <button type='submit' class='btn btn-warning btn-icon'>
                                                <i class='bi bi-pencil'></i> Editar
                                            </button>
                                            <small class='form-text text-muted'>¡Cambios con estilo! 🖌️</small>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";

                        // Modal de eliminación
                        echo "<div class='modal fade' id='deleteModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel' aria-hidden='true'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='deleteModalLabel'>Eliminar Patrocinador</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>¿Estás seguro de que quieres eliminar al patrocinador <strong>{$row['nombre']}</strong>? Este es un movimiento arriesgado, ¡pero sin duda uno audaz!</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <a href='patrocinadores.php?delete={$row['id']}' class='btn btn-danger'>
                                            <i class='bi bi-trash'></i> Eliminar
                                        </a>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>
                                            <i class='bi bi-x'></i> Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron patrocinadores.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
