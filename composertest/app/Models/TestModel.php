<?php

namespace App\Models;

class TestModel
{
    private $text = 'Hello wold';

    public function getHello(){
        return $this->text;
    }
}