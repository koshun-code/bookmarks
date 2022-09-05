<?php

namespace BM\Controllers;

use BM\Model\CategoryModel;
use BM\Controllers\Controller;
use Slim\Http\Response as Response; 
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Rakit\Validation\Validator;

class CategoryController extends Controller
{
    public function index(Request $request, Response $response, CategoryModel $category)
    {
        $categoris = $category->getALL("category");
        if ($categoris) {
            return $response->withJson($categoris);
        }
        return $response->withJson('Category not exist');
    }

    public function store(Request $request, Response $response, CategoryModel $category)
    {
        $validation = $this->validator->validate($request->getParsedBody(), [
            'category_name' => 'required|min:2'
        ]);

        if (!$validation->fails()) {
            $exist = $category->isExist('category', 'category_name', $request->getParsedBody()['category_name']);

            if ($exist) {
                return $response->withJson(['error' => 'Такая категория уже существует']);
            }

            $insert = $category->insert($request->getParsedBody(), ['category_name'], [":category_name"], 'category');
            return $response->withJson($insert);
        } else {
            $errors = $validation->errors();
            return $response->withJson($errors->firstOfAll());
        }
    }
    
    public function categoryBookmark(int $id, Request $request, Response $response, CategoryModel $category)
    {
        return $response->withJson($category->getBookmarksByCategory($id));
    }
}