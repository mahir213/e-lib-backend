<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    echo json_encode(
        array('success' => false, 'message' => 'Database connection failed.')
    );
    exit;
}

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode(
        array('success' => false, 'message' => 'Invalid input data.')
    );
    exit;
}

$user->username = $data->username;
$user->email = $data->email;
$user->password = $data->password;

if ($user->create()) {
    echo json_encode(
        array('success' => true, 'message' => 'User registered successfully.')
    );
} else {
    echo json_encode(
        array('success' => false, 'message' => 'User registration failed.')
    );
}
?>
