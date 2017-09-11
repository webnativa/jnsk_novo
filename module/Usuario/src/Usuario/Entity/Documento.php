<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="documentos")
 * @ORM\Entity(repositoryClass="Usuario\Repository\Documento")
 */
class Documento {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Usuario\Entity\Categoria", inversedBy="categorias")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id",  nullable=true)
     */
    private $categoria;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="\Usuario\Entity\NucleoDocumento", mappedBy="documento", cascade={"persist"})
     */
    protected $nucleo_documento;

    /**
     * @ORM\OneToMany(targetEntity="\Usuario\Entity\PerfilDocumento", mappedBy="documento", cascade={"persist"})
     */
    protected $perfil_documento;

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
     * @var boolean $enviado
     *
     * @ORM\Column(name="enviado", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $enviado;

    public function __construct() {
        $this->created_at = new \DateTime('now');
        $this->nucleo_documento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->perfil_documento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enviado = false;
    }

    public function getDataCriacao() {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * @var string $texto
     *
     * @ORM\Column(name="texto", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $texto;

    public function addNucleoDocumento(\Usuario\Entity\NucleoDocumento $NucleoDocumento) {
        $this->nucleo_documento[] = $NucleoDocumento;

        return $this;
    }

    public function removeNucleoDocumento(\Usuario\Entity\NucleoDocumento $NucleoDocumento) {
        $this->nucleo_documento->removeElement($NucleoDocumento);
    }

    /**

     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNucleoDocumento() {
        return $this->nucleo_documento;
    }

    public function addPerfilDocumento(\Usuario\Entity\PerfilDocumento $PerfilDocumento) {
        $this->perfil_documento[] = $PerfilDocumento;

        return $this;
    }

    public function removePerfilDocumento(\Usuario\Entity\PerfilDocumento $PerfilDocumento) {
        $this->perfil_documento->removeElement($PerfilDocumento);
    }

    /**

     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerfilDocumento() {
        return $this->perfil_documento;
    }

    function getEnviado() {
        return $this->enviado;
    }

    function setEnviado($enviado) {
        $this->enviado = $enviado;
    }

    function data($tipo, $date) {
        if (empty($date)) {
            return null;
        }

        if ($tipo == 'en') {
            list($dia, $mes, $ano) = explode('/', substr($date, 0, 10));
            return $ano . '-' . $mes . '-' . $dia;
        } else {
            return date('d/m/Y', strtotime($date));
        }
    }

    public function getId() {
        return $this->id;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
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

    function getDataCadastro() {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Arquivo";
    }

    public static function getPluralName() {
        return "Arquivos";
    }

}
