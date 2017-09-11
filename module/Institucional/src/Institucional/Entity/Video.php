<?php

namespace Institucional\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="videos")
 * @ORM\Entity(repositoryClass="Institucional\Repository\Video")
 */
class Video {

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
    
    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = trim($nome);
        return $this;
    }
    
     public function getDataCriacao() {
        return $this->created_at->format('d/m/Y');
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    
    function getImagem() {
        return $this->imagem;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }
    
    function getTexto() {
        return $this->texto;
    }

    function setTexto($texto) {
        $this->texto = $texto;
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
        return "Vídeo";
    }

    public static function getPluralName() {
        return "Vídeos";
    }

}
