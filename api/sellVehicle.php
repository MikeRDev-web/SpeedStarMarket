<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once('./conection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $conn->real_escape_string($_POST['type']);
    $brand = $conn->real_escape_string($_POST['brand']);
    $model = $conn->real_escape_string($_POST['model']);
    $year = $conn->real_escape_string($_POST['year']);
    $color = $conn->real_escape_string($_POST['color']);
    $fuel = $conn->real_escape_string($_POST['fuel']);
    $transmission = $conn->real_escape_string($_POST['transmission']);
    $price = $conn->real_escape_string(number_format($_POST['price'], 2, '.', ','));
    $mileage = $conn->real_escape_string($_POST['mileage']);
    
    $location = $conn->real_escape_string($_POST['location']);
    $description = $conn->real_escape_string($_POST['description']);

    if (isset($_FILES['image'])) {
        $target_dir = "vehiclesImgs/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $conn->real_escape_string($image_name);
        } else {
            $image = '';
        }
    } else {
        $image = '';
    }

    $sql = "INSERT INTO vehicles (type, brand, model, year, color, fuel, transmission, price, mileage, location, description, image)
            VALUES('$type', '$brand', '$model', '$year', '$color', '$fuel', '$transmission', '$price', '$mileage', '$location', '$description', '$image')";

    if ($conn->query($sql) === TRUE) {
        $inserted_id = $conn->insert_id;
        echo json_encode(['status' => 'success', 'message' => 'Vehículo guardado exitosamente', 'id' => $inserted_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar el vehículo: ' . $conn->error]);
    }
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos']);
}
?>