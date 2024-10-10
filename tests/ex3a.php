<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080';

function landingPageHasMenuWithCorrectLinks() {
    navigateTo(getUrl());

    assertPageContainsLinkWithId('c2f');
    assertPageContainsLinkWithId('f2c');
}

function f2cPageHasMenuWithCorrectLinks() {
    navigateTo(getUrl());

    clickLinkWithId('f2c');

    assertPageContainsLinkWithId('c2f');
    assertPageContainsLinkWithId('f2c');
}

function calculatesCelsiusToFahrenheit() {
    navigateTo(getUrl());

    setTextFieldValue('temperature', '20');

    clickButton('calculateButton');

    assertPageContainsText('is 68 degrees');
}

function calculatesFahrenheitToCelsius() {
    navigateTo(getUrl());

    clickLinkWithId('f2c');

    setTextFieldValue('temperature', '68');

    clickButton('calculateButton');

    assertPageContainsText('is 20 degrees');
}

#Helpers

function getUrl(): string {
    $baseUrl = removeLastSlash(BASE_URL);

    return "$baseUrl/ex3/calc/";
}

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(getPassFailReporter(4));
