<?php require_once 'database/connection.php'; ?>

<?php

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('location: ./show_registrations.php');
}

$sql = "SELECT * FROM `registration` WHERE `id` = $id";
$result = $conn->query($sql);
$registration = $result->fetch_assoc();

$student_id = $registration['student_id'];
$course_id = $registration['course_id'];

$error = $success = "";

$sql = "SELECT * FROM `students`";
$result = $conn->query($sql);
$students = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM `courses`";
$result = $conn->query($sql);
$courses = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $student_id = htmlspecialchars($_POST['student']);
    $course_id = htmlspecialchars($_POST['course']);

    if (empty($student_id)) {
        $error = "Please select the student!";
    } elseif (empty($course_id)) {
        $error = "Please select the course!";
    } else {
        $sql = "UPDATE `registration` SET `student_id` = '${student_id}', `course_id` = '${course_id}' WHERE `id` = ${id}";
        if($conn->query($sql)){
            $success = "Registration has been succesfully updated!";
        } else {
            $error = "Registration has failed update!";
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
                            <h1 class="h3 mb-3">Edit Registration</h1>
                        </div>
                        <div class="col-6 text-end">
                            <a href="./show_registrations.php" class="btn btn-primary">Registrations</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $id; ?>" method="POST">
                                        <div class="text-danger"><?php echo $error; ?></div>
                                        <div class="text-success"><?php echo $success; ?></div>

                                        <div class="mb-3">
                                            <label for="student">Students</label>
                                            <select name="student" id="student" class="form-select">
                                                <option value="">Please select the student</option>
                                                <?php
                                                foreach ($students as $student) :
                                                    if ($student['id'] == $student_id) {
                                                        $selected = "selected";
                                                    } else { 
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $student['id']; ?>" <?php echo $selected; ?>><?php echo $student['name']; ?></option>

                                                <?php
                                                endforeach
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="course">Courses</label>
                                            <select name="course" id="course" class="form-select">
                                                <option value="">Please select the course</option>
                                                <?php
                                                foreach ($courses as $course) :
                                                    if ($course['id'] == $course_id) {
                                                        $selected = "selected";
                                                    } else { 
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $course['id']; ?>" <?php echo $selected; ?>><?php echo $course['name']; ?></option>
                                                <?php
                                                endforeach
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <input type="submit" value="Submit" class="btn btn-primary" name="submit">
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