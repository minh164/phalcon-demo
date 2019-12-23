<?php

namespace Website\Controllers\Admin;

use Website\Controller;
use Website\Models\Admin\Admins;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $admin = new Admins();

//        dump($admin->getAll()); die();
        $this->registry->view = 'admin/dashboard/index';
    }
}