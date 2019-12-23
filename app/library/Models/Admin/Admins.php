<?php

namespace Website\Models\Admin;

use \Phalcon\Mvc\Model as Model;
use \Phalcon\Security;

class Admins extends Model
{
    private $db;

    protected $table = Admins::class;

    public function initialize()
    {
        $this->db = $this->modelsManager->createBuilder();
        $this->setSource('admin');
    }

    public function credential(array $data)
    {
        $email = $data['email'];

        $admin = $this->db
            ->where("email = '".$email."'")
            ->from($this->table)
            ->getQuery()
            ->getSingleResult();

        if ($admin) {
            $security = new \Phalcon\Security();
            $password = $security->checkHash($data['password'], $admin->password);
            if ($password) {
                return $admin;
            }
        }

        return false;
    }

    public function getAll()
    {
        return $this->db
            ->from($this->table)
            ->getQuery()
            ->execute();
    }

    public function createAdmin(array $data)
    {
        return $this->create($data);
    }
}