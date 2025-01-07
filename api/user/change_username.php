<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->id = $data->id;
$newUsername = $data->newUsername;

if ($user->changeUsername($newUsername)) {
    error_log("Username changed successfully for user ID: " . $user->id);
    echo json_encode(array('message' => 'Username changed successfully'));
} else {
    error_log("Username change failed for user ID: " . $user->id);
    echo json_encode(array('message' => 'Username change failed'));
}
?>
