<?php

//$sets = distributeToSets([1, 2, 1]);

//var_dump($sets);

function distributeToSets(array $input): array {

    $sets = [];
    foreach ($input as $each) {

        if (isset($sets[$each])) {
            $sets[$each][] = $each;
        } else {
            $sets[$each] = [$each];
        }

    }


    return $sets;
}
