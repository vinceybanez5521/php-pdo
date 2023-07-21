<?php
session_start();
include_once "./templates/header.php";
require_once "./config/database.php";

if(isset($_SESSION['is_authenticated'])) {
    header('Location: ./');
}

$name = $email = $password = "";
$name_err = $email_err = $password_err = "";

if (isset($_POST['submit'])) {
    // Validate name
    if (empty($_POST['name'])) {
        $name_err = "Please enter name";
    } else {
        $name = $_POST['name'];
    }

    // Validate email
    if (empty($_POST['email'])) {
        $email_err = "Please enter email";
    } else {
        $email = $_POST['email'];
    }

    // Validate password
    if (empty($_POST['password'])) {
        $password_err = "Please enter password";
    } else {
        $password = $_POST['password'];
    }

    if (empty($name_err) && empty($email_err) && empty($password_err)) {
        try {
            // Check if email already exists
            $sql = "SELECT id FROM users WHERE email = :a";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":a", $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $email_err = "Email already exists";
            } else {
                $sql = "INSERT INTO users(name, email, password) VALUES(:a, :b, :c)";

                $hashed_password = md5($password);
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":a", $name);
                $stmt->bindParam(":b", $email);
                $stmt->bindParam(":c", $hashed_password);
                $stmt->execute();
                $_SESSION['success_msg'] = "Registration Successful!";
                header('Location: login.php');
            }
        } catch (PDOException $e) {
            // echo $e->getMessage();
            $_SESSION['error_msg'] = "Registration Failed!";
        } finally {
            $conn = null;
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <?php if (isset($_SESSION['error_msg'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['error_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header">
                <h1 class="card-title fw-light">Register</h1>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="name" class="form-control <?= $name_err ? 'is-invalid' : null ?>" id="name" name="name" value="<?= $name ?>">
                        <span class="invalid-feedback">
                            <?= $name_err  ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= $email_err ? 'is-invalid' : null ?>" id="email" name="email" value="<?= $email ?>">
                        <span class="invalid-feedback">
                            <?= $email_err  ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= $password_err ? 'is-invalid' : null ?>" id="password" name="password" value="<?= $password ?>">
                        <span class="invalid-feedback">
                            <?= $password_err  ?>
                        </span>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Register</button>
                    <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "./templates/footer.php"; ?>