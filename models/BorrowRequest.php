<?php
class BorrowRequest {
    private $conn;
    private $table = 'borrow_requests';

    public $id;
    public $user_id;
    public $book_id;
    public $request_date;
    public $status;
    public $response_date;
    public $username;
    public $book_title;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT br.id, br.user_id, br.book_id, br.request_date, br.status, br.response_date, u.username, b.title as book_title
                  FROM ' . $this->table . ' br
                  LEFT JOIN users u ON br.user_id = u.id
                  LEFT JOIN books b ON br.book_id = b.id
                  ORDER BY br.request_date DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . '
                  SET status = :status, response_date = :response_date
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':response_date', $this->response_date);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET user_id = :user_id, book_id = :book_id, request_date = :request_date, status = :status';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':request_date', $this->request_date);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readUserRequests() {
        $query = 'SELECT br.id, br.book_id, br.request_date, br.status, br.response_date, b.title as book_title
                  FROM ' . $this->table . ' br
                  LEFT JOIN books b ON br.book_id = b.id
                  WHERE br.user_id = :user_id
                  ORDER BY br.request_date DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();

        return $stmt;
    }
}
?>
