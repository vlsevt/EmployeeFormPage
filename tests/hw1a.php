<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

if ($argc < 2) {
    die('Pass project directory as an argument' . PHP_EOL);
} else {
    $path = realpath($argv[1]);
}

if ($path === false) {
    die('Argument is not a correct directory.' . PHP_EOL);
}

$json = readJsonFileFrom($path);

$errors = [];

if (!$json['firstName']) {
    $errors[] = 'First name is missing';
}
if (!$json['lastName']) {
    $errors[] = 'Last name is missing';
}
if (!$json['passwordHash']) {
    $errors[] = 'Password hash is missing';
}
if ($json['iHaveReadTheRulesOfTheCourse'] !== true) {
    $errors[] = 'iHaveReadTheRulesOfTheCourse must be true';
}

if (count($errors)) {
    print join(PHP_EOL, $errors);

    printf(RESULT_PATTERN_SHORT, RESULT_FAILED);

    exit(1);

} else {
    printf(RESULT_PATTERN_SHORT, RESULT_PASSED);
}
