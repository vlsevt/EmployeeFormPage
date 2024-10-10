<?php

require_once 'vendor/php-test-framework/public-api.php';
require_once 'vendor/php-test-framework/Employee.php';
require_once 'vendor/php-test-framework/Task.php';

const BASE_URL = 'http://localhost:8080';

function assigningEmployeeForTaskPutsItInPendingState() {

    $employee = insertSampleEmployee();

    clickTaskFormLink();

    $task = getSampleTask();

    setTextFieldValue('description', $task->description);
    selectOptionWithValue('employeeId', $employee->id);

    clickTaskFormSubmitButton();

    $taskId = getTaskIdByDescription($task->description);

    gotoDashboardPage();

    assertThat(getTaskState($taskId), is('pending'));
}

function markingTaskAsCompletedPutsItIntoClosedState() {

    gotoLandingPage();

    clickTaskFormLink();

    $task = getSampleTask();

    setTextFieldValue('description', $task->description);

    clickTaskFormSubmitButton();

    $taskId = getTaskIdByDescription($task->description);

    assertThat(getTaskState($taskId), is('open'));

    clickLinkWithId('task-edit-link-' . $taskId);

    setCheckboxValue('isCompleted', true);

    clickTaskFormSubmitButton();

    gotoDashboardPage();

    assertThat(getTaskState($taskId), is('closed'));
}

function assigningTasksIncreasesEmployeeTaskCount() {

    $employee = insertSampleEmployee();

    gotoDashboardPage();

    assertThat(getEmployeeTaskCount($employee->id), is('0'));

    insertTaskFor($employee->id);

    gotoDashboardPage();

    assertThat(getEmployeeTaskCount($employee->id), is('1'));

    insertTaskFor($employee->id);

    gotoDashboardPage();

    assertThat(getEmployeeTaskCount($employee->id), is('2'));
}

#Helpers

function insertTaskFor(string $employeeId): void {
    clickTaskFormLink();

    $task = getSampleTask();

    setTextFieldValue('description', $task->description);
    selectOptionWithValue('employeeId', $employeeId);

    clickTaskFormSubmitButton();
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(3));
