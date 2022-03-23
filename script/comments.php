<?php

require_once("../connection.php");

if ($_POST) {
  $uid = $_POST['uid'];
  $message = $_POST['message'];

  try {
    $sql = "INSERT INTO comments (users_id, message) VALUES ('$uid', '$message')";
    $query = $conn->prepare($sql);
    $query->execute();
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}
header("Location: http://localhost/mini_social/views/forum.php");
