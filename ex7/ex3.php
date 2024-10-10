<?php

require_once 'vendor/tpl.php';
require_once 'Request.php';

$request = new Request($_REQUEST);

//print $request; // display input parameters (for debugging)

$cmd = $request->param('cmd')
    ? $request->param('cmd')
    : 'ctf_form';

if ($cmd === 'ctf_form') {
    $data = [
        'template' => 'ex3_form.html',
        'cmd' => 'ctf_calculate',
    ];

    print renderTemplate('tpl/ex3_main.html', $data);

} else if ($cmd === 'ftc_form') {
    $data = [
        'template' => 'ex3_form.html',
        'cmd' => 'ftc_calculate',
    ];

    print renderTemplate('tpl/ex3_main.html', $data);

} else if ($cmd === 'ctf_calculate') {

    $input = $request->param('temperature');

    $errors = validate($input);

    if (empty($errors)){
        $result = celsiusToFahrenheit($input);
        $message = "$input degrees in Celsius is $result degrees in Fahrenheit";
        $data = [
            'template' => 'ex3_result.html',
            'message' => $message
        ];

        print renderTemplate('tpl/ex3_main.html', $data);
    } else {
        $data = [
            'template' => 'ex3_form.html',
            'errors' => $errors,
            'value' => $input,
            'cmd' => 'ctf_calculate',
        ];

        print renderTemplate('tpl/ex3_main.html', $data);

    }


} else if ($cmd === 'ftc_calculate') {

    $input = $request->param('temperature');
    $result = fahrenheitToCelsius($input);
    $message = "$input degrees in Fahrenheit is $result degrees in Celsius";
    $data = [
        'template' => 'ex3_result.html',
        'message' => $message
    ];

    print renderTemplate('tpl/ex3_main.html', $data);

} else {
    throw new Error('programming error');
}

function validate($input) {
    if (is_numeric($input)){
        return [];
    } else {
        return ['Input must be a number'];
    }
}
function celsiusToFahrenheit($temp) : float {
    return round($temp * 9 / 5 + 32, 2);
}

function fahrenheitToCelsius($temp) : float {
    return round(($temp - 32) / (9 / 5), 2);
}

