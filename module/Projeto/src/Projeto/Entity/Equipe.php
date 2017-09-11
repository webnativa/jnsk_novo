<?php

namespace Projeto\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="equipe")
 * @ORM\Entity(repositoryClass="Projeto\Repository\Equipe")
 */
class Equipe {

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
     * @ORM\ManyToOne(targetEntity="\Projeto\Entity\Nucleo", inversedBy="nucleos")
     * @ORM\JoinColumn(name="nucleo_id", referencedColumnName="id",  nullable=true)
     */
    private $nucleo;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nome;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

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
     * @var string $imagem
     *
     * @ORM\Column(name="imagem", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $imagem;

    /**
     * @var boolean $coorporativo
     *
     * @ORM\Column(name="coorporativo", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $coorporativo;

    /**
     * @var boolean $mtelefone
     *
     * @ORM\Column(name="mtelefone", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $mtelefone;

    /**
     * @var boolean $memail
     *
     * @ORM\Column(name="memail", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $memail;

    public function getId() {
        return $this->id;
    }

    function getMtelefone() {
        return $this->mtelefone;
    }

    function getMemail() {
        return $this->memail;
    }

    function setMtelefone($mtelefone) {
        $this->mtelefone = $mtelefone;
    }

    function setMemail($memail) {
        $this->memail = $memail;
    }

    function getCoorporativo() {
        return $this->coorporativo;
    }

    function setCoorporativo($coorporativo) {
        $this->coorporativo = $coorporativo;
    }

    function getNucleo() {
        return $this->nucleo;
    }

    function setNucleo($nucleo) {
        $this->nucleo = $nucleo;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    public function setNome($nome) {
        $this->nome = trim($nome);
        return $this;
    }

    public function getNome() {
        return $this->nome;
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

    function getImagem() {
        return $this->imagem;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Membro";
    }

    public static function getPluralName() {
        return "Membros";
    }

}
