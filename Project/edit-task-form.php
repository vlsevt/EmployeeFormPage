<?php
require_once 'employee-functions.php';

$successMessage = ''; // Initialize the success message
$errorMessages = [];
try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the task ID, updated values, and assigned employee from the POST request
    $taskId = $_POST['id'];
    $description = $_POST['description'];
    $estimate = $_POST['estimate'];
    $employeeId = $_POST['employeeId']; // Get the selected employee ID
    $completed = isset($_POST['isCompleted']) ? 1 : 0;
    if (isset($_POST['deleteButton'])) {
        // Get the task ID from the form

        // Prepare and execute an SQL statement to delete the task
        $stmt = $db->prepare('DELETE FROM tasks WHERE id = :taskId');
        $stmt->bindParam(':taskId', $taskId);

        if ($stmt->execute()) {
            $successMessage = 'Task deleted successfully';
        } else {
            $errorMessages[] = 'Error deleting the task.';
        }
    }

    // Validate the input
    if (strlen($description) < 5 || strlen($description) > 40) {
        $errorMessages[] = "Description must be 5 to 40 characters!";
    }

    if (empty($errorMessages)) {
        // Prepare and execute an SQL statement to update the task
        $stmt = $db->prepare('UPDATE tasks SET description = :description, estimate = :estimate, employee_id = :employeeId, completed = :isCompleted WHERE id = :taskId');

        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':estimate', $estimate);
        $stmt->bindParam(':taskId', $taskId);
        $stmt->bindParam(':employeeId', $employeeId);
        $stmt->bindParam(':isCompleted', $completed, PDO::PARAM_INT);
        $stmt->execute();


        $successMessage = 'Task updated successfully!';
        header('Location: task-list-page.php?success=' . urlencode($successMessage));
    }
}

if (isset($_POST['deleteButton'])) {
    // Get the task ID from the form
    $taskId = $_POST['id'];

    // Prepare and execute an SQL statement to delete the task
    $stmt = $db->prepare('DELETE FROM tasks WHERE id = :taskId');
    $stmt->bindParam(':taskId', $taskId);
    $stmt->execute();
}



// Fetch the task data based on the task ID
$taskId = $_GET['task_id'];
$task = getTaskById($db, $taskId);

// Fetch the assigned employee ID from the task_assignment table
$stmt = $db->prepare('SELECT employee_id FROM tasks WHERE id = :taskId');
$stmt->bindParam(':taskId', $taskId);
$stmt->execute();
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);
$assignedEmployeeId = $assignment ? $assignment['employee_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="main.css">
</head>
<body id="edit-task-form">
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
<div class="edit-task-form">
    <div class="edit-task-header">
        Edit Task
    </div>

    <div id="message-block">
        <?php
        if (!empty($errorMessages)) {
            echo '<div id="error-block">';
            foreach ($errorMessages as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        } elseif (!empty($successMessage)) {
            echo '<div id="success-block">' . $successMessage . '</div>';
        }
        ?>
    </div>

    <form method="post" action="edit-task-form.php?id=<?= $taskId ?>">
        <!-- Input fields for editing the task -->
        <div>
            <label for="desc">Description:</label>
        </div>
        <div>
            <input name="description" id="desc" type="text" value="<?= htmlspecialchars($task['description']) ?>">
        </div>
        <div>
            <label for="employee">Assign to Employee:</label>
            <br>
            <select name="employeeId" id="employee">
                <option value="0">Select an employee</option> <!-- Empty option for unassignment -->
                <?php
                // Retrieve the list of employees from your database
                $employees = $db->query('SELECT id, first_name, last_name FROM employees')->fetchAll(PDO::FETCH_ASSOC);

                foreach ($employees as $employee) {
                    $selected = ($employee['id'] == $assignedEmployeeId) ? 'selected' : '';
                    echo '<option value="' . $employee['id'] . '" ' . $selected . '>' . $employee['first_name'] . ' ' . $employee['last_name'] . '</option>';
                }
                ?>
            </select>

        </div>

        <div>
            <label>Estimate:</label>
        </div>
        <div>
            <label><input name="estimate" type="radio" value="1" <?= ($task['estimate'] == 1) ? 'checked' : '' ?>>1</label>
            <label><input name="estimate" type="radio" value="2" <?= ($task['estimate'] == 2) ? 'checked' : '' ?>>2</label>
            <label><input name="estimate" type="radio" value="3" <?= ($task['estimate'] == 3) ? 'checked' : '' ?>>3</label>
            <label><input name="estimate" type="radio" value="4" <?= ($task['estimate'] == 4) ? 'checked' : '' ?>>4</label>
            <label><input name="estimate" type="radio" value="5" <?= ($task['estimate'] == 5) ? 'checked' : '' ?>>5</label>
        </div>
        <div>
            <label for="completed">Completed:</label>
        </div>
        <div>
            <input id="completed" type="checkbox" name="isCompleted" <?= ($task['completed'] == 1) ? 'checked' : '' ?>>
        </div>
        <input type="hidden" name="id" value="<?= $taskId ?>">
        <div class="input-cell button-cell">
            <button type="submit" name="deleteButton">Delete</button>
            <br>
            <button name="submitButton" type="submit">Save Changes</button>
        </div>
    </form>
</div>
</body>
</html>
