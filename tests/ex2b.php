<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080';

function containsIndex() {
    navigateTo(getUrl('index.html'));

    if (getResponseCode() !== 200) {
        fail(ERROR_C01, 'Did not find file ' . getUrl('index.html'));
    }
}

function defaultPageIsDashboard() {
    navigateTo(getUrl('index.html'));

    assertThat(getPageId(), is('dashboard-page'));
}

function dashboardPageContainsCorrectMenu() {
    navigateTo(getUrl('index.html'));

    assertContainsCorrectMenu();
}

function employeeListPageContainsCorrectMenu() {
    navigateTo(getUrl('index.html'));

    clickLinkWithId('employee-list-link');

    assertContainsCorrectMenu();
}

function employeeFormPageContainsCorrectMenu() {
    navigateTo(getUrl('index.html'));

    clickLinkWithId('employee-form-link');

    assertContainsCorrectMenu();
}

function taskListPageContainsCorrectMenu() {
    navigateTo(getUrl('index.html'));

    clickLinkWithId('task-list-link');

    assertContainsCorrectMenu();
}

function taskFormPageContainsCorrectMenu() {
    navigateTo(getUrl('index.html'));

    clickLinkWithId('task-form-link');

    assertContainsCorrectMenu();
}

#Helpers

function assertContainsCorrectMenu() {
    assertPageContainsRelativeLinkWithId('dashboard-link');
    assertPageContainsRelativeLinkWithId('employee-list-link');
    assertPageContainsRelativeLinkWithId('employee-form-link');
    assertPageContainsRelativeLinkWithId('task-list-link');
    assertPageContainsRelativeLinkWithId('task-form-link');
}

function getUrl(string $relativeUrl = ''): string {
    $baseUrl = removeLastSlash(BASE_URL);

    return "$baseUrl/ex2/proto/$relativeUrl";
}

setBaseUrl(BASE_URL);

stf\runTests(getPassFailReporter(6));