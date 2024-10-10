<?php

class MenuItem {

    public int $id;
    public string $name;
    public array $subItems = [];

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function addSubItem(MenuItem $subItem): void {
        $this->subItems[] = $subItem;
    }
}

