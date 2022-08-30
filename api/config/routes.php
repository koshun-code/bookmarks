<?php

use BM\Controllers\BookmarkController;
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
    $app->get('/api/bookmarks', [BookmarkController::class, 'index']);
    $app->get('/api/bookmarks/{id}', [BookmarkController::class, 'show']);
    
    //This route need to get title from site
    $app->post('/api/bookmarks/title/', [BookmarkController::class, 'title']);
    $app->post('/api/bookmarks', [BookmarkController::class, 'store']);
    
    $app->delete('/api/bookmarks/{id}', [BookmarkController::class, 'delete']);

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