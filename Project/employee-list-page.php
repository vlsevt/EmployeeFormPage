<?php
require_once 'employee-functions.php';
require_once 'PostEmployee.php';
try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}
$successMessage = isset($_GET['success']) ? urldecode($_GET['success']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="main.css">
</head>
<body id="employee-list-page">
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
<?php
if (!empty($successMessage)) {
    echo '<div id="message-block">' . $successMessage . '</div>';
}
?>
<div id="employee-list" class="flex-child-employees">
    <div id="employee-list-header">
        Employees
    </div>
    <div id="employee-list-content">
        <?php
        $posts = getAllPosts($db);
        foreach ($posts as $post) {
            $employeeId = $post['id'];
            $firstName = nl2br($post['first_name']);
            $lastName = nl2br($post['last_name']);
            $position = $post['position'];
            $imagePath = rtrim($post['image_path'], "\n\r");

            echo '<div class="employee-item">';
            echo '<img src="' . $imagePath . '" alt="profile picture" data-employee-id="' . $employeeId . '">';
            echo '<span data-employee-id="' . $employeeId . '" class="name">' . $firstName . ' ' . $lastName . '</span>';
            echo '<a class="edit-link" href="edit-employee-form.php?employee_id=' . urlencode($employeeId) . '" id="employee-edit-link-' . $employeeId . '">Edit</a>';
            echo '<br><span class="position">' . $position . '</span>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="navbar">
        <a class="active">ICD0007 Sample Application</a>
    </div>
</div>
</body>
</html>
