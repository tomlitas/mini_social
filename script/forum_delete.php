 <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
    }
    require_once '../connection.php';

    if ($_GET) {
        try {
            $userid = $_GET['userid'];
            $sql = "DELETE FROM comments WHERE id='$userid'";
            $query = $conn->prepare($sql);
            $result = $query->execute();
            if ($result) {
                header("Location: ../views/forum.php");
            }
        } catch (PDOException $e) {
            echo "Delete failed: " . $e->getMessage();
        }
    } else {
        header("Location: ../");
    }

    ?> 