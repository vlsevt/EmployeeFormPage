<?php

require_once 'vendor/php-test-framework/public-api.php';

const URL = 'http://localhost:8080/ex4/selectors/selectors.html';

function cssIsCorrect() {
    $cmd = sprintf("google-chrome 
            --headless --disable-gpu 
            --no-sandbox --dump-dom %s", URL);

    $cmd = preg_replace('/\s+/', ' ', $cmd);

    exec($cmd, $output, $exitCode);

    assertThat($exitCode, is(0), 'Error on running Chrome');

    $html = implode("\n", $output);

    assertThat($html, containsString('7 of 7 correct'),
        'Css is not correct');
}

stf\runTests(getPassFailReporter(1));
