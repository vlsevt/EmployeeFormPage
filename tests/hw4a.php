<?php

require_once 'vendor/php-test-framework/public-api.php';
require_once 'vendor/php-test-framework/Employee.php';
require_once 'vendor/php-test-framework/Task.php';

const BASE_URL = 'http://localhost:8080';

function canAssignTasks() {

    $employee = insertSampleEmployee();

    clickTaskFormLink();

    $task = getSampleTask();

    setTextFieldValue('description', $task->description);
    selectOptionWithValue('employeeId', $employee->id);

    clickTaskFormSubmitButton();

    $taskId = getTaskIdByDescription($task->description);

    clickLinkWithId('task-edit-link-' . $taskId);

    assertThat(getPageText(), containsString($employee->firstName));
    assertThat(getPageText(), containsString($employee->lastName));

    assertThat(getFieldValue('employeeId'), is($employee->id));
}

function doesNotAllowSqlInjectionWhenAddingEmployee() {

    gotoLandingPage();

    clickEmployeeFormLink();

    $dangerousSymbols = " \" ; ' ";
    $firstName = getSampleEmployee()->firstName; // e.g. 2f7ff
    $lastName = getSampleEmployee()->lastName; // e.g. 57736e

    $dangerousFirstName = $firstName . $dangerousSymbols; // e.g. 2f7ff " ; '
    $dangerousLastName = $lastName . $dangerousSymbols; // e.g. 57736e " ; '

    // should accept these values as names
    setTextFieldValue('firstName', $dangerousFirstName);
    setTextFieldValue('lastName', $dangerousLastName);

    clickEmployeeFormSubmitButton();

    assertThat(getPageText(), containsString($dangerousFirstName));
    assertThat(getPageText(), containsString($dangerousLastName));
}

function doesNotAllowSqlInjectionWhenAddingTask() {

    gotoLandingPage();

    clickTaskFormLink();

    $dangerousSymbols = " \" ; ' ";
    $description = getSampleTask()->description;
    $dangerousDescription = $description . $dangerousSymbols;

    // should accept this value as a task description
    setTextFieldValue('description', $dangerousDescription);

    // should ignore these values and not break
    forceFieldValue('estimate', $dangerousSymbols);
    forceFieldValue('employeeId', $dangerousSymbols);

    clickTaskFormSubmitButton();

    assertThat(getPageText(), containsString($dangerousDescription));
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(3));
