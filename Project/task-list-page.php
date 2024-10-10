<?php
$successMessage = isset($_GET['success']) ? urldecode($_GET['success']) : '';

try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

$taskData = $db->query('SELECT tasks.*, employees.first_name, employees.last_name 
                       FROM tasks 
                       LEFT JOIN employees ON tasks.employee_id = employees.id')
    ->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
    <link rel="stylesheet" href="main.css">
</head>
<body id="task-list-page">
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
<div id="task-list" class="flex-child-tasks">
    <div id="task-list-header">
        Tasks
    </div>
    <div id="task-list-content">
        <?php
        foreach ($taskData as $task) {
            $taskId = $task['id'];
            $description = urldecode($task['description']);
            $estimate = $task['estimate'];
            $assignedEmployee = $task['first_name'] . ' ' . $task['last_name'];
            $completed = $task['completed'];

            echo '<div class="task-list-item">';
            echo '<span data-task-id="' . $taskId . '" class="name">' . $description . '</span>';
            echo '<br><span class="assigned-to"> Assigned to: ' . $assignedEmployee . '</span>';
            echo '<a class="edit-link" href="edit-task-form.php?task_id=' . $taskId . '&description=' . urlencode($description) . '&estimate=' . $estimate . '" id="task-edit-link-' . $taskId . '">Edit</a>';
            echo '<br><span class="estimate"> Estimate: ' . $estimate . '</span>';

            // Display task states
            echo '<br><span id="task-state-' . $taskId . '" class="status">';


            if ($completed)
            {
                echo 'Closed';
            } else if ($assignedEmployee == ' ')
            {
                echo 'Open';
            } else
            {
                echo 'Pending';
            }
            echo '</span>';

            echo '</div>';
        }
        ?>
    </div>
</div>
<div class="navbar">
    <a class="active">ICD0007 Sample Application</a>
</div>
</body>
</html>
