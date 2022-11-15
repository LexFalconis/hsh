<?php

namespace src\Controller\Error;

use src\Controller\BaseController;

/**
 * class NotFoundController
 * Controller para exibição de página de erro 404
 */
class NotFoundController extends BaseController
{
    public function index(){
        $dados = [
            'system_name' => 'Home Sweet Home',
            'titulo' => 'Erro404'
        ];
        $template = $this->twig->load('error/404.html.twig');
        echo $template->render($dados);
    }
}
