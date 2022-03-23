<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
include '../layout/header.php';
require_once("../connection.php");


try {
    $sql = "SELECT * FROM `users` INNER JOIN comments ON comments.users_id = users.id ORDER BY comments.id  DESC";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();
} catch (PDOException $e) {
    echo "Select failed: " . $e->getMessage();
}

$userid = $_SESSION['userid'];

?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    Hello,
                    <?php echo $_SESSION['username']; ?>
                </div>
                <div class="card-body ">
                    <h5 class="card-title text-center"> Forum</h5>
                    <div class="card-footer text-muted">

                        <form action="../script/comments.php" method="POST">
                            <input type='hidden' name='uid' value="<?php echo "$userid" ?>">
                            <textarea name='message' class='list-group-item list-group-item-action'></textarea><br>
                            <button type='submit' name='commentSunmit'>Comment</button>
                        </form>

                    </div>
                    <div>
                        <?php foreach ($result as $comment) { ?>
                            <?php
                            $sql = "SELECT * FROM `likes` WHERE forum_post_id = {$comment['id']}";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $like = $query->fetchAll();

                            ?>
                            <br>
                            <?php echo "<div class='list-group-item list-group-item-action'>" ?>
                            <?php echo $comment['first_name'] . "<br>" . $comment['date'] . "<br>" . $comment['message'] . "<br>" . "<br>" . "<a href='../script/forum_like.php?comment_id=" . $comment['id'] . "'><i class='fa-solid fa-thumbs-up'>" . " " . count($like) . "</i></a>" . " ";
                            if ($_SESSION['userid'] == $comment['users_id']) {
                                echo "<a style='color: red;' href='../script/forum_delete.php?userid=" . $comment['id'] . "'><i class='fas fa-trash-alt'></i></a>" . " " . "<a style='color: #009879;' href='../script/forum_edit.php?userid=" . $comment['id'] . "'><i class='fas fa-edit'></i></a>";
                            } ?>

                    </div>

                <?php } ?>

                </div>

            </div>
        </div>

    </div>

</div>
</div>


<?php
include '../layout/footer.php';
?>