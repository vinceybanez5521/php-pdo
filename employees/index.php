<?php
session_start();
include_once "../is-authenticated.php";
include_once "../templates/header.php";
require_once "../config/database.php";

try {
    $sql = "SELECT e.*, CONCAT(e.first_name, ' ', e.last_name) AS full_name, p.name AS position FROM employees e INNER JOIN positions p ON e.position_id = p.id ORDER BY e.first_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
} finally {
    $conn = null;
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
                <h1 class="card-title fw-light">Employees</h1>
                <a href="create.php" class="btn btn-primary">Add New Employee</a>
            </div>
            <div class="card-body">
                <?php if (!$stmt->rowCount() > 0) : ?>
                    <p class="lead text-center">No employees yet</p>
                <?php endif; ?>

                <?php if ($stmt->rowCount() > 0) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($employee = $stmt->fetch()) : ?>
                                    <tr>
                                        <td>
                                            <?= $employee->full_name ?>
                                        </td>
                                        <td>
                                            <?= ucfirst($employee->gender) ?>
                                        </td>
                                        <td>
                                            <?= $employee->position ?>
                                        </td>
                                        <td>
                                            <span class="peso-sign">&#8369; </span>
                                            <?= number_format($employee->salary, 2) ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="show.php?id=<?= $employee->id ?>">View</a>
                                            <a class="btn btn-success" href="edit.php?id=<?= $employee->id ?>">Edit</a>
                                            <button class="btn btn-danger delete-employee" value="<?= $employee->id ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>


                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once "../templates/footer.php"; ?>