<?php

use BM\Core\BookmarkModel;
use Slim\Http\Response as Response; 
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Goutte\Client;

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
                $crawler = $client->request('GET', $url['url']);
                $title = $crawler->filter('title')->text();
                return $response->withJson(['title' => $title]);

    });
    $app->post('/api/bookmarks', function(Request $request, Response $response) {
        $req = $request->getParsedBody();
        // $client = new Client();
        // $crawler = $client->request('GET', $req['url']);
        
        
        // if (empty($req['name'])) {

        //     $title = $crawler->filter('title')->innerText();
        //     $req = ['name' => $title, ...$req];
        // }

        $bookmarks = new BookmarkModel();
        //var_dump($req);
        
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