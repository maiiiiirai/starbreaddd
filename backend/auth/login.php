<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once('../utils/db_connection.php');

session_start();

function login($pdo): array{
  $username= trim($_POST['username'] ?? '');
  $password= trim($_POST['password'] ?? '');

  if (empty($username) || empty($password)) {
      return ['success' => false, 'message' => 'Username and password are required.'];
  }

  try  {
    $query=$pdo->prepare("SELECT id, username, password FROM tbl_users WHERE username = ?");
    $query->execute([$username]);
    $user=$query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      error_log("Login failed: User not found for username '$username'");
      return ['success' => false, 'message' => 'Invalid username or password.'];
    }

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id']=$user['id'];
      $_SESSION['username']=$user['username'];

      return ['success' => true, 'message' => 'Login successful.'];
    } else {
      error_log("Login failed: Incorrect password for username '$username'");
      return ['success' => false, 'message' => 'Invalid username or password.'];
    }

  } catch (PDOException $e) {
    error_log("Database error during login for username '$username': " . $e->getMessage());
    return ['success' => false, 'message' => 'An error occurred. Please try again later.'];
  }
}

$response = login($pdo);
echo json_encode($response);