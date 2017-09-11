<?php

namespace Projeto\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="setores")
 * @ORM\Entity(repositoryClass="Projeto\Repository\Setor")
 */
class Setor {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nome;

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

    public function __construct() {
        $this->created_at = new \DateTime('now');
    }

    public function setNome($nome) {
        $this->nome = trim($nome);
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Núcleo";
    }

    public static function getPluralName() {
        return "Núcleos";
    }

}
