<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

$data = json_decode(file_get_contents("php://input"));

$book->title = $data->title;
$book->author = $data->author;
$book->published_date = $data->publishedDate;
$book->isbn = $data->isbn;
$book->description = $data->description;
$book->cover_image_url = $data->coverImageUrl;

if ($book->addBook()) {
    echo json_encode(array('message' => 'Book added successfully'));
} else {
    echo json_encode(array('message' => 'Book addition failed'));
}
?>
