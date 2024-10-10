<?php

require_once '../vendor/tpl.php';
require_once 'Book.php';

$errors = ['Pealkiri peab olema 2 kuni 10 märki', 'Hinne peab olema määratud'];
$book = new Book('Head First HTML and CSS', 4, true);

$data = [
    'errors' => $errors,
    'book' => $book,
    'isEditForm' => true,
];

print renderTemplate('tpl/form.html', $data);
