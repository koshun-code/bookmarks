<?php

use BM\Core\BookmarkModel;
use Slim\Http\Response as Response; 
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


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
};

/**
 * End routes
 */