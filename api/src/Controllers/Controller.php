<?php

namespace BM\Controllers;
use Rakit\Validation\Validator;
use Psr\Container\ContainerInterface;

class Controller
{
    protected $validator;
    protected ContainerInterface $container;

    public function __construct(Validator $validator, ContainerInterface $container)
    {
        $this->validator = $validator;
        $this->container = $container;
    }
}