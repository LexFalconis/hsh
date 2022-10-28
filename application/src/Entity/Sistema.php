<?php

namespace src\Entity;

class Sistema
{
    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;
    const STATUS_ATIVO_LABEL = 'Ativo';
    const STATUS_INATIVO_LABEL = "Inativo";

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Sistema
     */
    public function setId(int $id): Sistema
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Sistema
     */
    public function setNome(string $nome): Sistema
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Sistema
     */
    public function setLink(string $link): Sistema
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return Sistema
     */
    public function setDescricao(string $descricao): Sistema
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusToHuman(): string
    {
        $status = self::STATUS_ATIVO_LABEL;
        if ($this->getStatus() === false) {
            $status = self::STATUS_INATIVO_LABEL;
        }
        return $status;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return Sistema
     */
    public function setStatus(bool $status): Sistema
    {
        $this->status = $status;
        return $this;
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ATIVO => self::STATUS_ATIVO_LABEL,
            self::STATUS_INATIVO => self::STATUS_INATIVO_LABEL
        ];
    }
}
