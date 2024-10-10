<?php
$successMessage = '';
$errorMessages = [];

try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $estimate = isset($_POST['estimate']) ? intval($_POST['estimate']) : 1;
    $employeeId = isset($_POST['employeeId']) ? intval($_POST['employeeId']) : 0; // Change to a default integer value (e.g., 0) if it's not a valid integer.
    $completed = isset($_POST['isCompleted']) ? 1 : 0;



    if (strlen($description) < 5 || strlen($description) > 40) {
        $errorMessages[] = "Description must be 5 to 40 characters!";
    }

    if (empty($errorMessages)) {
        $stmt = $db->prepare('INSERT INTO tasks (description, estimate, employee_id, completed) VALUES (:description, :estimate, :employee_id, :completed)');
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':estimate', $estimate);
        $stmt->bindParam(':employee_id', $employeeId);
        $stmt->bindParam(':completed', $completed);
        $stmt->execute();

        $successMessage = 'Saved!';
        header('Location: task-list-page.php?success=' . urlencode($successMessage));
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Task</title>
    <link rel="stylesheet" href="main.css">
</head>
<body id="task-form-page">
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
<div class="add-task-table">
    <div class="add-task-header">
        Add Task
    </div>
    <div id="message-block">
        <?php
        if (!empty($errorMessages)) {
            echo '<div id="error-block">';
            foreach ($errorMessages as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
    </div>
    <form method="post" class="add-task-content" action="task-form-page.php">
        <div>
            <label for="desc">Description:</label>
        </div>
        <div>
            <input name="description" id="desc" value="<?php echo $_POST['description'] ?? ''; ?>">
        </div>
        <div>
            <label for="employee">Assign to Employee:</label>
            <br>
            <select name="employeeId" id="employee">
                <option value="0">Select an employee</option> <!-- Empty option for unassignment -->
                <?php
                // Retrieve the list of employees from your database and populate the dropdown
                $employees = $db->query('SELECT id, first_name, last_name FROM employees')->fetchAll(PDO::FETCH_ASSOC);

                foreach ($employees as $employee) {
                    echo '<option name="' . $employee['id'] . '" value="' . $employee['id'] . '">' . $employee['first_name'] . ' ' . $employee['last_name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div>Estimate:</div>
        <div>
            <label><input name="estimate" type="radio" value="1">1</label>
            <label><input name="estimate" type="radio" value="2">2</label>
            <label><input name="estimate" type="radio" value="3">3</label>
            <label><input name="estimate" type="radio" value="4">4</label>
            <label><input name="estimate" type="radio" value="5">5</label>
        </div>
        <div>
            <label for="completed">Completed:</label>
        </div>
        <div>
            <input id="completed" type="checkbox" name="isCompleted">
        </div>
        <div class="input-cell button-cell">
            <br>
            <button name="submitButton" type="submit">Save</button>
        </div>
    </form>
</div>
<div class="navbar">
    <a class="active">ICD0007 Sample Application</a>
</div>
</body>
</html>
