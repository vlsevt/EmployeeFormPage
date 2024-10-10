<?php

class Book {

    public string $title;
    public ?int $grade;
    public ?bool $isRead;
    public array $authors = [];

    public function __construct(string $title, ?int $grade, ?bool $isRead) {
        $this->title = $title;
        $this->grade = $grade;
        $this->isRead = $isRead;
    }

    public function addAuthor($author) {
        $this->authors[] = $author;
    }

}
