<?php
session_start();
header('Content-Type: application/json');

$response = [
  'loggedIn' => isset($_SESSION['user_id'])
];

echo json_encode($response);
?>

// logout.php
<?php
session_start();
header('Content-Type: application/json');

session_unset();
session_destroy();

echo json_encode([ 'success' => true ]);
?>