<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Methods: GET'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos

require_once('./conection.php');

$itemToFind = filter_var($_GET['id'], FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $consult = $conn->prepare('SELECT * FROM vehicles WHERE id = ?');
        $consult->bind_param('i', $itemToFind);
        $consult->execute();
        $resultSearch = $consult->get_result()->fetch_all(MYSQLI_ASSOC);
    
        if ($resultSearch) {
            echo json_encode($resultSearch);
        } else {
            echo json_encode(array("message" => 'Sin resultados'));
        }
    } catch (mysqli_sql_exception $e) {
        echo json_encode(array("error" => "Error: " . $e->getMessage()));
    }



$conn->close();
?>