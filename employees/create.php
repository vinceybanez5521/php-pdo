<?php
session_start();
include_once "../is-authenticated.php";
include_once "../templates/header.php";
require_once "../config/database.php";

$first_name = $last_name = $gender = $position = $salary = "";
$first_name_err = $last_name_err = $position_err = $salary_err = "";
$hobbies = [];

if (isset($_POST['submit'])) {
    // Validate first name
    if (empty($_POST['first_name'])) {
        $first_name_err = "Please enter first name";
    } else {
        $first_name = $_POST['first_name'];
    }

    // Validate last name
    if (empty($_POST['last_name'])) {
        $last_name_err = "Please enter last name";
    } else {
        $last_name = $_POST['last_name'];
    }

    // Validate position
    if (empty($_POST['position'])) {
        $position_err = "Please select position";
    } else {
        $position = $_POST['position'];
    }

    // Validate salary
    if (empty($_POST['salary'])) {
        $salary_err = "Please enter salary";
    } else {
        $salary = $_POST['salary'];
    }

    if (empty($first_name_err) && empty($last_name_err) && empty($position_err) && empty($salary_err)) {
        $gender = $_POST['gender'];

        if (!empty($_POST['hobbies'])) {
            $hobbies = implode(',', $_POST['hobbies']);
        } else {
            $hobbies = "";
        }

        try {
            $sql = "INSERT INTO employees(first_name, last_name, gender, hobbies, position_id, salary) VALUES(:a, :b, :c, :d, :e, :f)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":a", $first_name);
            $stmt->bindParam(":b", $last_name);
            $stmt->bindParam(":c", $gender);
            $stmt->bindParam(":d", $hobbies);
            $stmt->bindParam(":e", $position);
            $stmt->bindParam(":f", $salary);
            $stmt->execute();
            $_SESSION['success_msg'] = "Employee Added!";
            header('Location: ./');
        } catch (PDOException $e) {
            // echo $e->getMessage();
            $_SESSION['error_msg'] = "Employee Not Added!";
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
                <h1 class="card-title fw-light">Add New Employee</h1>
                <a href="./" class="btn btn-primary">Employees</a>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control <?= $first_name_err ? 'is-invalid' : null ?>" id="first-name" name="first_name" value="<?= $first_name ?>">
                        <span class="invalid-feedback">
                            <?= $first_name_err  ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control <?= $last_name_err ? 'is-invalid' : null ?>" id="last-name" name="last_name" value="<?= $last_name ?>">
                        <span class="invalid-feedback">
                            <?= $last_name_err  ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= $gender == '' || isset($_POST['gender']) && $_POST['gender'] == 'male' ? 'checked' : null ?>>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= isset($_POST['gender']) && $_POST['gender'] == 'female' ? 'checked' : null ?>>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hobbies</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="sports" value="sports" <?= in_array('sports', $hobbies) || isset($_POST['hobbies']) && in_array('sports', $_POST['hobbies']) ? 'checked' : null ?>>
                            <label class="form-check-label" for="sports">Sports</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="games" value="games" <?= in_array('games', $hobbies) || isset($_POST['hobbies']) && in_array('games', $_POST['hobbies']) ? 'checked' : null ?>>
                            <label class="form-check-label" for="games">Video Games</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="arts" value="arts" <?= in_array('arts', $hobbies) || isset($_POST['hobbies']) && in_array('arts', $_POST['hobbies']) ? 'checked' : null ?>>
                            <label class="form-check-label" for="arts">Arts</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="movies" value="movies" <?= in_array('movies', $hobbies) || isset($_POST['hobbies']) && in_array('movies', $_POST['hobbies']) ? 'checked' : null ?>>
                            <label class="form-check-label" for="movies">Movies</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="cooking" value="cooking" <?= in_array('cooking', $hobbies) || isset($_POST['hobbies']) && in_array('cooking', $_POST['hobbies']) ? 'checked' : null ?>>
                            <label class="form-check-label" for="cooking">Cooking</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="others" value="others" <?= in_array('others', $hobbies) || isset($_POST['hobbies']) && in_array('others', $_POST['hobbies']) ? 'checked' : null ?>>
                            <label class="form-check-label" for="others">Others</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <?php
                        // Load positions
                        try {
                            $sql = "SELECT * FROM positions ORDER BY name ASC";

                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $positions = $stmt->fetchAll();
                            // print_r($positions);
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                        <label for="position" class="form-label">Position</label>
                        <select class="form-select <?= $position_err ? 'is-invalid' : null ?>" name="position" id="position">
                            <option value="" disabled selected>Select Position</option>
                            <?php foreach ($positions as $pos) : ?>
                                <option value="<?= $pos->id ?>" <?= $position == $pos->id ? 'selected' : null ?>><?= $pos->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback">
                            <?= $position_err  ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" class="form-control <?= $salary_err ? 'is-invalid' : null ?>" id="salary" name="salary" value="<?= $salary ?>">
                        <span class="invalid-feedback">
                            <?= $salary_err  ?>
                        </span>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "../templates/footer.php"; ?>