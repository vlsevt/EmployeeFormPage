<?php
include_once 'PostEmployee.php';
include_once 'employee-functions.php';

try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="main.css">
</head>
<body id="dashboard-page">
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
<div id="table" class="flex-container">
    <div id="employees" class="flex-child-employees">
        <div id="employees-header">
            Employees
        </div>
        <div id="employees-content">
            <?php
            $posts = getAllPosts($db);
            foreach ($posts as $post) {
                $employeeId = $post['id'];
                $firstName = nl2br($post['first_name']);
                $lastName = nl2br($post['last_name']);
                $imagePath = $post['image_path'];
                $position = $post['position'];
                $stmt = $db->prepare('SELECT COUNT(*) as taskCount FROM tasks WHERE employee_id = :employeeId');
                $stmt->bindParam(':employeeId', $employeeId);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $taskCount = $result['taskCount'];

                echo '<div class="employee-item">';
                echo '<img src="' . $imagePath . '" alt="profile image">';
                echo '<span class="name">' . $firstName . " " . $lastName . '</span>';
                echo '<br><span class="position">' . $position . '</span>';
                echo '<br><span id="employee-task-count-' . $employeeId . '">' . $taskCount . '</span>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <div id="tasks" class="flex-child-tasks">
        <div id="tasks-header">
            Tasks
        </div>
        <?php
        $taskData = $db->query('SELECT * FROM tasks')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($taskData as $task) {
            $taskId = $task['id'];
            $description = urldecode($task['description']);
            $employeeId = $task['employee_id'];
            $completed = $task['completed'];

            echo '<div class="task-list-item">';
            echo '<span data-task-id="' . $taskId . '" class="name">' . $description . '</span>';

            if ($completed == 1) {
                echo '<br><span id="task-state-' . $taskId . '" class="status">Closed</span>';
            } elseif ($employeeId == 0) {
                echo '<br><span id="task-state-' . $taskId . '" class="status">Open</span>';
            } else {
                echo '<br><span id="task-state-' . $taskId . '" class="status">Pending</span>';
            }

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
