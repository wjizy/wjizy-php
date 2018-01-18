<?php

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/add/{uid:\d+}/{name:\w+}', 'Index@insert');
    $r->addRoute('GET', '/update/{uid:\d+}/{id:\d+}/{name:\w+}', 'Index@update');
    $r->addRoute('GET', '/delete/{uid:\d+}/{id:\d+}', 'Index@delete');
    $r->addRoute('GET', '/select/{uid:\d+}/{id:\d+}', 'Index@select');
    $r->addRoute('GET', '/init', 'Index@init');

});

//$r->addRoute('GET', '/users', 'get_all_users_handler');
//// {id} must be a number (\d+)
//$r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//// The /{title} suffix is optional
//$r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $arr  = mbsplit('@', $handler);
        $class = 'wjizy\api\controllers\\'.$arr[0];
        $controller = new $class();
        $data = $controller->{$arr[1]}($vars);
        wjizy_json($data);
        break;
}
