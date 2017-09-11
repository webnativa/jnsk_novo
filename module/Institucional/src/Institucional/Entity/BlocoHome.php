<?php

namespace Institucional\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blocos_home")
 * @ORM\Entity(repositoryClass="Institucional\Repository\BlocoHome")
 */
class BlocoHome {

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
     * @var string $link
     *
     * @ORM\Column(name="link", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $link;

    /**
     * @var string $imagem
     *
     * @ORM\Column(name="imagem", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $imagem;

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

    function getDescricao() {
        return $this->descricao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getLink() {
        return $this->link;
    }

    function getImagem() {
        return $this->imagem;
    }

    function setLink($link) {
        $this->link = $link;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public static function getVerboseName() {
        return "Bloco Página Principal";
    }

    public static function getPluralName() {
        return "Blocos Página Principal";
    }

}
