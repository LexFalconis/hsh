<?php

namespace src\Controller\Error;

use src\Controller\BaseController;

class GenericErrorController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Ocorreu um erro',
            'mensagem' => (!empty($_SESSION['mensagem'])) ? $_SESSION['mensagem'] : null
        ];
        unset($_SESSION['mensagem']);
        $template = $this->twig->loadTemplate('error/generic-error.html.twig');
        echo $template->display($dados);
    }
}
