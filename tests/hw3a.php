<?php

require_once 'vendor/php-test-framework/public-api.php';
require_once 'vendor/php-test-framework/Employee.php';
require_once 'vendor/php-test-framework/Task.php';

const BASE_URL = 'http://localhost:8080/';

function displaysErrorWhenSubmittingInvalidEmployeeData() {

    gotoLandingPage();

    clickEmployeeFormLink();

    clickButton('submitButton');

    assertPageContainsElementWithId('error-block');

    $employee = getSampleEmployee(); // sample employee with random values

    setTextFieldValue('firstName', $employee->firstName);
    setTextFieldValue('lastName', $employee->lastName);

    clickEmployeeFormSubmitButton();

    assertPageContainsElementWithId('message-block');
    assertPageDoesNotContainElementWithId('error-block');
}

function onValidationErrorEmployeeFormIsFilledWithInsertedData() {

    gotoLandingPage();

    clickEmployeeFormLink();

    setTextFieldValue('firstName', 'a');
    setTextFieldValue('lastName', 'b');

    clickButton('submitButton');

    assertThat(getFieldValue('firstName'), is('a'));
    assertThat(getFieldValue('lastName'), is('b'));
}

function displaysErrorWhenSubmittingInvalidTaskData() {

    gotoLandingPage();

    clickTaskFormLink();

    clickButton('submitButton');

    assertPageContainsElementWithId('error-block');

    setTextFieldValue('description', 'some description');

    clickButton('submitButton');

    assertPageDoesNotContainElementWithId('error-block');
    assertPageContainsElementWithId('message-block');
}

function onValidationErrorTaskFormIsFilledWithInsertedData() {

    gotoLandingPage();

    clickTaskFormLink();

    setTextFieldValue('description', 'a');

    clickButton('submitButton');

    assertThat(getFieldValue('description'), is('a'));
}

function canDeleteInsertedEmployees() {

    gotoLandingPage();

    clickEmployeeFormLink();

    $employee = getSampleEmployee();

    setTextFieldValue('firstName', $employee->firstName);
    setTextFieldValue('lastName', $employee->lastName);

    clickEmployeeFormSubmitButton();

    $employeeId = getEmployeeIdByName(
        $employee->firstName . ' ' . $employee->lastName);

    clickLinkWithId('employee-edit-link-' . $employeeId);

    clickEmployeeFormDeleteButton();

    assertThat(getPageText(), doesNotContainString($employee->firstName));
}

function canDeleteInsertedTasks() {

    gotoLandingPage();

    clickTaskFormLink();

    $task = getSampleTask();

    setTextFieldValue('description', $task->description);

    clickTaskFormSubmitButton();

    $taskId = getTaskIdByDescription($task->description);

    clickLinkWithId('task-edit-link-' . $taskId);

    clickTaskFormDeleteButton();

    assertThat(getPageText(), doesNotContainString($task->description));
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(6));
