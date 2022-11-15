<?php

namespace src\Controller\Site;

use src\Controller\BaseController;
use src\Repository\Sistema;

/**
 * class HomeController
 * Controller responsável pela tela principal do sistema
 */
class HomeController extends BaseController
{
    public function index()
    {
        $sistemas = (new Sistema($this->getPdo()))->findAllActive();
        $mensagem = null;
        if($sistemas->count() == 0) {
            $mensagem = "
                Hummmm, ainda não temos nenhum link/sistema cadastrado.
                Clica ali no botão do lado superior direito para cadastrar nosso primeiro sistema.
            ";
        }
        $dados = [
            'mensagem' => $mensagem,
            'system_name' => 'Home Sweet Home',
            'titulo' => 'Home',
            'sistemas' => $sistemas
        ];
        $template = $this->twig->load('home.html.twig');
        echo $template->render($dados);
    }
}
