<?php

namespace BM\Controllers;

use Slim\Http\Response as Response; 
use Psr\Http\Message\ServerRequestInterface as Request;
use BM\Core\Auth;


class RegisterController extends Controller
{
    public function register(Request $request, Response $response, Auth $auth)
    {
        $user = $request->getParsedBody();
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'];

        $valid = $this->validator->make($user, $rules);

        if ( ! $valid->fails()) {
            
            if ($auth->isExist('users', 'name', $user['name'])) {
                return $response->withJson(['message' => 'Такой пользователь уже зарегестрирован'], 208);
            }

            $authUser = $auth->register($user);

            if ($authUser) {
                return $response->withJson(['message' => 'Пользователь успешно зарегистрирован'], 201);
            } else {
                return $response->withJson(['message' => 'Не удалось зарегистрировать. Проверте данные'], 203);
            }
        } else {
            return $response->withJson(['message' => $valid->errors()], 204);
        }
    }
}