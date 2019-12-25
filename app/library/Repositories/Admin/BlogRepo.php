<?php

namespace Website\Repositories\Admin;

use Phalcon\Di\Injectable;
use Website\Models\Admin\Blogs;
use Website\Models\Admin\BlogsBuilder;

class BlogRepo extends Injectable
{
    protected $blogBuilder;

    public function __construct()
    {
        $this->blogBuilder = BlogsBuilder::buildBlogsModel();
    }

    public function getAll()
    {
        return $this->blogBuilder->get();

//        return $this->modelsManager->createBuilder()
//            ->from(Blogs::class)
//            ->getQuery()
//            ->execute();
    }

    public function getOne($id)
    {
        return $this->blogBuilder->where("blog_id =".$id)->get();
    }

    public function createAction(array $data)
    {
        $blog = $this->blogBuilder->newModel();

        return $blog->create($data);
    }

    public function updateAction($id, array $data)
    {
        return $this->blogBuilder
            ->where("blog_id =".$id)
            ->update($data);
    }

    public function deleteAction($id)
    {
        return $this->blogBuilder
            ->where("blog_id =".$id)
            ->delete();
    }
}