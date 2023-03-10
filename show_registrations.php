<?php require_once 'database/connection.php'; ?>

<?php

// $sql = "SELECT students.name AS student_name, students.reg_no AS reg_no, courses.name AS course_name FROM `students` 
// INNER JOIN `registration` ON students.id = registration.student_id
// INNER JOIN `courses` ON registration.course_id = courses.id";

$sql = "SELECT s.name AS `student_name`, s.reg_no AS `reg_no`, c.name AS `course_name`, r.id AS `reg_id` 
FROM `students` s 
INNER JOIN `registration` r ON s.id = r.student_id
INNER JOIN `courses` c ON r.course_id = c.id";
$result = $conn->query($sql);

$students = $result->fetch_all(MYSQLI_ASSOC);
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
                            <h1 class="h3 mb-3">Registered Students</h1>
                        </div>
                        <div class="col-6 text-end">
                            <a href="add_registration.php" class="btn btn-primary">Register Student</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    if (count($students) > 0) { ?>

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Reg. No.</th>
                                                    <th>Course</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($students as $student) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $student['student_name']; ?></td>
                                                        <td>aci-<?php echo $student['reg_no']; ?></td>
                                                        <td><?php echo $student['course_name']; ?></td>
                                                        <td>
                                                            <a href="./edit_registration.php?id=<?php echo $student['reg_id']; ?>" class="btn btn-primary">Edit</a>
                                                            
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteRegistration(<?php echo $student['reg_id']; ?>)">
                                                                Delete
                                                            </button>

                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>

                                    <?php
                                    } else {
                                        echo "No Registered students Found!";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5 text-white" id="deleteModalLabel">Delete User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn btn-danger" id="btn-delete">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/app.js"></script>

    <script>
        function deleteRegistration (id) {
            btnDelete = document.getElementById('btn-delete');
            btnDelete.setAttribute('href', 'delete_registration.php?id=' + id);
        }
    </script>

</body>

</html>