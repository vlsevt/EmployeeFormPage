<?php

require_once 'common-functions.php';
require_once 'vendor/php-test-framework/public-api.php';

const PROJECT_DIRECTORY = '';

function checksWhetherListContainsSpecifiedElement() {

    require_once 'ex1/ex2.php';

    $list = [1, 2, 3, 2, 6];

    assertThat(isInList($list, 7), is(false));

    assertThat(isInList($list, 3), is(true));

    assertThat(isInList($list, '3'), is(false));
}

function convertsListToString() {

    require_once 'ex1/ex3.php';

    $list = [3, 2, 6];

    assertThat(listToString($list), is('[3, 2, 6]'));
}

function convertsStringToIntegerList() {

    require_once 'ex1/ex4.php';

    $input = '[3, 2, 6]';

    assertThat(stringToIntegerList($input), is([3, 2, 6]));
}

function getsAverageWeightsByType() {

    require_once 'ex1/ex5.php';

    $input = [
        ['type' => 'apple', 'weight' => 0.21],
        ['type' => 'orange', 'weight' => 0.18],
        ['type' => 'orange', 'weight' => 0.16],
        ['type' => 'apple', 'weight' => 0.22],
        ['type' => 'orange', 'weight' => 0.15]
    ];

    $result = getAverageWeightsByType($input);

    assertThat($result['apple'], is(0.22));
    assertThat($result['orange'], is(0.16));
}

function findsDaysUnderTargetTemperature() {

    chdir(getProjectDirectory() . '/ex1');

    require_once 'ex7.php';

    assertThat(getDaysUnderTemp(2020, -10), isCloseTo(0.17));
    assertThat(getDaysUnderTemp(2021, -10), isCloseTo(12.67));
    assertThat(getDaysUnderTemp(2022, -10), isCloseTo(1.96));

    assertThat(getDaysUnderTemp(2020, -5), isCloseTo(4.13));
    assertThat(getDaysUnderTemp(2021, -5), isCloseTo(41.04));
    assertThat(getDaysUnderTemp(2022, -5), isCloseTo(20.5));
}

function findsDaysUnderTargetTemperatureDictionary() {

    chdir(getProjectDirectory() . '/ex1');

    require_once 'ex8.php';

    $dict = getDaysUnderTempDictionary(-10);

    assertThat($dict[2020], isCloseTo(0.17));
    assertThat($dict[2021], isCloseTo(12.67));
    assertThat($dict[2022], isCloseTo(1.96));

}

function convertsDictionaryToString() {

    require_once 'ex1/ex8.php';

    $string = dictToString(['a' => 1, 'b' => 2]);

    assertThat($string, is('[a => 1, b => 2]'));
}

extendIncludePath($argv, PROJECT_DIRECTORY);

stf\runTests(getPassFailReporter(7));
