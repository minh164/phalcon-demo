<?php

namespace Website\Bootstrap;

use Phalcon\Mvc\Application as PhApplication;
use Phalcon\Mvc\Micro\Collection as PhMicroCollection;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Session\Factory as SessionFactory;
use Phalcon\Flash\Session as FlashSession;
use Website\Helpers\RouteHelper;

/**
 * Bootstrap
 */
class Main extends AbstractBootstrap
{
    /**
     * This class is empty since all the initialization happens in the Abstract
     * class. The CLI/Test bootstrap classes will override the bootstrap
     * sequence
     */

    /**
     * Initializes the routes
     */
    protected function initRoutes()
    {
//        require APP_PATH . '/app/config/routes.php';
        $config     = $this->diContainer->getShared('config');
        $routes     = $config->get('routes')->toArray();
        $middleware = $config->get('middleware')->toArray();

        foreach ($routes as $route) {
            $collection = new PhMicroCollection();
            $collection->setHandler($route['class'], true);
            if (true !== empty($route['prefix'])) {
                $collection->setPrefix($route['prefix']);
            }

            foreach ($route['methods'] as $verb => $methods) {
                foreach ($methods as $names) {
                    foreach ($names as $endpoint => $action) {
                        $collection->$verb($endpoint, $action);
                    }
                }
            }

            $this->application->mount($collection);
        }

        $eventsManager = $this->diContainer->getShared('eventsManager');

        foreach ($middleware as $element) {
            $class = $element['class'];
            $event = $element['event'];
            $eventsManager->attach('micro', new $class());
            $this->application->$event(new $class());
        }

        $this->application->setEventsManager($eventsManager);
    }

    /**
     * init get name of routes service
     */
    protected function initNamedRoute()
        {
        $config = $this->diContainer->getShared('config');
        $routes = $config->get('routes')->toArray();

        $this->diContainer->set('namedRoute', function ($name, array $params = null) use ($routes) {
            foreach ($routes as $route) {
                foreach ($route['methods'] as $verb => $methods) {
                    foreach ($methods as $names => $endpoints) {
                        if (isset($methods[$name])) {
                            $routeName = key($methods[$name]);
                            if (isset($route['prefix'])) {
                                $routeName = $route['prefix'].$routeName;
                                if ($params != null) {
                                    foreach ($params as $param) {
                                        $routeName = preg_replace("/{[\s\S]+?}/", $param,$routeName);
                                    }
                                }
                            }
                            return $routeName; break;
                        }
                    }
                }
            }
        });
    }

    /**
     * init get route name in Volt
     */
    protected function initRouteVolt()
    {
        $this->diContainer->set('route', new RouteHelper());
    }

    /**
     * init connect database
     */
    protected function connectDB()
    {
        $this->diContainer->set('db', function () {
            $config = [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'demophalcon',
            ];
            return new \Phalcon\Db\Adapter\Pdo\Mysql($config);
        });
    }

    protected function initSession()
    {
        $this->diContainer->setShared('session', function () {
//            $options = [
//                'uniqueId'   => 'my-private-app',
//                'host'       => '127.0.0.1',
//                'port'       => 11211,
//                'persistent' => true,
//                'lifetime'   => 3600,
//                'prefix'     => 'demo_',
//                'adapter'    => 'memcache',
//            ];
//            $session = SessionFactory::load($options);
            $session = new Session();
            $session->start();

            return $session;
        });
    }

    protected function initFlashSession()
    {
        $this->diContainer->getShared('session');
        $this->diContainer->setShared('flash', function () {
            $flash = new FlashSession([
                'error' => '',
                'success' => '',
                'notice' => 'alert alert-info',
            ]);

            return $flash;
        });
    }

    /**
     * Runs the main application
     *
     * @return PhApplication
     */
    protected function runApplication()
    {
        $this->connectDB();
        $this->initNamedRoute();
        $this->initSession();
        $this->initFlashSession();
        $this->initRouteVolt();

        $this->application->handle();
    }
}
