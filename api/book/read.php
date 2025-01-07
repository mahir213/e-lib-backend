<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

$result = $book->getBooks();
$num = $result->rowCount();

if ($num > 0) {
    $books_arr = array();
    $books_arr['records'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $book_item = array(
            'id' => $id,
            'title' => $title,
            'author' => $author,
            'published_date' => $published_date,
            'isbn' => $isbn,
            'description' => $description,
            'cover_image_url' => $cover_image_url
        );

        array_push($books_arr['records'], $book_item);
    }

    echo json_encode($books_arr);
} else {
    echo json_encode(array('message' => 'No books found.'));
}
?>
