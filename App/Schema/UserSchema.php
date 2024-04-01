<?php
namespace App\Schema;

class UserSchema {

    public $id;

    public $name;

    public $pass;

    function __construct(int $id, string $name, string $pass) 
    {
        $this->id = $id;
        $this->name = $name;
        $this->pass = $pass;

    }
}
