<?php require_once 'database/connection.php'; ?>

<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('location: ./show_students.php');
}

$sql = "SELECT * FROM `students` WHERE `id` = $id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$name = $student['name'];
$reg_no = $student['reg_no'];

$error = $success = '';

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $reg_no = htmlspecialchars($_POST['reg_no']);

    if (empty($name)) {
        $error = "Name please";
    } elseif (empty($reg_no)) {
        $error = "Reg. No. please";
    } else {
        $sql = "SELECT * FROM `students` WHERE `id` != '${id}' AND `reg_no` = '${reg_no}'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $sql = "UPDATE `students` SET `name`='$name',`reg_no`='$reg_no' WHERE `id` = $id";
            if ($conn->query($sql)) {
                $success = 'Updated!';
            } else {
                $error = 'Failed to update!';
            }
        } else {
            $error = 'Registration Number already exists';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once 'includes/head.php'; ?>

<body>
    <div class="wrapper">
        <?php require_once 'includes/sidebar.php'; ?>
        <div class="main">

            <?php require_once 'includes/navbar.php'; ?>
            <main class="content">
                <div class="container-fluid p-0">

                    <div class="row">
                        <div class="col-6">
                            <h1 class="h3 mb-3">Students</h1>
                        </div>
                        <div class="col-6 text-end">
                            <a href="show_students.php" class="btn btn-primary">Students</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-danger"><?php echo $error; ?></div>
                                    <div class="text-success"><?php echo $success; ?></div>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $id; ?>" method="post">
                                        <div class="mb-2">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>" placeholder="Name please">
                                        </div>
                                        <div class="mb-2">
                                            <label for="reg_no">Reg. No.</label>
                                            <input type="text" class="form-control" name="reg_no" id="reg_no" value="<?php echo $reg_no ?>" placeholder="Reg. No. please">
                                        </div>

                                        <div class="mb-2">
                                            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="./assets/js/app.js"></script>

</body>

</html>