<?php

require_once '../vendor/tpl.php';
require_once '../OrderLine.php';

$orderLines = [
    new OrderLine('Pen', 1, true),
    new OrderLine('Paper', 3, false),
    new OrderLine('Staples', 2, true)];

$data = [
    'currentDate' => date('Y'),
    'orderLines' => $orderLines,
    'colors' => ['red', 'blue', 'green'],
    'subTemplatePath' => 'sub_1.html'
];

print renderTemplate('tpl/form.html', $data);

