<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Methods: GET'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos

require_once('./conection.php');

try {
    $consult = $conn->prepare('SELECT * FROM vehicles');
    $consult->execute();
    $result = $consult->get_result()->fetch_all(MYSQLI_ASSOC);

    if($result) {
        echo json_encode($result);
    } else {
        die;
    }
} catch (mysqli_sql_exception $e) {
    die;
}

?>