<?php

namespace Marketing\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="banners")
 * @ORM\Entity(repositoryClass="Marketing\Repository\Banner")
 */
class Banner {

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
     * @var string $link
     *
     * @ORM\Column(name="link", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $link;

    /**
     * @var string $arquivo
     *
     * @ORM\Column(name="arquivo", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $arquivo;

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

    function getNome() {
        return $this->nome;
    }

    function getLink() {
        return $this->link;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setLink($link) {
        $this->link = $link;
    }
    
    function getArquivo() {
        return $this->arquivo;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

        
    function getCreatedAt() {
        return $this->created_at->format('d/m/Y H:i:s');
    }

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Banner";
    }

    public static function getPluralName() {
        return "Banners";
    }

}
