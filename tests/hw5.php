<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080';

const PROJECT_DIRECTORY = '';

function applicationLinksShouldBeInCorrectFormat() {

    gotoLandingPage();

    // expected format is ?key1=value1&key2=value2&...

    assertFrontControllerLink('employee-list-link');
    assertFrontControllerLink('employee-form-link');
    assertFrontControllerLink('task-list-link');
    assertFrontControllerLink('task-form-link');

    clickEmployeeFormLink();

    assertFrontControllerLink('employee-list-link');
    assertFrontControllerLink('employee-form-link');
    assertFrontControllerLink('task-list-link');
    assertFrontControllerLink('task-form-link');

    clickTaskFormLink();

    assertFrontControllerLink('employee-list-link');
    assertFrontControllerLink('employee-form-link');
    assertFrontControllerLink('task-list-link');
    assertFrontControllerLink('task-form-link');
}

function makesRedirectAfterFormSubmission() {
    gotoLandingPage();

    clickEmployeeFormLink();

    setTextFieldValue('firstName', "Alice");
    setTextFieldValue('lastName', "Smith");

    disableAutomaticRedirects();

    clickButton('submitButton');

    assertThat(getResponseCode(), isAnyOf(301, 302, 303));

    assertNoOutput();
}

function phpAndHtmlCodeIsSeparated() {
    $path = getProjectDirectory();

    foreach(getProjectFiles($path) as $each) {
        $contents = file_get_contents($each->getAbsolutePath());

        if (containsHtmlTags($contents) && containsPhpTags($contents)) {
            fail(ERROR_C01, "File {$each->getRelativePath()} contains both Php and Html code");
        }
    }
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(3));
