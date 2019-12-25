<?php

namespace Website\Models\Admin;

use SVCodebase\Models\BuilderAdvance;

class BlogsBuilder extends BuilderAdvance
{
    public static function buildBlogsModel()
    {
        $builder = new static();

        $class = Blogs::class;
        $builder->setModelClass($class);

        return $builder->addFrom($class);
    }
}