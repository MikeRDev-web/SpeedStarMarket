<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once('./conection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $msg =  $conn->real_escape_string($_POST['msg']);
    $vehicle = $conn->real_escape_string($_POST['vehicleId']);
    $statusContact = false;

    $sql = "INSERT INTO contacts (name, email, msg, vehicle, status)
            VALUES('$name', '$email', '$msg', '$vehicle', '$statusContact')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    $conn->close();
}  else {
    echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos']);
}

?>