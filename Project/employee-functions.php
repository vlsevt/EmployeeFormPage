<?php

use Project\PostEmployee;

require_once 'PostEmployee.php';
function savePost(PDO $db, PostEmployee $post): bool {
    try {
        $stmt = $db->prepare('INSERT INTO employees (first_name, last_name, position, is_available, image_path) VALUES (:first_name, :last_name, :position, :is_available, :image_path)');

        $stmt->bindParam(':first_name', $post->firstName);
        $stmt->bindParam(':last_name', $post->lastName);
        $stmt->bindParam(':image_path', $post->imagePath);
        $stmt->bindParam(':position', $post->position);
        $stmt->bindParam(':is_available', $post->isAvailable);

        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo 'Error saving employee: ' . $e->getMessage();
        return false;
    }
}



function getAllPosts(PDO $db): array {
    try {
        $stmt = $db->query('SELECT * FROM employees');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error retrieving employees: ' . $e->getMessage();
        return [];
    }
}

function deletePostById(PDO $db, string $id): void {
    try {
        $stmt = $db->prepare('DELETE FROM employees WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error deleting employee: ' . $e->getMessage();
    }
}



function getEmployeeById(PDO $db, string $id): ?PostEmployee {
    try {
        $stmt = $db->prepare('SELECT * FROM employees WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employeeData) {
            return new PostEmployee(
                $employeeData['id'],
                $employeeData['first_name'],
                $employeeData['last_name'],
                $employeeData['image_path'],
                $employeeData['position'],
                $employeeData['is_available'],
            );
        }
    } catch (PDOException $e) {
        echo 'Error retrieving employee by ID: ' . $e->getMessage();
    }

    return null; // Employee not found
}

function updateEmployeeData(PDO $db, string $id, string $newFirstName, string $newLastName): bool {
    try {
        $stmt = $db->prepare('UPDATE employees SET first_name = :newFirstName, last_name = :newLastName WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':newFirstName', $newFirstName);
        $stmt->bindParam(':newLastName', $newLastName);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo 'Error updating employee data: ' . $e->getMessage();
        return false;
    }
}

function getTaskById(PDO $db, $taskId) {
    $stmt = $db->prepare('SELECT * FROM tasks WHERE id = :taskId');
    $stmt->bindParam(':taskId', $taskId);
    $stmt->execute();

    // Fetch the task data
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    return $task;
}

