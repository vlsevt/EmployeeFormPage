<?php
require_once 'PostEmployee.php';
require_once 'employee-functions.php';
try {
    $db = new PDO('mysql:host=localhost;dbname=vlsevt', 'vlsevt', '220203');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}
// Retrieve the employee's ID from the query parameter
$employeeId = $_GET['employee_id'];

// Assuming you have a function to fetch employee data by ID
$employee = getEmployeeById($db, $employeeId);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and update the name and surname
    $newFirstName = $_POST['firstName'];
    $newLastName = $_POST['lastName'];

    // Update the employee's data (assuming you have a function for this)
    updateEmployeeData($db, $employeeId, $newFirstName, $newLastName);

    // Redirect back to employee-list-page.php or wherever you want
    header('Location: employee-list-page.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="main.css">
</head>
<body id="edit-employee-form">
<h1>Edit Employee</h1>
<form method="post" action="edit-employee-form.php?employee_id=<?= urlencode($employeeId) ?>">
    <label for="new_first_name">New First Name:</label>
    <label>
        <input type="text" name="firstName" value="<?= htmlspecialchars($employee->getFirstName()) ?>">
    </label>

    <label for="new_last_name">New Last Name:</label>
    <label>
        <input type="text" name="lastName" value="<?= htmlspecialchars($employee->getLastName()) ?>">
    </label>

    <button type="submit" name="submitButton">Update</button>
</form>
<?php
echo '<form method="post" action="delete-employee.php">';
echo '<input type="hidden" name="employee_id" value="' . $employeeId . '">';
echo '<button type="submit" name="deleteButton">Delete</button>';
echo '</form>';
?>

<a href="employee-list-page.php">Back to Employee List</a>
</body>
</html>
