<?php

namespace BM\Core;

class Password
{
    public static function makeHash(string $string, string | int | null $algoritm = PASSWORD_BCRYPT, array $options = [] )
    {
        return password_hash($string,  $algoritm, $options);
    }
    public static function verify(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }
}