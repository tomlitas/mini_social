<?php

require_once("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nice = $_POST['nice'];
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
} else {
    header("Location: ../views/login.php");
    die;
}

if ($password == $confirmPassword) {
    $password = password_hash($password, PASSWORD_BCRYPT);
} else {
    // header("Location: ../");
    die;
}

try {
    $sql = "INSERT INTO users (name, first_name, last_name, email, password) VALUES ('$nice', '$firstName', '$lastName', '$email', '$password')";
    $query = $conn->prepare($sql);
    $query->execute();
    header("Location: ../views/login.php");
} catch (PDOException $e) {
    echo "Insert failed: " . $e->getMessage();
}
