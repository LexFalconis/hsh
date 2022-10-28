<?php

require_once('vendor/autoload.php');
require_once('src/Pdo/Connection.php');
try {
    $repository = Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()
        ->addAdapter(Dotenv\Repository\Adapter\EnvConstAdapter::class)
        ->addWriter(Dotenv\Repository\Adapter\PutenvAdapter::class)
        ->immutable()
        ->make();

    $dotenv = Dotenv\Dotenv::create($repository, __DIR__);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $exception) {
    printf("%s\n", $exception->getMessage());
    die();
}

$url = \src\Auxiliary\Url::getUrl();
$template = new \src\Auxiliary\LoadTemplate();
$twig = $template->init();

$baseController = new \src\Controller\BaseController();
$baseController->setUrl($url);

$controller = $baseController->getController();
$classController = new $controller();
$classController->setTwig($twig);

$method = $baseController->getMethod($classController);
$classController->$method();
