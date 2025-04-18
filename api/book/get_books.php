<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->getConnection();

$book = new Book($db);

$stmt = $book->getBooks();
$num = $stmt->rowCount();

if ($num > 0) {
    $books_arr = array();
    $books_arr["data"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $book_item = array(
            "id" => $id,
            "title" => $title,
            "author" => $author,
            "published_date" => $published_date,
            "isbn" => $isbn,
            "cover_image_url" => $cover_image_url,
            "description" => $description
        );
        array_push($books_arr["data"], $book_item);
    }

    echo json_encode($books_arr);
} else {
    echo json_encode(
        array("message" => "No books found.")
    );
}
?>
