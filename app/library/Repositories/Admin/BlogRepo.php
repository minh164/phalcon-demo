<?php

namespace Website\Repositories\Admin;

use Phalcon\Di\Injectable;
use Website\Models\Admin\Blogs;
use Website\Models\Admin\BlogsBuilder;

class BlogRepo extends Injectable
{


    public function getAll(array $filters = null)
    {
        /** @var \SVCodebase\Models\BuilderAdvance $m */
        $m = BlogsBuilder::buildBlogsModel();

        if (!empty($filters['title'])) {
            $m->wheres('title', 'like', '%'.$filters['title'].'%');
        }

        if (!empty($filters['from_time']) && !empty($filters['to_time'])) {
            $fromTime = strtotime($filters['from_time']);
            $toTime = strtotime($filters['to_time']);

            $m->betweenWhere('created_at', date('Y/m/d H:i:s', $fromTime), date('Y/m/d H:i:s', $toTime));
        }

        return $m->limit(5)->paginate();

//        return $this->modelsManager->createBuilder()
//            ->from(Blogs::class)
//            ->getQuery()
//            ->execute();
    }

    public function getOne($id)
    {
        $m = BlogsBuilder::buildBlogsModel();

        return $m->where("blog_id =".$id)->get();
    }

    public function createAction(array $data)
    {
        $m = BlogsBuilder::buildBlogsModel();
        $blog = $m->newModel();

        return $blog->create($data);
    }

    public function updateAction($id, array $data)
    {
        $m = BlogsBuilder::buildBlogsModel();

        return $m->where("blog_id =".$id)
            ->update($data);
    }

    public function deleteAction($id)
    {
        $m = BlogsBuilder::buildBlogsModel();

        return $m->where("blog_id =".$id)
            ->delete();
    }
}