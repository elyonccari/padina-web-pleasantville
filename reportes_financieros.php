<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Inicializa variables de alerta
$alertMessage = '';
$alertClass = '';

// Procesar formularios y operaciones con la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        // Editar reporte financiero
        $id = intval($_POST['id']);
        $tipo = $conn->real_escape_string($_POST['tipo']);
        $monto = floatval($_POST['monto']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $fecha = $conn->real_escape_string($_POST['fecha']);

        $sql = "UPDATE ReporteFinanciero SET tipo='$tipo', monto=$monto, descripcion='$descripcion', fecha='$fecha' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Reporte financiero editado exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    } else {
        // Añadir reporte financiero
        $tipo = $conn->real_escape_string($_POST['tipo']);
        $monto = floatval($_POST['monto']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $fecha = $conn->real_escape_string($_POST['fecha']);

        $sql = "INSERT INTO ReporteFinanciero (tipo, monto, descripcion, fecha) VALUES ('$tipo', $monto, '$descripcion', '$fecha')";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Reporte financiero añadido exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Eliminar el reporte financiero
    $sql = "DELETE FROM ReporteFinanciero WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $alertMessage = 'Reporte financiero eliminado exitosamente.';
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
    <title>Gestionar Reportes Financieros</title>
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
        <h1>☆꧁░▒▓█ REPORTE FINANCIERO █▓▒░꧂☆</h1>
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
                <!-- Botón para añadir reporte financiero -->
                <button type="button" class="btn btn-success btn-icon" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Añadir Reporte
                </button>
            </div>
            <div class="col text-right">
                <!-- Botón para buscar reporte financiero -->
                <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#searchModal">
                    <i class="bi bi-search"></i> Buscar Reporte
                </button>
            </div>
        </div>

        <!-- Modal para añadir reporte financiero -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Añadir Reporte Financiero</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="reportes_financieros.php" method="POST">
                            <select name="tipo" required class="form-control mb-2">
                                <option value="" disabled selected>Seleccionar Tipo</option>
                                <option value="ingreso">Ingreso</option>
                                <option value="gasto">Gasto</option>
                            </select>
                            <input type="number" name="monto" placeholder="Monto" step="0.01" required class="form-control mb-2">
                            <input type="text" name="descripcion" placeholder="Descripción" required class="form-control mb-2">
                            <input type="date" name="fecha" required class="form-control mb-2">
                            <button type="submit" class="btn btn-success btn-icon">
                                <i class="bi bi-plus"></i> Añadir Reporte
                            </button>
                            <small class="form-text text-muted">¡Este reporte será un éxito financiero! 💵</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para buscar reporte financiero -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Reporte Financiero</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="reportes_financieros.php" method="GET">
                            <input type="text" name="search" placeholder="Buscar..." class="form-control mb-2">
                            <button type="submit" class="btn btn-info btn-icon">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                            <small class="form-text text-muted">¡Vamos a encontrar ese reporte en un abrir y cerrar de ojos! 🔍</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de reportes financieros -->
        <table class="table table-bordered mt-3">
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

        <!-- Modal para editar reporte financiero -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Reporte Financiero</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="reportes_financieros.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <select name="tipo" required class="form-control mb-2">
                                    <option value="ingreso" <?php if ($row['tipo'] == 'ingreso') echo 'selected'; ?>>Ingreso</option>
                                    <option value="gasto" <?php if ($row['tipo'] == 'gasto') echo 'selected'; ?>>Gasto</option>
                                </select>
                                <input type="number" name="monto" value="<?php echo $row['monto']; ?>" step="0.01" required class="form-control mb-2">
                                <input type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>" required class="form-control mb-2">
                                <input type="date" name="fecha" value="<?php echo $row['fecha']; ?>" required class="form-control mb-2">
                                <button type="submit" class="btn btn-warning btn-icon">
                                    <i class="bi bi-pencil"></i> Actualizar Reporte
                                </button>
                                <small class="form-text text-muted">¡Este reporte será aún mejor después de la actualización! 😄</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Modal para eliminar reporte financiero -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Eliminar Reporte Financiero</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que quieres eliminar el reporte financiero de <strong><?php echo $row['descripcion']; ?></strong>? ¡No es una decisión fácil! 😅</p>
                        </div>
                        <div class="modal-footer">
                            <a href="reportes_financieros.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
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
