<?php

namespace BM\Core;

use BM\Model\UserModel;
use BM\Core\Password;

class Auth extends UserModel
{
    /**
     * $username : string
     * $password : string
     * return bool
     * This method take a user password from DB
     */
    public function login(string $username, string $password): bool
    {
        $passwordHash = $this->find([$username], ['password'], 'name', 'users'); //

        if ($this->isExist('users', 'name', $username) && Password::verify($password, $passwordHash['password'])) { //
            session_start();
            $_SESSION['username'] = $username;
            setcookie('username', $username, strtotime('+30 days'));
            return true;
        }
        return false;
    }
    public function register(array $user) : bool
    {
        $user = [...$user, 'password' => Password::makeHash($user['password'])];
        
        $id = $this->insert($user, ['name', 'email', 'password'], 'users');
        if ($id) {
            return true;
        }
        return false;
    }
    public function logout(): bool
    {
        session_start();
        if (!empty($_SESSION['username']) && !empty($_COOKIE['username'])) {
            session_destroy();
            setcookie('username', '', time() - 3600);
            return true;
        }
        return false;
    }
}