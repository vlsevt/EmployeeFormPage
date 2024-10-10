<?php

require_once 'vendor/php-test-framework/public-api.php';
require_once 'vendor/php-test-framework/Employee.php';
require_once 'vendor/php-test-framework/Task.php';

const BASE_URL = 'http://localhost:8080';

function submittingEmployeeFormAddsEntryToList() {
    gotoLandingPage();

    clickEmployeeFormLink();

    $employee = getSampleEmployee(); // sample employee with random values

    setTextFieldValue('firstName', $employee->firstName);
    setTextFieldValue('lastName', $employee->lastName);

    clickEmployeeFormSubmitButton();

    assertPageContainsText($employee->firstName);
    assertPageContainsText($employee->lastName);
}

function submittingTaskFormAddsEntryToList() {
    gotoLandingPage();

    clickTaskFormLink();

    $task = getSampleTask(); // sample task with random values

    setTextFieldValue('description', $task->description);
    setRadioFieldValue('estimate', $task->estimate);

    clickTaskFormSubmitButton();

    assertPageContainsText($task->description);
}

function canHandleDifferentSymbolsInEmployeeNames() {
    gotoLandingPage();

    clickEmployeeFormLink();

    $employee = getSampleEmployee(); // sample employee with random values

    $firstName = "!.,:;\n" . $employee->firstName;
    $lastName = "!.,:;\n" . $employee->lastName;

    setTextFieldValue('firstName', $firstName);
    setTextFieldValue('lastName', $lastName);

    clickEmployeeFormSubmitButton();

    assertPageContainsText($firstName);
    assertPageContainsText($lastName);
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(3));
