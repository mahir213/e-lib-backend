<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
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

// Set borrow request properties
$borrowRequest->user_id = $data->user_id;
$borrowRequest->book_id = $data->book_id;
$borrowRequest->request_date = date('Y-m-d H:i:s');
$borrowRequest->status = 'pending';

// Create borrow request
if ($borrowRequest->create()) {
    echo json_encode(
        array('message' => 'Borrow Request Created')
    );
} else {
    echo json_encode(
        array('message' => 'Borrow Request Not Created')
    );
}
?>
