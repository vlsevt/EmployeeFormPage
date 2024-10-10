<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080';

function landingPageHasMenuWithCorrectLinks() {
    navigateTo(getUrl('temps.php'));

    assertPageContainsLinkWithId('days-under-temp');
    assertPageContainsLinkWithId('avg-winter-temp');
}

function calculateDaysUnderTemperatureForSelectedYear() {
    navigateTo(getUrl('temps.php'));

    selectOptionWithValue('year', '2020');

    setTextFieldValue('temp', '-5');

    clickButton('command');

    assertPageContainsText('4.13');
}

function calculateAverageWinterTemperatureForSelectedYear() {
    navigateTo(getUrl('temps.php'));

    clickLinkWithId('avg-winter-temp');

    selectOptionWithValue('year', '2021/2022');

    clickButton('command');

    assertPageContainsText('-2.12');
}

#Helpers

function getUrl(string $relativeUrl): string {
    $baseUrl = removeLastSlash(BASE_URL);

    return "$baseUrl/ex3/$relativeUrl";
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(3));
