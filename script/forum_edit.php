<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
include '../layout/header.php';
require_once("../connection.php");
if ($_GET) {
    try {
        $userid = $_GET['userid'];
        $sql = "SELECT * FROM comments WHERE id='$userid'";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetch();
    } catch (PDOException $e) {
        echo "Selelct failed: " . $e->getMessage();
    }
}
if ($_POST) {
    $message = $_POST['message'];
    try {
        $sql = "UPDATE comments SET message = '$message' WHERE id='$userid'";
        $query = $conn->prepare($sql);
        $result = $query->execute();
        if ($result) {
            header("Location: ../views/forum.php");
        }
    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
    }
}

?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    Hello,
                    <?php echo $_SESSION['username']; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Update</h5>
                    <form action="" method="POST">
                        <input type='hidden' name='uid' value="<?php echo "$userid" ?>">
                        <textarea name='message' class='list-group-item list-group-item-action'><?php echo $result['message'] ?></textarea><br>
                        <button type='submit' name='commentSunmit'>Update</button>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <h5 class="card-title">You want Update</h5>
                </div>
            </div>
        </div>

    </div>

</div>
</div>