<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/Database.php';
include_once '../../models/BorrowRequest.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiate borrow request object
$borrowRequest = new BorrowRequest($db);

// Get user ID from URL
$borrowRequest->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

// Borrow request query
$result = $borrowRequest->readUserRequests();
$num = $result->rowCount();

// Check if any borrow requests
if ($num > 0) {
    $borrowRequests_arr = array();
    $borrowRequests_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $borrowRequest_item = array(
            'id' => $id,
            'book_id' => $book_id,
            'request_date' => $request_date,
            'status' => $status,
            'response_date' => $response_date,
            'book_title' => $book_title
        );

        array_push($borrowRequests_arr['data'], $borrowRequest_item);
    }

    echo json_encode($borrowRequests_arr);
} else {
    echo json_encode(
        array('message' => 'No Borrow Requests Found')
    );
}
?>
