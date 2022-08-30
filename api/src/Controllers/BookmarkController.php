<?php

namespace BM\Controllers;

use Goutte\Client;
use BM\Model\BookmarkModel;
use BM\Services\CheckService;
use Slim\Http\Response as Response; 
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class BookmarkController
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response):Response
    {
        $bookmarks = new BookmarkModel();
        $res = $bookmarks->getALL();
        if ($res) {
            return $response->withJson($res);
        } else {
            return $response->withJson('Error', 404);
        }
    }

    public function show(int $id, Request $request, Response $response): Response
    {
        $bookmarks = new BookmarkModel();
        return $response->withJson($bookmarks->getOne($id));
    }

    public function store(Request $request, Response $response)
    {
        $req = $request->getParsedBody();
        $status = new CheckService($req['url']);
        $statusCode = $status->checkUrl();
        $bookmarks = new BookmarkModel();
        $bookmarkInfo = $statusCode ? [...$req, 'status' => $statusCode] : [...$req, null];
        //var_dump($bookmarkInfo);
        
        $res = $bookmarks->insert($bookmarkInfo, ['name', 'url', 'status', 'category_id'], [":name", ":url", ":status", ":category_id"]);
    
        if ($res) {
            return $response->withJson("Success");
        } else {
            return $response->withJson("Error", 404);
        }
    }

    public function delete(int $id, Request $request, Response $response)
    {
        $bookmarks = new BookmarkModel();
        $res = $bookmarks->delete($id);
        if ($res) {
            return $response->withJson("Bookmark with id {$id} successfully deleted");
        } else {
            return $response->withJson("Error", 404);
        }
    }

    public function title(Request $request, Response $response)
    {
        $client = new Client();
        $url = $request->getParsedBody();
        if ($url) {
            $crawler = $client->request('GET', $url['url']);
            $title = $crawler->filter('title')->text();
            return $response->withJson(['title' => $title]);
        }
        return $response->withJson('None');
    }
}