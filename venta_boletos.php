<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Inicializa variables de alerta
$alertMessage = '';
$alertClass = '';

// Procesar formularios y operaciones con la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        // Editar boleto
        $id = intval($_POST['id']);
        $produccion_id = intval($_POST['produccion_id']);
        $patrono_id = intval($_POST['patrono_id']);
        $fila = $conn->real_escape_string($_POST['fila']);
        $asiento = intval($_POST['asiento']);
        $precio = floatval($_POST['precio']);

        $sql = "UPDATE VentaBoletos SET produccion_id=$produccion_id, patrono_id=$patrono_id, fila='$fila', asiento=$asiento, precio=$precio WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Boleto editado exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    } else {
        // Añadir boleto
        $produccion_id = intval($_POST['produccion_id']);
        $patrono_id = intval($_POST['patrono_id']);
        $fila = $conn->real_escape_string($_POST['fila']);
        $asiento = intval($_POST['asiento']);
        $precio = floatval($_POST['precio']);

        $sql = "INSERT INTO VentaBoletos (produccion_id, patrono_id, fila, asiento, precio) VALUES ($produccion_id, $patrono_id, '$fila', $asiento, $precio)";
        if ($conn->query($sql) === TRUE) {
            $alertMessage = 'Boleto añadido exitosamente.';
            $alertClass = 'alert-success';
        } else {
            $alertMessage = 'Error: ' . $conn->error;
            $alertClass = 'alert-danger';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Eliminar el boleto
    $sql = "DELETE FROM VentaBoletos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $alertMessage = 'Boleto eliminado exitosamente.';
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
    <title>Gestionar Venta de Boletos</title>
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
        <h1>☆꧁░▒▓█ VENTA DE BOLETOS █▓▒░꧂☆</h1>
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
                <!-- Botón para añadir boleto -->
                <button type="button" class="btn btn-success btn-icon" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Añadir Boleto
                </button>
            </div>
            <div class="col text-right">
                <!-- Botón para buscar boleto -->
                <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#searchModal">
                    <i class="bi bi-search"></i> Buscar Boleto
                </button>
            </div>
        </div>

        <!-- Modal para añadir boleto -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Añadir Boleto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="venta_boletos.php" method="POST">
                            <select name="produccion_id" required class="form-control mb-2">
                                <option value="" disabled selected>Seleccionar Producción</option>
                                <?php
                                // Obtener producciones
                                $sql = "SELECT id, titulo FROM Producción";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['titulo']}</option>";
                                }
                                ?>
                            </select>
                            <select name="patrono_id" required class="form-control mb-2">
                                <option value="" disabled selected>Seleccionar Patrocinador</option>
                                <?php
                                // Obtener patrocinadores
                                $sql = "SELECT id, nombre FROM Patrono";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                                }
                                ?>
                            </select>
                            <input type="text" name="fila" placeholder="Fila" required class="form-control mb-2">
                            <input type="number" name="asiento" placeholder="Asiento" required class="form-control mb-2">
                            <input type="number" name="precio" placeholder="Precio" step="0.01" required class="form-control mb-2">
                            <button type="submit" class="btn btn-success btn-icon">
                                <i class="bi bi-plus"></i> Añadir Boleto
                            </button>
                            <small class="form-text text-muted">¡Tu nuevo boleto está listo para la función! 🎟️</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para buscar boleto -->
        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Buscar Boleto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="venta_boletos.php" method="GET">
                            <input type="text" name="search" placeholder="Buscar..." class="form-control mb-2">
                            <button type="submit" class="btn btn-info btn-icon">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                            <small class="form-text text-muted">¡Encuentra los boletos que buscas rápidamente! 🔍</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de boletos -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producción</th>
                    <th>Patrocinador</th>
                    <th>Fila</th>
                    <th>Asiento</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar boletos
                $sql = "SELECT V.id, P.titulo AS produccion, PA.nombre AS patrocinador, V.fila, V.asiento, V.precio
                        FROM VentaBoletos V
                        JOIN Producción P ON V.produccion_id = P.id
                        JOIN Patrono PA ON V.patrono_id = PA.id";
                if (isset($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE P.titulo LIKE '%$search%' OR PA.nombre LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['produccion']}</td>";
                    echo "<td>{$row['patrocinador']}</td>";
                    echo "<td>{$row['fila']}</td>";
                    echo "<td>{$row['asiento']}</td>";
                    echo "<td>{$row['precio']}</td>";
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

        <!-- Modal para editar boleto -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Boleto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="venta_boletos.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <select name="produccion_id" required class="form-control mb-2">
                                    <?php
                                    // Obtener producciones
                                    $sql = "SELECT id, titulo FROM Producción";
                                    $productions = $conn->query($sql);
                                    while ($prod = $productions->fetch_assoc()) {
                                        $selected = ($prod['id'] == $row['produccion_id']) ? 'selected' : '';
                                        echo "<option value='{$prod['id']}' $selected>{$prod['titulo']}</option>";
                                    }
                                    ?>
                                </select>
                                <select name="patrono_id" required class="form-control mb-2">
                                    <?php
                                    // Obtener patrocinadores
                                    $sql = "SELECT id, nombre FROM Patrono";
                                    $sponsors = $conn->query($sql);
                                    while ($spon = $sponsors->fetch_assoc()) {
                                        $selected = ($spon['id'] == $row['patrono_id']) ? 'selected' : '';
                                        echo "<option value='{$spon['id']}' $selected>{$spon['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                                <input type="text" name="fila" value="<?php echo $row['fila']; ?>" required class="form-control mb-2">
                                <input type="number" name="asiento" value="<?php echo $row['asiento']; ?>" required class="form-control mb-2">
                                <input type="number" name="precio" value="<?php echo $row['precio']; ?>" step="0.01" required class="form-control mb-2">
                                <button type="submit" class="btn btn-warning btn-icon">
                                    <i class="bi bi-pencil"></i> Actualizar Boleto
                                </button>
                                <small class="form-text text-muted">¡No te preocupes, no haremos que el boleto sea más caro! 😄</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Modal para eliminar boleto -->
        <?php
        $result->data_seek(0); // Resetear el puntero del resultado
        while ($row = $result->fetch_assoc()) { ?>
            <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Eliminar Boleto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que quieres eliminar el boleto para <strong><?php echo $row['produccion']; ?></strong>? ¡Prometemos no hacer un drama! 😢</p>
                        </div>
                        <div class="modal-footer">
                            <a href="venta_boletos.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
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
