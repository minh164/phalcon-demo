<?php

namespace Website\Repositories\Admin;

use Phalcon\Di\Injectable;
use Website\Models\Admin\CategoriesBuilder;

class CategoryRepo extends Injectable
{
    public function getAll(array $filters = null)
    {
        /** @var \SVCodebase\Models\BuilderAdvance $m */
        $m = CategoriesBuilder::buildCategoriesModel();

//        if (!empty($filters['title'])) {
//            $m->wheres('title', 'like', '%'.$filters['title'].'%');
//        }
//
//        if (!empty($filters['from_time']) && !empty($filters['to_time'])) {
//            $fromTime = strtotime($filters['from_time']);
//            $toTime = strtotime($filters['to_time']);
//
//            $m->betweenWhere('created_at', date('Y/m/d H:i:s', $fromTime), date('Y/m/d H:i:s', $toTime));
//        }

        return $m
//            ->limit(5)
            ->get();
    }
}