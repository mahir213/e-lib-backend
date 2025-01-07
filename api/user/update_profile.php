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

if (!isset($data->id, $data->username, $data->full_name, $data->email, $data->avatar_url)) {
    echo json_encode(array('message' => 'Incomplete data'));
    exit;
}

$user->id = $data->id;
$user->username = $data->username;
$user->full_name = $data->full_name;
$user->email = $data->email;
$user->avatar_url = $data->avatar_url;

if ($user->updateProfile()) {
    echo json_encode(array('message' => 'Profile updated successfully'));
} else {
    echo json_encode(array('message' => 'Profile update failed'));
}
?>
