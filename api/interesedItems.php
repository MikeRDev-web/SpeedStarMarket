<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos

require_once('./conection.php');

// Obtener parámetros
$brandItem = $_GET['brand'];
$typeItem = $_GET['type'];

if ($brandItem && $typeItem) {
    // Preparar y ejecutar la consulta usando mysqli
    $sql = 'SELECT * FROM vehicles WHERE brand = ? AND type = ?';
    if ($stmt = $conn->prepare($sql)) {
        // 'ss' significa dos parámetros de tipo cadena
        $stmt->bind_param('ss', $brandItem, $typeItem);
        $stmt->execute();
        $result = $stmt->get_result();
        $resultSearch = $result->fetch_all(MYSQLI_ASSOC);

        if ($resultSearch) {
            echo json_encode($resultSearch);
        } else {
            echo json_encode([]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $conn->error]);
    }
} else {
    echo json_encode(["error" => "Parámetros no válidos"]);
}

$conn->close();
?>