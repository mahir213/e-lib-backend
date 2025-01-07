<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/BorrowRequest.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiate borrow request object
$borrowRequest = new BorrowRequest($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$borrowRequest->id = $data->id;
$borrowRequest->status = $data->status;
$borrowRequest->response_date = date('Y-m-d H:i:s');

// Update borrow request
if ($borrowRequest->update()) {
    echo json_encode(
        array('message' => 'Borrow Request Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Borrow Request Not Updated')
    );
}
?>
