<?php
session_start();
include_once "../is-authenticated.php";
require_once "../config/database.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM employees WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $_SESSION['success_msg'] = "Employee Deleted!";
    } catch (PDOException $e) {
        // echo $e->getMessage();
        $_SESSION['error_msg'] = "Employee Not Deleted!";
    } finally {
        $conn = null;
    }
}
