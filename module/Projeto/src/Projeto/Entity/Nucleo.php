<?php

namespace Projeto\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nucleos")
 * @ORM\Entity(repositoryClass="Projeto\Repository\Nucleo")
 */
class Nucleo {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Projeto\Entity\Projeto", inversedBy="projetos")
     * @ORM\JoinColumn(name="projeto_id", referencedColumnName="id",  nullable=false)
     */
    private $projeto;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nome;

    /**
     * @var string $telefone
     *
     * @ORM\Column(name="telefone", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $telefone;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var string $coorporativo
     *
     * @ORM\Column(name="coorporativo", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $coorporativo;

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
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $status;

    public function getId() {
        return $this->id;
    }

    public function __construct() {
        $this->created_at = new \DateTime('now');
        $this->nucleo_usuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nucleo_documento = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="\Usuario\Entity\NucleoUsuario", mappedBy="nucleo")
     */
    protected $nucleo_usuario;

    /**
     * @ORM\OneToMany(targetEntity="\Usuario\Entity\NucleoDocumento", mappedBy="nucleo")
     */
    protected $nucleo_documento;

    function getCoorporativo() {
        return $this->coorporativo;
    }

    function setCoorporativo($coorporativo) {
        $this->coorporativo = $coorporativo;
    }

    public function addNucleoUsuario(\Usuario\Entity\NucleoUsuario $NucleoUsuario) {
        $this->nucleo_usuario[] = $NucleoUsuario;

        return $this;
    }

    public function removeNucleoUsuario(\Usuario\Entity\NucleoUsuario $NucleoUsuario) {
        $this->nucleo_usuario->removeElement($NucleoUsuario);
    }

    public function getNucleoUsuario() {
        return $this->nucleo_usuario;
    }

    public function addNucleoDocumento(\Usuario\Entity\NucleoDocumento $NucleoDocumento) {
        $this->nucleo_documento[] = $NucleoDocumento;

        return $this;
    }

    public function removeNucleoDocumento(\Usuario\Entity\NucleoDocumento $NucleoDocumento) {
        $this->nucleo_documento->removeElement($NucleoDocumento);
    }

    public function getNucleoDocumento() {
        return $this->nucleo_documento;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getProjeto() {
        return $this->projeto;
    }

    function setProjeto($projeto) {
        $this->projeto = $projeto;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEmail() {
        return $this->email;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
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
        return "Núcleo";
    }

    public static function getPluralName() {
        return "Núcleos";
    }

}
