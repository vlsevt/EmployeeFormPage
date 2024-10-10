<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const PROJECT_DIRECTORY = '';
const BASE_URL = 'http://localhost:8080';

function orderLineDaoReturnsOrderLineObjects() {

    chdir(getProjectDirectory() . '/ex7');

    require_once 'OrderLineDao.php';
    require_once 'OrderLine.php';

    $dataFilePath = getProjectDirectory() . '/ex7/data/order.txt';

    $dao = new OrderLineDao($dataFilePath);

    $orderLines = $dao->getOrderLines();

    assertThat($orderLines[0]->productName, is("Pen"));
    assertThat(intval($orderLines[1]->price), is(3));
    assertThat($orderLines[2]->inStock, is(true));
}

function canCalculateFromCelsiusToFahrenheit() {
    navigateTo(BASE_URL . '/ex7/ex3.php');

    setTextFieldValue('temperature', '20');

    clickButton('calculateButton');

    assertPageContainsText('20');
    assertPageContainsText('68');
}

function canCalculateFromFahrenheitToCelsius() {
    navigateTo(BASE_URL . '/ex7/ex3.php');

    clickLinkWithId('link-ftc');

    setTextFieldValue('temperature', '86');

    clickButton('calculateButton');

    assertPageContainsText('86');
    assertPageContainsText('30');
}

function calculatorDisplaysErrorWhenInputIsNotANumber() {
    navigateTo(BASE_URL . '/ex7/ex3.php');

    setTextFieldValue('temperature', 'abc');

    clickButton('calculateButton');

    assertPageContainsText('Input must be a number');

    assertThat(getFieldValue('temperature'), is('abc'));
}

setBaseUrl(BASE_URL);

stf\runTests(getPassFailReporter(4));
