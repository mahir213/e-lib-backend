<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$result = $user->getUsers();
$num = $result->rowCount();

if ($num > 0) {
    $users_arr = array();
    $users_arr['records'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'avatar_url' => $avatar_url
        );

        array_push($users_arr['records'], $user_item);
    }

    echo json_encode($users_arr);
} else {
    echo json_encode(array('message' => 'No users found.'));
}
?>
