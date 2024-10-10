<?php

class Author {

    public string $firstName;
    public string $lastName;

    public function __construct($firstName, $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

}
