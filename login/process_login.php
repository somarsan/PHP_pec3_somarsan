<?php

/*$username = $_POST['username'];
$password = $_POST['password'];

$hashPassword = password_hash($password, PASSWORD_BCRYPT);

$user = array(
  "Username" => $username,
  "Password" => $hashPassword
);

$usersData = file_get_contents('users.json');
$users = json_decode($usersData, true);

$users[] = $user;

file_put_contents('users.json', json_encode($users));*/

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $usersData = file_get_contents('users.json');
  $users = json_decode($usersData, true);

  $user = null;
  foreach ($users as $userData) {
    if ($userData['Username'] === $username) {
      $user = $userData;
      break;
    }
  }

  if ($user && password_verify($password, $user['Password'])) {
    $_SESSION['username'] = $username;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/~somarsan/pec3/somarsan_pec3/blog.php");
    exit();
  } else {
    echo "Usuario no válido";
  }
}

?>


