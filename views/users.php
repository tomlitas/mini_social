<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
include '../layout/header.php';
require_once '../connection.php';

try {
    $sql = "SELECT * FROM users";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();
} catch (PDOException $e) {
    echo "Select failed: " . $e->getMessage();
}


?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    Hello,
                    <?php echo $_SESSION['username']; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Users list</h5>
                    <table class="table table-striped">
                        <tr>
                            <th>Nice</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        foreach ($result as $user) {
                            echo "<tr><td>" . $user['name'] . "</td><td>" . $user['first_name'] . "</td><td>" . $user['last_name'] . "</td><td>" . $user['email'] . "</td><td>" . $user['created'] . "</td><td>" . $user['update'] . "</td><td>";
                            if ($_SESSION['userid'] == $user['id']) {
                                echo "<a class='btn btn-warning m-1' href='user_edit.php?userid=" . $user['id'] . "'>Edit</a>" . "<a class='btn btn-danger' href='../script/user_delete.php?userid=" . $user['id'] . "'>Delete</a>" . "</td></tr>";
                            }
                        }

                        ?>
                    </table>
                </div>
                <div class="card-footer text-muted">

                </div>
            </div>
        </div>


    </div>
</div>

<?php include '../layout/footer.php' ?>