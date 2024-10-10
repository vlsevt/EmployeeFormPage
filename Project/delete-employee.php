<?php
require_once 'employee-functions.php';

try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the employee ID from the POST request
    $employeeId = $_POST['employee_id'];

    // Delete the employee with the given ID using a prepared statement
    $stmt = $db->prepare('DELETE FROM employees WHERE id = :employeeId');
    $stmt->bindParam(':employeeId', $employeeId);
    $stmt->execute();

    // Set a success message
    $successMessage = 'Deleted!';

    // Redirect to the employee list page with the success message
    header('Location: employee-list-page.php?success=' . urlencode($successMessage));
    exit;
}
