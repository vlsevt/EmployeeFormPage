<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const PROJECT_DIRECTORY = '';

function findsDaysUnderTargetTemperature() {

    chdir(getProjectDirectory() . '/ex2');

    $command = 'php temps.php --command days-under-temp --year 2022 --temp -5';

    $result = trim(shell_exec($command));

    assertThat($result, is('20.5'));
}

function findsDaysUnderTargetTemperatureDictionary() {

    chdir(getProjectDirectory() . '/ex2');

    $command = 'php temps.php --command days-under-temp-dict --temp -5';

    $result = trim(shell_exec($command));

    assertThat($result, is('[2020 => 4.13, 2021 => 41.04, 2022 => 20.5]'));
}

function findsAverageWinterTemperature() {

    chdir(getProjectDirectory() . '/ex2');

    $command = 'php temps.php --command avg-winter-temp --year 2021/2022';

    $result = trim(shell_exec($command));

    assertThat($result, is('-2.12'));
}

function showsErrorOnMissingParameters() {

    chdir(getProjectDirectory() . '/ex2');

    $command = 'php temps.php --command days-under-temp --year 2021';

    $output = '';
    $resultCode = 0;
    exec($command . ' 2>&1', $output, $resultCode);

    assertThat(strlen($output[0]) > 10, is(true));

    assertThat($resultCode, is(1));
}

function errorsArePrintedToSTDERR() {
    chdir(getProjectDirectory() . '/ex2');

    $command = 'php temps.php --command days-under-temp --year 2021';

    $output = shell_exec($command);

    assertThat(strlen($output), is(0));
}

stf\runTests(getPassFailReporter(5));