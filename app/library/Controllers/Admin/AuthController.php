<?php

namespace Website\Controllers\Admin;

use Website\Controller;
use Website\Models\Admin\Admins;
use Website\Request\Auth\registerRequest;
use Website\Request\Auth\loginRequest;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    protected $admins;

    public function onConstruct()
    {
        $this->admins = new Admins();
    }

    public function showLoginFormAction()
    {
        $this->registry->view = 'admin/layouts/login';
    }

    public function submitLoginAction()
    {
        $request = new loginRequest();
        // Validate
        $messages = $request->validateForm($_POST);
        if (count($messages) > 0) {
            // add error
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        } else {
            // processing login
            try {
                $admin = $this->admins->credential($_POST);
                // success
                if ($admin != false) {
//                    $this->session->set('admin_info', $admin);
                    $this->registerJwt($_POST['email']);

                    $redirectRoute = $this->getDI()->get('namedRoute', ['admin.dashboard']);

                    return $this->response->redirect($redirectRoute);
                }
                // fail
                $this->flash->error('Email or password is not matched');

            } catch (\Exception $exception) {
                echo $exception->getMessage(); die();
            }
        }

        $redirectRoute = $this->getDI()->get('namedRoute', ['admin.login']);

        return $this->response->redirect($redirectRoute);
    }

    public function showRegisterFormAction()
    {
        $this->registry->abc = 123;
        $this->registry->view = 'admin/layouts/register';
        $this->session->remove('errors');
    }

    public function submitRegisterAction()
    {
        $request = new registerRequest();

        // Validate
        $messages = $request->validateForm($_POST);
        if (count($messages) > 0) {
            // add error
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
            $redirectRoute = $this->getDI()->get('namedRoute', ['admin.register']);

            return $this->response->redirect($redirectRoute);
        }

        // processing insert
        try {
            $arrayCreate = $_POST;
            $security = new \Phalcon\Security();
            $arrayCreate['password'] = $security->hash($arrayCreate['password']);

            $result = $this->admins->createAdmin($arrayCreate);
            if ($result) {
                dd('done');
            }

        } catch (\Exception $exception) {
            echo $exception->getMessage(); die();
        }

    }

    public function logoutAction()
    {
        if ($this->session->has('admin_info')) {
            $this->session->remove('admin_info');
            $route = $this->getDI()->get('namedRoute', ['admin.login']);

            return $this->response->redirect($route);
        }
    }

    public function registerJwt($email)
    {
        $key = 'demophalconkey';
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $payload = [
            'iat' => time(),
            'user_email' => $email
        ];
        return $jwt = JWT::encode($payload, $key);
    }
}