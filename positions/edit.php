<?php
session_start();
include_once "../is-authenticated.php";
include_once "../templates/header.php";
require_once "../config/database.php";

$name = "";
$name_err = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "SELECT * FROM positions WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $position = $stmt->fetch();
        // print_r($position);

        $name = $position->name;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['submit'])) {
    // Validate name
    if (empty($_POST['name'])) {
        $name_err = "Please enter name";
    } else {
        $name = $_POST['name'];
    }

    if (empty($name_err)) {
        $id = $_POST['id'];

        try {
            $sql = "UPDATE positions SET name = :a WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":a", $name);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $_SESSION['success_msg'] = "Position Updated!";
            header('Location: ./');
        } catch (PDOException $e) {
            // echo $e->getMessage();
            $_SESSION['error_msg'] = "Position Not Updated!";
        } finally {
            $conn = null;
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <?php if (isset($_SESSION['error_msg'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['error_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Edit Position</h1>
                <a href="./" class="btn btn-primary">Positions</a>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control <?= $name_err ? 'is-invalid' : null ?>" id="name" name="name" value="<?= $name ?>">
                        <span class="invalid-feedback">
                            <?= $name_err ?>
                        </span>
                    </div>
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?? -1 ?>">
                    <button type="submit" name="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "../templates/footer.php"; ?>