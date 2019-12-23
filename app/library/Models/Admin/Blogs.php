<?php

namespace Website\Models\Admin;

use \Phalcon\Mvc\Model as Model;
use \Phalcon\Security;

class Blogs extends Model
{
    private $db;

    protected $table = Blogs::class;

    public function initialize()
    {
        $this->db = $this->modelsManager->createBuilder();
        $this->setSource('blog');
    }

    public function getOne($id)
    {
        return $this->db
            ->where("blog_id =".$id)
            ->from($this->table)
            ->getQuery()
            ->getSingleResult();
    }

    public function createAction(array $data)
    {
        return $this->create($data);
    }

    public function updateAction($id, array $data)
    {
        $blog = $this->db
            ->where("blog_id =".$id)
            ->from($this->table)
            ->getQuery()
            ->getSingleResult();
        return $blog->update($data);
    }
}