<?php

use BM\Controllers\BookmarkController;
use BM\Controllers\CategoryController;
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
        $group->get('/give', [CategoryController::class, 'index']);
        $group->post('/send', [CategoryController::class, 'store']);
        $group->get('/{id}/bookmarks', [CategoryController::class, 'categoryBookmark']);
    });
};

/**
 * End routes
 */