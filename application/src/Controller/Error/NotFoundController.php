<?php

namespace src\Controller\Error;

use src\Controller\BaseController;

class NotFoundController extends BaseController
{
    public function index(){
        $dados = [
            'titulo' => 'Erro404'
        ];
        $template = $this->twig->load('error/404.html.twig');
        echo $template->render($dados);
    }
}