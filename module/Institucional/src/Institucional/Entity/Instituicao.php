<?php

namespace Institucional\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="instituicao")
 * @ORM\Entity(repositoryClass="Institucional\Repository\Instituicao")
 */
class Instituicao {

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

    public function getId() {
        return $this->id;
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

    public static function getVerboseName() {
        return "Páginas Institucional";
    }

    public static function getPluralName() {
        return "Páginas Institucionais";
    }

}
