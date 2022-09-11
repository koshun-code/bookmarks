<?php

use BM\Controllers\BookmarkController;
use BM\Controllers\CategoryController;
use BM\Controllers\LoginController;
use BM\Controllers\LogoutController;
use BM\Controllers\RegisterController;
use BM\Controllers\UserController;
use Slim\App;
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
    /**
     * Routes for login, logout, registration
     */
    $app->group('/api/user', function(RouteCollectorProxy $group) {
        $group->post('/login', [LoginController::class, 'login']);
        $group->post('/logout', [LogoutController::class, 'logout']);
        $group->post('/register', [RegisterController::class, 'register']);
    });
};

/**
 * End routes
 */