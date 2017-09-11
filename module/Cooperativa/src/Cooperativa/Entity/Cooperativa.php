<?php

namespace Cooperativa\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cooperativas")
 * @ORM\Entity(repositoryClass="Cooperativa\Repository\Cooperativa")
 */
class Cooperativa {

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
     * @ORM\ManyToOne(targetEntity="\Cooperativa\Entity\Regiao", inversedBy="regioes")
     * @ORM\JoinColumn(name="regiao_id", referencedColumnName="id",  nullable=true)
     */
    private $regiao;
     

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nome;

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
     * @var string $catalogo
     *
     * @ORM\Column(name="catalogo", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $catalogo;


    /**
     * @var string $endereco
     *
     * @ORM\Column(name="endereco", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $endereco;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $status;
    
    public function getId() {
        return $this->id;
    }
    
    function getRegiao() {
        return $this->regiao;
    }

    function setRegiao($regiao) {
        $this->regiao = $regiao;
    }
    function getEndereco() {
        return $this->endereco;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function getCatalogo() {
        return $this->catalogo;
    }

    function setCatalogo($catalogo) {
        $this->catalogo = $catalogo;
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
        return "Cooperativa";
    }

    public static function getPluralName() {
        return "Cooperativas";
    }

}
