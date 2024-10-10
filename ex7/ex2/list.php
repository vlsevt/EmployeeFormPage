<?php

require_once '../vendor/tpl.php';
require_once 'Book.php';
require_once 'Author.php';

$books = [['Head First HTML and CSS', [['Elisabeth', 'Robson'], ['Eric', 'Freeman']], 5],
          ['Learning Web Design', [['Jennifer', 'Robbins']], 4],
          ['Head First Learn to Code', [['Eric', 'Freeman']], 4]];

$book = new Book('Head First HTML and CSS', 3, false);
$book->addAuthor(new Author('Elisabeth', 'Robson'));
$book->addAuthor(new Author('Eric', 'Freeman'));

$book2 = new Book('Learning Web Design', 4, false);
$author2 = new Author('Jennifer', 'Robbins');
$book2->addAuthor($author2);



$data = [
    'books' => [$book, $book2],
    'contentPath' => 'list.html'
];

print renderTemplate('tpl/main.html', $data);