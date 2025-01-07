<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

$book->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($book->deleteBook()) {
    echo json_encode(array('message' => 'Book deleted successfully'));
} else {
    echo json_encode(array('message' => 'Book deletion failed'));
}
?>
