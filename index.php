<?php
session_start();
include_once "./is-authenticated.php";
include_once "./templates/header.php";
require_once "./config/database.php";
?>

<div class="row">
    <div class="col-12">
        <?php if (isset($_SESSION['login_success'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="d-block">
                    Welcome <strong><?= $_SESSION['name'] ?></strong>!
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['login_success']);
        endif; ?>
        <div class="card">
            <div class="card-header">
                <h1 class="card-title fw-light">Home</h1>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['is_authenticated'])) : ?>
                    <p>You are logged in as <strong><?= $_SESSION['email'] ?></strong></p>
                    <a href="logout.php">Logout</a>
                <?php endif; ?>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                try {
                                    $sql = "SELECT COUNT(id) as total_employees FROM employees";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $data = $stmt->fetch();
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                ?>
                                <p class="card-title fw-light fs-5">Employees</p>
                                <p class="lead fs-2"><?= $data->total_employees ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                try {
                                    $sql = "SELECT COUNT(id) as total_positions FROM positions";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $data = $stmt->fetch();
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                } finally {
                                    $conn = null;
                                }
                                ?>
                                <p class="card-title fw-light fs-5">Positions</p>
                                <p class="lead fs-2"><?= $data->total_positions ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "./templates/footer.php"; ?>