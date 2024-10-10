<?php

require_once 'connection.php';

$conn = getConnection();

//$stmt = $conn->prepare('insert into number (num) values(:num)');
//
//foreach (range(1, 100) as $_) {
//
//    $num = rand(1, 100);
//
//    $stmt->bindValue(':num', $num);
//
//    $stmt->execute();
//
//}

//$stmt = $conn->prepare('select num as my_number from number where num > :threshold');
//
//$stmt->bindValue(':threshold', 80);
//
//foreach ($stmt as $row) {
//
//    var_dump($row[0]);
//    exit;
//}


$stmt = $conn->prepare('INSERT INTO contact (name) VALUES (:name);');

$stmt->bindValue(':name', 'Jill');

$stmt->execute();

$lastInsertId = $conn->lastInsertId();

var_dump($lastInsertId);

$phones = ['1', '2', '3'];

$stmt = $conn->prepare('INSERT INTO phone VALUES (:contact_id, :number);');

foreach ($phones as $phone) {
    $stmt->bindValue(':contact_id', $lastInsertId);
    $stmt->bindValue(':number', $phone);

    $stmt->execute();

}


