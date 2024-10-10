<?php

require_once 'vendor/php-test-framework/public-api.php';
require_once 'common-functions.php';

if ($argc < 2) {
    die('Pass directory to scan as an argument' . PHP_EOL);
} else {
    $path = realpath($argv[1]);
}

if ($path === false) {
    die('Argument is not a correct directory' . PHP_EOL);
}

function repositoryDoesNotContainNonProjectPhpFiles() {
    global $path;

    $count = getFileCount($path, 'php');

    if ($count > 12) {
        fail(ERROR_C01, "Repository contains too many ($count) Php files (max 12)");
    }
}

function repositoryDoesNotContainNonProjectHtmlFiles() {
    global $path;

    $count = getFileCount($path, 'html');

    if ($count > 12) {
        fail(ERROR_C01, "Repository contains too many ($count) Html files (max 12)");
    }
}

function repositorySizeIsNotTooBig() {
    global $path;

    $size = getRepoSize($path);

    if ($size > pow(2, 20)) {
        fail(ERROR_C01, "Repository size is too big ($size bytes). Maximum is 1MB");
    }

    var_dump($size);
}

stf\runTests(getPassFailReporter(3));
