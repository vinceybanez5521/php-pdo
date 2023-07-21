<?php
session_start();
include_once "../is-authenticated.php";
include_once "../templates/header.php";
require_once "../config/database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "SELECT e.*, p.name AS position FROM employees e INNER JOIN positions p ON e.position_id = p.id WHERE e.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $employee = $stmt->fetch();
        // print_r($employee);

        $hobbies = explode(",", $employee->hobbies);
        $hobbies = array_map(function ($hobby) {
            return ucfirst($hobby);
        }, $hobbies);
        $hobbies = implode(", ", $hobbies);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>

<div class="row">
    <div class="col-12">
        <?php if (isset($_SESSION['success_msg'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success_msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['success_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Employee Information</h1>
                <a href="./" class="btn btn-primary">Employees</a>
            </div>
            <div class="card-body">
                <p>First Name: <strong><?= $employee->first_name ?></strong></p>
                <p>Last Name: <strong><?= $employee->last_name ?></strong></p>
                <p>Gender: <strong><?= ucfirst($employee->gender) ?></strong></p>
                <p>Hobbies: <strong><?= $hobbies ? $hobbies : "No hobbies" ?></strong></p>
                <p>Position: <strong><?= $employee->position ?></strong></p>
                <p>Salary: <strong><?= $employee->salary ?></strong></p>
                <p>Date Added: <strong><?= date_format(date_create($employee->date_added), 'F j, Y h:i:s a') ?></strong></p>
            </div>
        </div>
    </div>
</div>

<?php include_once "../templates/footer.php"; ?>