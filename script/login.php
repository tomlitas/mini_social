<?php 
session_start();
require_once("../connection.php");

if($_POST){
    $email = $_POST['email'];
    $password = $_POST['password'];
}

try {
    $sql ="SELECT * FROM users WHERE email='$email'";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e){
    echo "Select failed: ". $e->getMessage();
}

if ($result){
    $dbPasswordHash = $result['password'];
    if(password_verify($password, $dbPasswordHash)){
        $_SESSION['username'] = $result['first_name'];
        $_SESSION['userlastname'] = $result['last_name'];
        $_SESSION['userid'] = $result['id'];
        // echo "Login successful";
        header("Location: ../views/users.php");
    } else {
        echo "Password is incorrect";
    }
} else {
    echo "Email does not exist";
}
