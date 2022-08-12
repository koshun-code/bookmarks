<?php

use BM\Model\BookmarkModel;
use BM\Model\CategoryModel;
use BM\Services\CheckService;
use Slim\Http\Response as Response; 
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Goutte\Client;
use Slim\Routing\RouteCollectorProxy;

/**
 * Routes
 */

return function (App $app) {
    $app->get('/api/bookmarks', function(Request $request, Response $response) {

        $bookmarks = new BookmarkModel();
       // var_dump($bookmarks->getALL());
        $res = $bookmarks->getALL();
        if ($res) {
            return $response->withJson($res);
        } else {
            return $response->withJson('Error', 404);
        }
       
        //return $response;
    });
    
    $app->get('/api/bookmarks/{id}', function(Request $request, Response $response, array $args) {
        $bookmarks = new BookmarkModel();
        return $response->withJson($bookmarks->getOne($args['id']));
    });
    
    //This route need to get title from site
    $app->post('/api/bookmarks/title/', function(Request $request, Response $response) {
                $client = new Client();
                $url = $request->getParsedBody();
                if ($url) {
                    $crawler = $client->request('GET', $url['url']);
                    $title = $crawler->filter('title')->text();
                    return $response->withJson(['title' => $title]);
                }
                return $response->withJson('error', 404);


    });
    $app->post('/api/bookmarks', function(Request $request, Response $response) {
        $req = $request->getParsedBody();
        $status = new CheckService($req['url']);
        $statusCode = $status->checkUrl();
        $bookmarks = new BookmarkModel();
        $bookmarkInfo = $statusCode ? [...$req, 'status' => $statusCode] : [...$req, null];
        //var_dump($bookmarkInfo);
        
        $res = $bookmarks->insert($bookmarkInfo, ['name', 'url', 'status'], [":name", ":url", ":status"]);
    
        if ($res) {
            return $response->withJson("Success");
        } else {
            return $response->withJson("Error", 404);
        }
    });
    
    $app->delete('/api/bookmarks/{id}', function(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $bookmarks = new BookmarkModel();
        $res = $bookmarks->delete($id);
        if ($res) {
            return $response->withJson("Bookmark with id {$id} successfully deleted");
        } else {
            return $response->withJson("Error", 404);
        }
        
    });

    /**
     * This routes work with category
     */
    $app->group('/api/category', function(RouteCollectorProxy $group){
        $group->get('/give', function(Request $request, Response $response, $args) {
            ////
            $category = new CategoryModel();
            $categoris = $category->getALL("category");
            if ($categoris) {
                return $response->withJson($categoris);
            }
            return $response->withJson('Category not exist');
        });
        $group->post('/send', function(Request $request, Response $response, $args) {
            $category = new CategoryModel();
            ['category_name' => $categoryName] = $request->getParsedBody();
           // return $response->withJson();
            $insert = $category->insert(['category_name' => $categoryName], ['category_name'], [":category_name"], 'category');
            if ($insert) {
                return $response->withJson($insert);
            }
            return $response->withJson('cant insert data');
        });
    });
};

/**
 * End routes
 */