<?php
class Book {
    // DB stuff
    private $conn;
    private $table = 'books';

    // Book Properties
    public $id;
    public $title;
    public $author;
    public $published_date;
    public $isbn;
    public $description;
    public $cover_image_url;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Single Book
    public function read_single() {
        // Create query
        $query = 'SELECT id, title, author, published_date, isbn, description, cover_image_url FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->title = $row['title'];
        $this->author = $row['author'];
        $this->published_date = $row['published_date'];
        $this->isbn = $row['isbn'];
        $this->description = $row['description'];
        $this->cover_image_url = $row['cover_image_url'];
    }

    // Add Book
    public function addBook() {
        $query = 'INSERT INTO ' . $this->table . ' (title, author, published_date, isbn, description, cover_image_url) VALUES (:title, :author, :published_date, :isbn, :description, :cover_image_url)';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':published_date', $this->published_date);
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':cover_image_url', $this->cover_image_url);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Create book
    public function create() {
        $query = 'INSERT INTO books SET title = :title, author = :author, published_date = :published_date, isbn = :isbn, cover_image_url = :cover_image_url, description = :description';

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->published_date = htmlspecialchars(strip_tags($this->published_date));
        $this->isbn = htmlspecialchars(strip_tags($this->isbn));
        $this->cover_image_url = htmlspecialchars(strip_tags($this->cover_image_url));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':published_date', $this->published_date);
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':cover_image_url', $this->cover_image_url);
        $stmt->bindParam(':description', $this->description);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete Book
    public function deleteBook() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Get Books
    public function getBooks() {
        $query = 'SELECT id, title, author, published_date, isbn, description, cover_image_url FROM ' . $this->table;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
