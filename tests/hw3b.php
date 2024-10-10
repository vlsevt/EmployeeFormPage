<?php

require_once 'vendor/php-test-framework/public-api.php';
require_once 'vendor/php-test-framework/Employee.php';
require_once 'vendor/php-test-framework/Task.php';

const BASE_URL = 'http://localhost:8080';

function canUpdateInsertedEmployees() {

    gotoLandingPage();

    clickEmployeeFormLink();

    $employee = getSampleEmployee();

    setTextFieldValue('firstName', $employee->firstName);
    setTextFieldValue('lastName', $employee->lastName);

    clickEmployeeFormSubmitButton();

    $employeeId = getEmployeeIdByName(
        $employee->firstName . ' ' . $employee->lastName);

    clickLinkWithId('employee-edit-link-' . $employeeId);

    assertThat(getFieldValue('firstName'), is($employee->firstName));
    assertThat(getFieldValue('lastName'), is($employee->lastName));

    $updatedEmployee = getSampleEmployee();

    setTextFieldValue('firstName', $updatedEmployee->firstName);

    clickEmployeeFormSubmitButton();

    assertThat(getPageText(), containsString($updatedEmployee->firstName));
    assertThat(getPageText(), doesNotContainString($employee->firstName));
}

function canUpdateInsertedTasks() {

    gotoLandingPage();

    clickTaskFormLink();

    $task = getSampleTask();

    setTextFieldValue('description', $task->description);

    clickTaskFormSubmitButton();

    $taskId = getTaskIdByDescription($task->description);

    clickLinkWithId('task-edit-link-' . $taskId);

    assertThat(getFieldValue('description'), is($task->description));

    $updatedTask = getSampleTask();

    setTextFieldValue('description', $updatedTask->description);

    clickTaskFormSubmitButton();

    assertThat(getPageText(), containsString($updatedTask->description));
    assertThat(getPageText(), doesNotContainString($task->description));
}

function canUploadProfilePicture() {
    gotoLandingPage();

    clickEmployeeFormLink();

    $employee = getSampleEmployee(); // sample employee with random values

    setTextFieldValue('firstName', $employee->firstName);
    setTextFieldValue('lastName', $employee->lastName);
    setFileFieldValues('picture',
        $employee->profilePicture,
        $employee->profilePictureContents);

    clickEmployeeFormSubmitButton();

    $employeeId = getEmployeeIdByName(
        $employee->firstName . ' ' . $employee->lastName);

    assertThat($employeeId, isNot(null),
        'Did not find employee id');

    $imageUrl = getProfilePictureUrl($employeeId);

    assertThat($imageUrl, isNot(null),
        'Did not find profile picture url');

    $imageContents = getImage($imageUrl);

    assertThat($imageContents, is($employee->profilePictureContents));
}

function employeeFormsDeleteButtonIsNotVisibleWhenAddingNewEmployee() {

    gotoLandingPage();

    clickEmployeeFormLink();

    assertPageDoesNotContainButtonWithName('deleteButton');
}

function taskFormsDeleteButtonIsNotVisibleWhenAddingNewTask() {

    gotoLandingPage();

    clickTaskFormLink();

    assertPageDoesNotContainButtonWithName('deleteButton');
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(5));
