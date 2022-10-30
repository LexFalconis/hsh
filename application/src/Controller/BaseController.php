<?php

namespace src\Controller;

use src\Auxiliary\AddSlashUrl;
use src\Auxiliary\Url;

class BaseController
{
    protected $url;
    protected $controller;
    protected $folders = ['Site', 'Error'];
    protected $twig;
    protected $pdo;

    public function __construct()
    {
        $this->pdo = \src\Pdo\Connection::getInstance();
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function addSlashUrl()
    {
        $urlSlash = new AddSlashUrl();
        return $urlSlash();
    }

    private function returnControllerMethod($explodeUrl)
    {
        if (count($explodeUrl) <= 1) {
            return ['controller' => $explodeUrl[1]];
        }

        return [
            'controller' => $explodeUrl[1],
            'method' => $explodeUrl[2]
        ];
    }

    public function controller()
    {
        if (isset($this->url) and substr_count($this->addSlashUrl(), '/') > 1) {
            $explodeUrl = explode('/', $this->url);
            unset($explodeUrl[0]);
            return $this->returnControllerMethod($explodeUrl);
        }

        return ['controller' => DEFAULT_CONTROLLER];
    }

    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    public function getController()
    {
        $this->controller = ucfirst($this->controller()['controller']) . 'Controller';

        foreach ($this->folders as $folder) {
            if (class_exists('\\src\\Controller\\' . $folder . '\\' . $this->controller)) {
                return '\\src\\Controller\\' . $folder . '\\' . $this->controller;
            }
        }

        return '\\src\\Controller\\Error\\NotFoundController';
    }

    public function getMethod($object)
    {
        if (key_exists('method', $this->controller())) {
            if (key_exists('method', $this->controller()) and method_exists($object, $this->controller()['method'])) {
                return $this->controller = $this->controller()['method'];
            }

            $_SESSION['mensagem'] = 'Método inexistente. Se vc clicou no lugar certo, reclame com o Dev.';
            header("Location:/genericError");
        }

        return $this->controller = 'index';
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function getParameter($numeroIndex)
    {
        $explodeUrl = explode('/', Url::getUrl());
        return $explodeUrl[$numeroIndex];
    }

    public function getId()
    {
        $explodeUrl = explode('/', Url::getUrl());

        foreach ($explodeUrl as $key => $parameter) {
            if ($key >= 3) {
                $explodeParameter = explode('=', $parameter);
                if (
                    $explodeParameter[0] == 'id'
                ) {
                    return intval($explodeParameter[1]);
                }
            }
        }
        return false;
    }
}
