<?php

namespace src\Repository;

use PDO;

class Sistema
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllActive()
    {
        $sistemas = (new \src\Dao\Sistema($this->pdo))->findAllActive();

        $dados = new \ArrayObject();
        foreach ($sistemas as $sistema) {
            $dados->append(
                (new \src\Entity\Sistema())
                    ->setId($sistema['id'])
                    ->setDescricao($sistema['descricao'])
                    ->setLink($sistema['link'])
                    ->setNome($sistema['nome'])
                    ->setStatus($sistema['status'])
            );
        }

        return $dados;
    }

    public function findById($id)
    {
        $sistema = (new \src\Dao\Sistema($this->pdo))->findById($id);

        return (new \src\Entity\Sistema())
            ->setId($sistema['id'])
            ->setDescricao($sistema['descricao'])
            ->setLink($sistema['link'])
            ->setNome($sistema['nome'])
            ->setStatus($sistema['status'])
        ;
    }

    public function persist($dados)
    {
        if (
            empty($dados['nome']) || is_null($dados['nome']) ||
            empty($dados['link']) || is_null($dados['link']) ||
            empty($dados['descricao']) || is_null($dados['descricao'])
        ) {
            throw new \DomainException('Os itens Nome, Link e Descrição precisam estar preenchidos.');
        }

        return (new \src\Dao\Sistema($this->pdo))->persist($dados);
    }

    public function remove($id)
    {
        return (new \src\Dao\Sistema($this->pdo))->remove($id);
    }
}
