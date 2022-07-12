<?php
use Slim\Http\Response as Response; 
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use BM\Core\BookmarkModel;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// This middleware will append the response header Access-Control-Allow-Methods with all allowed methods
$app->add(function (Request $request, RequestHandlerInterface $handler): Response {
    $routeContext = RouteContext::fromRequest($request);
    $routingResults = $routeContext->getRoutingResults();
    $methods = $routingResults->getAllowedMethods();
    $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');
    //var_dump($methods);
    $response = $handler->handle($request);

    $response = $response->withHeader('Access-Control-Allow-Origin', '*');
    $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
    $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);

    // Optional: Allow Ajax CORS requests with Authorization header
     $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

    return $response;
});

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/api/bookmarks', function(Request $request, Response $response) {

    $bookmarks = new BookmarkModel();
   // var_dump($bookmarks->getALL());
   return $response->withJson($bookmarks->getALL());
    //return $response;
});

$app->get('/api/bookmarks/{id}', function(Request $request, Response $response, array $args) {
    $bookmarks = new BookmarkModel();
    return $response->withJson($bookmarks->getOne($args['id']));
});


$app->post('/api/bookmarks', function(Request $request, Response $response) {
    $req = $request->getParsedBody();
    //var_dump($req);
    //return $response->withJson($req);
    $bookmarks = new BookmarkModel();
    
    $res = $bookmarks->insert($req);

    if ($res) {
        return $response->withJson("Success");
    } else {
        return $response->withJson("Error", 404);
    }
});

$app->delete('/api/bookmarks/{id}', function(Request $request, Response $response, array $args) {
    $id = $args['id'];
    $bookmarks = new BookmarkModel();
    $res = $bookmarks->deleteBookmark($id);
    if ($res) {
        return $response->withJson("Bookmark with id {$id} successfully deleted");
    } else {
        return $response->withJson("Error", 404);
    }
    
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});
$app->run();