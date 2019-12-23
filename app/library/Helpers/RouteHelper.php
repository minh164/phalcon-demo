<?php

namespace Website\Helpers;

class RouteHelper
{
    public function getUri($route, ...$params)
    {
        $di = \Phalcon\DI::getDefault();
        $uri = $di->get('namedRoute', [$route, $params]);
        return $uri;
    }
}