<?php

class Contact {

    private int $id;
    private string $name;
    private array $phones = [];

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function addPhone(string $number): void {
        $this->phones[] = $number;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPhones(): array {
        return $this->phones;
    }

    public function __toString(): string {
        return sprintf("%s %s [%s] \n",
            $this->id, $this->name, implode(', ', $this->phones));
    }
}
