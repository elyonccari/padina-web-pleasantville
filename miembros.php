<?php
include 'db.php'; // Asegúrate de incluir la conexión a la base de datos correctamente

// Inicializa variables de alerta
$alertMessage = '';
$alertClass = '';

// Procesar formularios y operaciones con la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica si se envió el formulario para editar o añadir
    if (isset($_POST['id'])) {
        // Editar miembro
        $id = intval($_POST['id']);
        $nombre = isset($_POST['nombre']) ? $conn->real_escape_string($_POST['nombre']) : '';
        $direccion = isset($_POST['direccion']) ? $conn->real_escape_string($_POST['direccion']) : '';
        $telefono = isset($_POST['telefono']) ? $conn->real_escape_string($_POST['telefono']) : '';
        $correo_electronico = isset($_POST['correo_electronico']) ? $conn->real_escape_string($_POST['correo_electronico']) : '';

        $sql = "UPDATE Miembro SET nombre='$nombre', direccion='$direccion', telefono='$telefono', correo_electronico='$correo_electronico' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Miembro editado exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    } elseif (isset($_POST['nombre']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['correo_electronico'])) {
        // Añadir miembro
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $direccion = $conn->real_escape_string($_POST['direccion']);
        $telefono = $conn->real_escape_string($_POST['telefono']);
        $correo_electronico = $conn->real_escape_string($_POST['correo_electronico']);

        $sql = "INSERT INTO Miembro (nombre, direccion, telefono, correo_electronico) VALUES ('$nombre', '$direccion', '$telefono', '$correo_electronico')";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Miembro añadido exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    }
}

// Eliminar miembro
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);

    // Verifica y elimina las relaciones antes de eliminar el miembro
    $tables = ['Producción', 'ProducciónPatrono', 'VentaBoletos']; // Agrega más tablas si es necesario

    foreach ($tables as $table) {
        $sql = "DELETE FROM $table WHERE productor_id = $id";
        $conn->query($sql);
    }

    // Eliminar el miembro
    $sql = "DELETE FROM Miembro WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $alertMessage = 'Miembro eliminado exitosamente.';
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
    <title>Gestionar Miembros</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        function confirmDelete(id, nombre) {
            document.getElementById('delete_id').value = id;
            document.getElementById('delete_name').innerHTML = '¿Estás seguro de que quieres eliminar a <strong>' + nombre + '</strong>? <br> ¡Cuidado! Esta acción no se puede deshacer y el miembro se va a perder para siempre. 😱';
            $('#deleteModal').modal('show');
        }

        function editMember(id, nombre, direccion, telefono, correo_electronico) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_direccion').value = direccion;
            document.getElementById('edit_telefono').value = telefono;
            document.getElementById('edit_correo_electronico').value = correo_electronico;
            $('#editModal').modal('show');
        }

        function searchMember() {
            let query = document.getElementById('search_query').value;
            document.getElementById('search_form').submit();
        }
    </script>
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
        .modal-footer {
            display: flex;
            justify-content: flex-end; /* Alinea los botones al final del contenedor */
        }
    </style>
</head>
<body>
    <header>
        <h1>☆꧁░▒▓█ MIEMBROS █▓▒░꧂☆</h1>
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
                <!-- Botón para añadir miembro -->
                <button type="button" class="btn btn-success btn-icon" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Añadir Miembro
                </button>
            </div>
            <div class="col text-right">
                <!-- Botón para buscar miembro -->
                <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#searchModal">
                    <i class="bi bi-search"></i> Buscar Miembro
                </button>
            </div>
        </div>

        <!-- Modal para añadir miembro -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Añadir Miembro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="miembros.php" method="POST">
                            <input type="text" name="nombre" placeholder="Nombre" required class="form-control mb-2">
                            <input type="text" name="direccion" placeholder="Dirección" class="form-control mb-2">
                            <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-2">
                            <input type="email" name="correo_electronico" placeholder="Correo Electrónico" class="form-control mb-2">
                            <button type="submit" class="btn btn-success btn-icon">
                                <i class="bi bi-plus"></i> Añadir Miembro
                            </button>
                            <small class="form-text text-muted">¡Tu nuevo miembro está a punto de unirse al elenco! 🎭</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para buscar miembro -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Miembro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="search_form" action="miembros.php" method="GET">
                            <input type="text" id="search_query" name="query" placeholder="Buscar por nombre, dirección, etc." class="form-control mb-2">
                            <button type="button" class="btn btn-info btn-icon" onclick="searchMember()">
                                <i class="bi bi-search"></i> Filtrar
                            </button>
                        </form>
                        <small class="form-text text-muted">¡Espero que encuentres a tu miembro rápidamente! Si no lo haces, no dudes en preguntarle a tu ordenador, él tiene muchas ideas... o no. 😅</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de miembros -->
        <table class="table table-bordered">
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
                // Consulta de miembros
                $sql = "SELECT * FROM Miembro";
                if (isset($_GET['query'])) {
                    $query = $conn->real_escape_string($_GET['query']);
                    $sql .= " WHERE nombre LIKE '%$query%' OR direccion LIKE '%$query%' OR telefono LIKE '%$query%' OR correo_electronico LIKE '%$query%'";
                }
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['direccion']}</td>
                            <td>{$row['telefono']}</td>
                            <td>{$row['correo_electronico']}</td>
                            <td class='btn-container'>
                                <button class='btn btn-warning btn-icon' onclick='editMember({$row['id']}, \"{$row['nombre']}\", \"{$row['direccion']}\", \"{$row['telefono']}\", \"{$row['correo_electronico']}\")'>
                                    <i class='bi bi-pencil'></i> Editar
                                </button>
                                <button class='btn btn-danger btn-icon' onclick='confirmDelete({$row['id']}, \"{$row['nombre']}\")'>
                                    <i class='bi bi-trash'></i> Eliminar
                                </button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay miembros disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para eliminar miembro -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar Miembro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="delete_name"></p>
                    <form action="miembros.php" method="POST">
                        <input type="hidden" id="delete_id" name="delete_id" value="">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar miembro -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Miembro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="miembros.php" method="POST">
                        <input type="hidden" id="edit_id" name="id" value="">
                        <input type="text" id="edit_nombre" name="nombre" placeholder="Nombre" required class="form-control mb-2">
                        <input type="text" id="edit_direccion" name="direccion" placeholder="Dirección" class="form-control mb-2">
                        <input type="text" id="edit_telefono" name="telefono" placeholder="Teléfono" class="form-control mb-2">
                        <input type="email" id="edit_correo_electronico" name="correo_electronico" placeholder="Correo Electrónico" class="form-control mb-2">
                        <button type="submit" class="btn btn-warning btn-icon">
                            <i class="bi bi-pencil"></i> Editar Miembro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
