<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Methods: GET'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos

require_once('./conection.php'); // Asegúrate de que este archivo configure la conexión PDO correctamente

$searchTerm = filter_var($_GET['search'], FILTER_SANITIZE_SPECIAL_CHARS);

try {
    // Asegurarse de que la conexión PDO esté configurada en 'conection.php'
    $searchPartial = "%{$searchTerm}%";
    $consult = $conn->prepare('SELECT * FROM vehicles WHERE brand LIKE ? OR model LIKE ? OR year = ?');
    $consult->execute([$searchPartial, $searchPartial, $searchTerm]);
    $resultSearch = $consult->get_result()->fetch_all(MYSQLI_ASSOC); // Usando PDO para obtener resultados como un array asociativo

    if ($resultSearch) {
        echo json_encode($resultSearch);
    } else {
        die;
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
?>