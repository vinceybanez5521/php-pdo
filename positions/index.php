<?php
session_start();
include_once "../is-authenticated.php";
include_once "../templates/header.php";
require_once "../config/database.php";

try {
    $sql = "SELECT * FROM positions ORDER BY name ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $positions = $stmt->fetchAll();
    // print_r($positions);
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
                <h1 class="card-title fw-light">Positions</h1>
                <a href="create.php" class="btn btn-primary">Add New Position</a>
            </div>
            <div class="card-body">
                <?php if (empty($positions)) : ?>
                    <p class="lead text-center">No positions yet</p>
                <?php endif; ?>

                <?php if (!empty($positions)) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($positions as $position) : ?>
                                    <tr>
                                        <td><?= $position->name ?></td>
                                        <td><?= date_format(date_create($position->date_added), 'F j, Y h:i:s a') ?></td>
                                        <td>
                                            <a href="edit.php?id=<?= $position->id ?>" class="btn btn-success">Edit</a>
                                            <button type="button" class="btn btn-danger delete-position" value="<?= $position->id ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once "../templates/footer.php"; ?>