<?php

namespace Website\Models\Admin;

use \Phalcon\Mvc\Model as Model;

class Categories extends Model
{
    public function initialize()
    {
        $this->setSource('category');
    }
}