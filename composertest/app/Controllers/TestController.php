<?php

namespace App\Controllers;

use App\Models\TestModel;

class TestController
{
    public function run(){
        $model = new TestModel;
        echo $model->getHello();
    }
}