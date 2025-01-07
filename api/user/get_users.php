<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

try {
    $stmt = $user->getUsers();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $users_arr = array();
        $users_arr["data"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
                "id" => $id,
                "username" => $username,
                "email" => $email,
                "avatar_url" => $avatar_url,
                "full_name" => $full_name,
                "created_at" => $created_at,
                "is_admin" => $is_admin
            );
            array_push($users_arr["data"], $user_item);
        }

        echo json_encode($users_arr);
    } else {
        echo json_encode(
            array("message" => "No users found.")
        );
    }
} catch (PDOException $e) {
    echo json_encode(
        array("message" => "Error: " . $e->getMessage())
    );
}
?>
