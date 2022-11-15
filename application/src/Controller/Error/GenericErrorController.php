<?php

namespace src\Controller\Error;

use src\Controller\BaseController;

/**
 * class GenericErrorController
 * Controller para exibição de página de erro genérica
 */
class GenericErrorController extends BaseController
{
    public function index()
    {
        $dados = [
            'system_name' => 'Home Sweet Home',
            'titulo' => 'Ocorreu um erro',
            'mensagem' => (!empty($_SESSION['mensagem'])) ? $_SESSION['mensagem'] : null
        ];
        unset($_SESSION['mensagem']);
        $template = $this->twig->load('error/generic-error.html.twig');
        echo $template->render($dados);
    }
}
