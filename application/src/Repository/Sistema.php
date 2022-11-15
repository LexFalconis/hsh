<?php

namespace src\Repository;

use PDO;
use src\Controller\Tools\WkhtmlController;

class Sistema
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retorna uma coleção de sistemas com base no status
     * @param $status
     * @return \ArrayObject
     */
    private function findAllByStatus($status)
    {
        $sistemas = (new \src\Dao\Sistema($this->pdo))->findAllByStatus($status);

        $dados = new \ArrayObject();
        foreach ($sistemas as $sistema) {
            $dados->append(
                (new \src\Entity\Sistema())
                    ->setId($sistema['id'])
                    ->setDescricao($sistema['descricao'])
                    ->setLink($sistema['link'])
                    ->setNome($sistema['nome'])
                    ->setStatus($sistema['status'])
                    ->setImagePath((new WkhtmlController())->getImagePathById($sistema['id']))
            );
        }

        return $dados;
    }

    /**
     * Retorna todos os sistemas cadastrados com status ativo
     * @return \ArrayObject
     */
    public function findAllActive()
    {
        return $this->findAllByStatus(\src\Entity\Sistema::STATUS_ATIVO);
    }

    /**
     * Retorna todos os sistemas cadastrados com status ativo
     * @return \ArrayObject
     */
    public function findAllInative()
    {
        return $this->findAllByStatus(\src\Entity\Sistema::STATUS_INATIVO);
    }

    /**
     * @param $id
     * @return \src\Entity\Sistema
     */
    public function findById($id)
    {
        $sistema = (new \src\Dao\Sistema($this->pdo))->findById($id);

        return (new \src\Entity\Sistema())
            ->setId($sistema['id'])
            ->setDescricao($sistema['descricao'])
            ->setLink($sistema['link'])
            ->setNome($sistema['nome'])
            ->setStatus($sistema['status'])
            ->setImagePath((new WkhtmlController())->getImagePathById($sistema['id']))
        ;
    }

    /**
     * @param $dados
     * @return bool|string
     */
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

    /**
     * Altera o status de um sistema para inativo
     * @param $id
     * @return bool
     */
    public function disable($id)
    {
        return (new \src\Dao\Sistema($this->pdo))->disable($id);
    }

    /**
     * Altera o status de um sistema para ativo
     * @param $id
     * @return bool
     */
    public function enable($id)
    {
        return (new \src\Dao\Sistema($this->pdo))->enable($id);
    }

    /**
     * Deleta um registro com base no id
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        return (new \src\Dao\Sistema($this->pdo))->remove($id);
    }
}
