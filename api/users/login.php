<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents("php://input"));
    $email = $input->email;
    $password = $input->password;

    $query = $db->prepare("SELECT * FROM users WHERE email = :email");
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $role = $user['is_admin'] == 1 ? 'admin' : 'user';

        $response = [
            'status' => 'success',
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'role' => $role,
            ]
        ];

        echo json_encode($response);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid email or password.'
        ];

        echo json_encode($response);
    }
}
?>
