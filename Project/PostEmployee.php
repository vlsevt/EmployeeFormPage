<?php

namespace Project;
class PostEmployee
{

    public string $firstName;
    public string $lastName;
    public string $position;
    public string $isAvailable;
    public string $imagePath;
    public ?string $id;

    public function __construct(?string $id, string $firstName, ?string $lastName, string $position, string $isAvailable, string $imagePath)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->position = $position;
        $this->isAvailable = $isAvailable;
        $this->imagePath = $imagePath;
    }

    public function __toString(): string
    {
        return sprintf('Id: %s First Name: %s Last Name: %s',
            $this->id, $this->firstName, $this->lastName);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getIsAvailable(): string
    {
        return $this->isAvailable;
    }
}