<?php

namespace Website\Middleware;

use mysql_xdevapi\Exception;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Firebase\JWT\JWT;

/**
 * Class EnvironmentMiddleware
 *
 * @package Website\Middleware
 */
class AuthenticateMiddleware implements MiddlewareInterface
{
    /**
     * Call me
     *
     * @param Micro $application
     *
     * @return bool
     */
    public function call(Micro $application)
    {
        $header = $this->getAuthorizationHeader();
        if (isset($header)) {
            $jwt = JWT::decode($header, 'demophalconkey', ['HS256']);
            if ($jwt) {
                return true;
            }
            throw new \Exception($jwt, 403);
        }
        throw new \Exception('Token is empty!', 403);

//        $di = \Phalcon\DI::getDefault();
//        $registerRoute = $di->get('namedRoute', ['admin.register']);
//        $loginRoute = $di->get('namedRoute', ['admin.login']);
//        $currentRoute = $application->router->getRewriteUri();
//
//        if (isset($_SESSION['admin_info'])) {
//            // check if login, register routes
//            // if is login or register
//            if (($currentRoute == $registerRoute) || ($currentRoute == $loginRoute)) {
//                $dashboardRoute = $di->get('namedRoute', ['admin.dashboard']);
//
//                return $di->get('response')->redirect($dashboardRoute);
//            }
//        } else {
//            if (($currentRoute != $registerRoute) && ($currentRoute != $loginRoute)) {
//                return $di->get('response')->redirect($loginRoute);
//            }
//        }
    }

    private function getAuthorizationHeader()
    {
        if (isset($_SERVER['Authorization'])) {
            return trim($_SERVER["Authorization"]);
        }

        if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            return trim($_SERVER["HTTP_AUTHORIZATION"]);
        }

        if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)),
                array_values($requestHeaders));

            if (isset($requestHeaders['Authorization'])) {
                return trim($requestHeaders['Authorization']);
            }
        }

        return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NzczMjgwNDMsInVzZXJfZW1haWwiOiJwaHVvY21pbmgxNjRAZ21haWwuY29tIn0.b9QhZcBZOq7BpVakoxwCqd6PPLof-ErVVryMVRhjruQ';
    }
}
