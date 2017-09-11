<?php

namespace Projeto\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="projetos")
 * @ORM\Entity(repositoryClass="Projeto\Repository\Projeto")
 */
class Projeto {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->created_at = new \DateTime('now');
    }

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nome;

    /**
     * @var string $descricao
     *
     * @ORM\Column(name="descricao", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $descricao;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $slug;

    /**
     * @var string $cor
     *
     * @ORM\Column(name="cor", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $cor;

    /**
     * @var string $texto
     *
     * @ORM\Column(name="texto", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $texto;

    /**
     * @var string $posicao
     *
     * @ORM\Column(name="posicao", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $posicao;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @var date $data_cancelamento
     *
     * @ORM\Column(name="data_cancelamento", type="datetime", nullable=true)
     */
    private $data_cancelamento;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $status;

    public function getId() {
        return $this->id;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    public function setNome($nome) {
        $this->nome = trim($nome);
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    function getCor() {
        return $this->cor;
    }

    function setCor($cor) {
        $this->cor = $cor;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getTexto() {
        return $this->texto;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }

    function getPosicao() {
        return $this->posicao;
    }

    function setPosicao($posicao) {
        $this->posicao = $posicao;
    }

    function getSlug() {
        return $this->slug;
    }

    function setSlug($slug) {
        $this->slug = $slug;
    }

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Projeto";
    }

    public static function getPluralName() {
        return "Projetos";
    }

}
