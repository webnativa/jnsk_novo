<?php

namespace Cooperativa\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="regioes")
 * @ORM\Entity(repositoryClass="Cooperativa\Repository\Regiao")
 */
class Regiao {

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
     * @var date $data_cancelamento
     *
     * @ORM\Column(name="data_cancelamento", type="datetime", nullable=true)
     */
     private $data_cancelamento;

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
        return "Região";
    }

    public static function getPluralName() {
        return "Regiões";
    }

}
