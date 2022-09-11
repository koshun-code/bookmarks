<?php

namespace BM\Controllers;

use Slim\Http\Response as Response; 
use BM\Core\Auth;

class LogoutController extends Controller
{
    public function logout(Response $response, Auth $auth)
    {
        if($auth->logout()) {
            return $response->withJson(['message' => 'success']);
        }
        return $response->withJson(['message' => 'Позольватель не авторизован']);
    }   
}