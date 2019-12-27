<?php

namespace Website\Models\Admin;

use SVCodebase\Models\BuilderAdvance;

class CategoriesBuilder extends BuilderAdvance
{
    public static function buildCategoriesModel()
    {
        $builder = new static();

        $class = Categories::class;
        $builder->setModelClass($class);

        return $builder->addFrom($class);
    }
}