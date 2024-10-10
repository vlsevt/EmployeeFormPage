<?php

require_once 'vendor/php-test-framework/public-api.php';

[$projectDir, $username, $secret] = getArguments($argv);

$dict = tokensAsDict(getTokenFilePath($projectDir));

$errors = validateTokens($dict, $username, $secret);

reportResult($errors);

function getArguments(array $argv): array {
    if (!isset($argv[3])) {
        die('Pass project directory, workspace ID and secret as arguments.' . PHP_EOL);
    } else {
        $projectDir = $argv[1];
        $username = $argv[2];
        $secret = $argv[3];
    }

    return [$projectDir, $username, $secret];
}

function reportResult(array $errors): void {
    if (empty($errors)) {

        printf(RESULT_PATTERN_SHORT, RESULT_PASSED);

    } else {
        print join(PHP_EOL, $errors);

        printf(RESULT_PATTERN_SHORT, RESULT_FAILED);
    }
}

function validateTokens($dict, string $username, string $secret): array {
    $errors = [];

    foreach (range(1, 21) as $nr) {

        $key = strval($nr);
        $actualValue = $dict[$key] ?? '';

        if (empty($actualValue)) {
            $errors[] = ("Token for exercise $nr is missing");
        } else if (!isValid($nr, $username, $secret, $actualValue)) {
            $errors[] = ("Incorrect token for exercise $nr");
        }
    }
    return $errors;
}

function tokensAsDict(string $tokenFilePath): array {
    $dict = [];

    foreach (file($tokenFilePath) as $line) {
        if (!trim($line)) {
            continue;
        }

        if (preg_match('/Token (\d+): (\w+)/', $line, $matches)) {
            $tokenNumber = $matches[1];
            $tokenValue = $matches[2];
            $dict[$tokenNumber] = $tokenValue;
        }
    }

    return $dict;
}

function getTokenFilePath($path): string {
    $path = realpath($path) or die('Path is not a correct directory.' . PHP_EOL);;

    $dataFile = "$path/ex6/tokens.txt";

    if (!file_exists($dataFile)) {
        die("can't find ex6/tokens.txt from $path" . PHP_EOL);
    }

    return $dataFile;
}

function isValid($exNo, $userName, $secret, $actualValue): bool {
    if ($exNo === 1 || $exNo === 8 || $exNo === 15) {
        $userName = '';
    }

    $hash = sha1($exNo . $userName . $secret);

    $hash = substr($hash, 0, 15);

    return $actualValue === $hash;
}
