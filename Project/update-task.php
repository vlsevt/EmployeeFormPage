<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'];
    $newDescription = $_POST['description'];
    $newEstimate = $_POST['estimate'];

    // Read existing task data from the file
    $taskData = file('tasks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Iterate through the tasks and update the one with a matching ID
    foreach ($taskData as $index => $task) {
        list($description, $estimate, $existingTaskId) = explode(', ', $task);

        if ($existingTaskId == $taskId) {
            // Update the description and estimate for the matching task
            $taskData[$index] = "$newDescription, $newEstimate, $taskId";
            break; // Stop searching after finding the matching task
        }
    }
    // Check if the "Delete" button was clicked
    if (isset($_POST['deleteButton'])) {
        // Read existing task data from the file
        $taskData = file('tasks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Iterate through the tasks and remove the one with a matching ID
        foreach ($taskData as $index => $task) {
            list($description, $estimate, $existingTaskId) = explode(', ', $task);

            if ($existingTaskId == $taskId) {
                unset($taskData[$index]);
                break; // Stop searching after finding the matching task
            }
        }

        // Save the updated task data back to the file
        file_put_contents('tasks.txt', implode(PHP_EOL, $taskData));

        // Redirect to the task list page with a success message
        $successMessage = 'Task deleted';
        header('Location: task-list-page.php?success=' . urlencode($successMessage));
        exit;
    }


    // Save the updated task data back to the file
    file_put_contents('tasks.txt', implode(PHP_EOL, $taskData));


    // Redirect to the task list page with a success message
    $successMessage = 'Task updated';
    header('Location: task-list-page.php?success=' . urlencode($successMessage));
    exit;
}