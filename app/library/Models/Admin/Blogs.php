<?php

namespace Website\Models\Admin;

use \Phalcon\Mvc\Model as Model;

class Blogs extends Model
{
    public function initialize()
    {
        $this->setSource('blog');
    }
}