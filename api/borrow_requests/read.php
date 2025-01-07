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

// Borrow request query
$result = $borrowRequest->read();
$num = $result->rowCount();

// Check if any borrow requests
if ($num > 0) {
    $borrowRequests_arr = array();
    $borrowRequests_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $borrowRequest_item = array(
            'id' => $id,
            'user_id' => $user_id,
            'book_id' => $book_id,
            'request_date' => $request_date,
            'status' => $status,
            'response_date' => $response_date,
            'username' => $username,
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
