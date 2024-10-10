<?php

require_once '../connection.php';
require_once 'MenuItem.php';

function getMenu(): array {

    $conn = getConnection();

    $stmt = $conn->prepare('SELECT id, parent_id, name 
                            FROM menu_item ORDER BY id');

    $stmt->execute();

    $dict = [];
    $menu = [];
    foreach ($stmt as $row) {
        $id = $row['id'];
        $name = $row['name'];
        $parentId = $row['parent_id'];

        $newItem = new MenuItem($id, $name);

        $dict[$id] = $newItem;

        if ($parentId !== null) {
            $dict[$parentId]->addSubItem($newItem);
        } else {
            $menu[] = $newItem;
        }
    }

    return $menu;
}












function printMenu($items, $level = 0) : void {
    $padding = str_repeat(' ', $level * 3);
    foreach ($items as $item) {
        printf("%s%s\n", $padding, $item->name);
        if ($item->subItems) {
            printMenu($item->subItems, $level + 1);
        }
    }
}
