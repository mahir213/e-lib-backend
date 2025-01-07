<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/Database.php';
include_once '../../models/Book.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiate book object
$book = new Book($db);

// Get ID from URL
$book->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get book
$book->read_single();

// Create array
$book_arr = array(
    'id' => $book->id,
    'title' => $book->title,
    'author' => $book->author,
    'published_date' => $book->published_date,
    'isbn' => $book->isbn,
    'description' => $book->description,
    'cover_image_url' => $book->cover_image_url
);

// Make JSON
echo json_encode($book_arr);
?>
