<?php

namespace Exode\Contacts;

class Contact {
    public string $first_name;
    public string $name;
    public string $tel;
    public string $role;
    public string $id; // unique for editing/deleting

    public function __construct(string $first_name, string $name, string $tel, string $role) {
        $this->first_name = $first_name;
        $this->name = $name;
        $this->tel = $tel;
        $this->role = $role;
        $this->id = uniqid();
    }
}
