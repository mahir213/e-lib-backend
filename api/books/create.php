<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/Book.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiate book object
$book = new Book($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set book properties
$book->title = $data->title;
$book->author = $data->author;
$book->published_date = $data->publishedDate;
$book->isbn = $data->isbn;
$book->cover_image_url = $data->coverImageUrl;
$book->description = $data->description;

// Create book
if ($book->create()) {
    echo json_encode(
        array('message' => 'Book Created')
    );
} else {
    echo json_encode(
        array('message' => 'Book Not Created')
    );
}
?>
