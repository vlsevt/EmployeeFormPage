<?php

use Project\PostEmployee;

include_once 'PostEmployee.php';
include_once 'employee-functions.php';

try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

$successMessage = '';
$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $position = $_POST['position'];
    $isAvailable = isset($_POST['isAvailable']) ? 1 : 0; // Convert checkbox value to 1 or 0

    if (strlen($firstName) < 1 || strlen($firstName) > 21) {
        $errorMessages[] = "First name must be 1 to 21 characters!";
    }
    if (strlen($lastName) < 2 || strlen($lastName) > 22) {
        $errorMessages[] = "Last name must be 2 to 22 characters!";
    }

    // Handle image upload
    $imagePath = 'img/missing.png';  // Default image

    if ($_FILES['picture']['name'] != "") {
        move_uploaded_file($_FILES['picture']['tmp_name'], 'img/' . basename($_FILES['picture']['name']));
        $imagePath = 'img/' . basename($_FILES['picture']['name']);
    }

    if (empty($errorMessages)) {
        $employee = new PostEmployee(null, $firstName, $lastName, $position, $isAvailable, $imagePath);
        savePost($db, $employee);
        $successMessage = 'Saved!';
        header('Location: employee-list-page.php?success=' . urlencode($successMessage));
        exit;
        } else {
            $errorMessages[] = 'Failed to save employee data.';
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="main.css">
</head>
<body id="employee-form-page">
<div id="links">
    <nav>
        <a href="index.php" id="dashboard-link">Dashboard</a>
        |
        <a href="employee-list-page.php" id="employee-list-link">Employees</a>
        |
        <a href="employee-form-page.php" id="employee-form-link">Add Employee</a>
        |
        <a href="task-list-page.php" id="task-list-link">Tasks</a>
        |
        <a href="task-form-page.php" id="task-form-link">Add task</a>
    </nav>
</div>
<div class="employee-form-table">
    <div class="employee-form-header">
        Add Employee
    </div>

    <?php
    if (!empty($errorMessages)) {
        echo '<div id="error-block">';
        foreach ($errorMessages as $error) {
            echo '<p>' . $error . '</p>';
        }
        echo '</div>';
    }
    ?>
    <form method="post" action="employee-form-page.php" class="employee-form-content" enctype="multipart/form-data">
        <div>
            <label for="fn">First name:</label>
        </div>
        <div>
            <input name="firstName" id="fn" type="text" value="<?php echo $_POST['firstName'] ?? ''; ?>">
        </div>
        <div>
            <label for="ln">Last name:</label>
        </div>
        <div>
            <input name="lastName" id="ln" type="text" value="<?php echo $_POST['lastName'] ?? ''; ?>">
        </div>
        <div>
            <label for="position">Position:</label>
        </div>
        <div>
            <select id="position" name="position">
                <option value=""> </option>
                <option value="Manager">Manager</option>
                <option value="Designer">Designer</option>
                <option value="Developer">Developer</option>
            </select>
        </div>
        <div>
            <label for="available">Available:</label>
        </div>
        <div>
            <input id="available" type="checkbox" name="isAvailable">
        </div>
        <div>
            <label for="pic">Picture:</label>
        </div>
        <div>
            <input id="pic" name="picture" type="file">
        </div>
        <div>
            <br>
            <button type="submit" name="submitButton">Save</button>
        </div>
    </form>
</div>
<div class="navbar">
    <a class="active">ICD0007 Sample Application</a>
</div>
</body>
</html>
