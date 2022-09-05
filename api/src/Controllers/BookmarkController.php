<?php

namespace BM\Controllers;

use Goutte\Client;
use BM\Model\BookmarkModel;
use BM\Services\CheckService;
use Slim\Http\Response as Response; 
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class BookmarkController extends Controller
{

    public function index(Request $request, Response $response, BookmarkModel $bookmarks):Response
    {
        $res = $bookmarks->getALL();
        if ($res) {
            return $response->withJson($res);
        } else {
            return $response->withJson('Error', 404);
        }
    }

    public function show(int $id, Request $request, Response $response, BookmarkModel $bookmarks): Response
    {
        return $response->withJson($bookmarks->getOne($id));
    }

    public function store(Request $request, Response $response, BookmarkModel $bookmarks)
    {
        $req = $request->getParsedBody();

        $validate = $this->validator->validate($req, [
            'name' => 'required|min:2',
            'url' => 'required|url',
            'category_id' => 'numeric'
        ]);
        if ($validate->fails()) {
            $errors = $validate->errors();
            return $response->withJson($errors->firstOfAll());
        }
        if ($bookmarks->isExist('bookmarks', 'url', $req['url'])) {
            return $response->withJson('Такая ссылка уже существует');
        }

        $status = new CheckService($req['url']);
        $statusCode = $status->checkUrl();
        $bookmarkInfo = $statusCode ? [...$req, 'status' => $statusCode] : [...$req, null];
        
        $res = $bookmarks->insert($bookmarkInfo, ['name', 'url', 'status', 'category_id'], [":name", ":url", ":status", ":category_id"]);
    
        if ($res) {
            return $response->withJson("Success");
        } else {
            return $response->withJson("Error", 404);
        }
    }

    public function delete(int $id, Request $request, Response $response, BookmarkModel $bookmarks)
    {
        if ($bookmarks->delete($id)) {
            return $response->withJson("Bookmark with id {$id} successfully deleted");
        } else {
            return $response->withJson("Error", 404);
        }
    }

    public function title(Request $request, Response $response)
    {
        $client = new Client();
        ['url' => $url] = $request->getParsedBody();
        if ($url) {
            $crawler = $client->request('GET', $url);
            $title = $crawler->filter('title')->text();
            return $response->withJson(['title' => $title]);
        }
        return $response->withJson('None');
    }
}