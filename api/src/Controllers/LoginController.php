<?php

namespace BM\Controllers;

use BM\Model\UserModel;
use Slim\Http\Response as Response; 
use Psr\Http\Message\ServerRequestInterface as Request;
use BM\Core\Auth;

class LoginController extends Controller
{
    public function login(Request $request, Response $response, Auth $auth)
    {
       $validate = $this->validator->validate($request->getParsedBody(), [
            'username' => 'required|min:2',
            'password' => 'required'
        ]);
        if ( ! $validate->fails()) {
            $username = $request->getParsedBody()['username'];
            $password = $request->getParsedBody()['password'];
            if ($auth->login($username, $password)) {
                return $response->withJson($username);
            } else {
                return $response->withJson(['error' => 'Вход невозможен. Такого пользователя не существует']);
            }
        } else {
            return $response->withJson(['error' => 'Неверный Логин или Пароль']);
        }
    }
}