<!-- <pre> -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
require_once("../connection.php");
if (isset($_GET['comment_id'])) {
    $forum_post_id = $_GET['comment_id'];
    $forum_user_id = $_SESSION['userid'];
    $sql = "SELECT * FROM likes WHERE forum_user_id = '$forum_user_id' AND forum_post_id = $forum_post_id";
    $query = $conn->prepare($sql);
    $query->execute();
    $like = $query->fetch();

    if (empty($like)) {
        try {
            $sql = "INSERT INTO likes ( forum_post_id, forum_user_id ) VALUES ('$forum_post_id','$forum_user_id')";
            $query = $conn->prepare($sql);
            $result = $query->execute();
            if ($result) {
                header("Location: ../views/forum.php");
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } else {
        $like_id = $like['id'];
        $sql = "DELETE FROM likes WHERE id = '$like_id'";
        $query = $conn->prepare($sql);
        $query->execute();

        header("Location: ../views/forum.php");
    }
}
