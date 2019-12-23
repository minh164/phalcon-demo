<?php

namespace Website\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

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
        $di = \Phalcon\DI::getDefault();
        $registerRoute = $di->get('namedRoute', ['admin.register']);
        $loginRoute = $di->get('namedRoute', ['admin.login']);
        $currentRoute = $application->router->getRewriteUri();

        if (isset($_SESSION['admin_info'])) {
            // check if login, register routes
            // if is login or register
            if (($currentRoute == $registerRoute) || ($currentRoute == $loginRoute)) {
                $dashboardRoute = $di->get('namedRoute', ['admin.dashboard']);

                return $di->get('response')->redirect($dashboardRoute);
            }
        } else {
            if (($currentRoute != $registerRoute) && ($currentRoute != $loginRoute)) {
                return $di->get('response')->redirect($loginRoute);
            }
        }
    }
}
