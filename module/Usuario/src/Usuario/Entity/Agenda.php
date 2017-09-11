<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="agenda")
 * @ORM\Entity(repositoryClass="Usuario\Repository\Agenda")
 */
class Agenda {

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
     * @var string $descricao
     *
     * @ORM\Column(name="descricao", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $descricao;


    /**
     * @ORM\OneToMany(targetEntity="\Usuario\Entity\NucleoAgenda", mappedBy="agenda", cascade={"persist"})
     */
    protected $nucleo_agenda;

    /**
     * @ORM\OneToMany(targetEntity="\Usuario\Entity\PerfilAgenda", mappedBy="agenda", cascade={"persist"})
     */
    protected $perfil_agenda;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @var datetime $data
     *
     * @ORM\Column(name="data", type="date", nullable=true)
     */
    private $data;

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

    /**
     * @var boolean $publico
     *
     * @ORM\Column(name="publico", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $publico;

    public function __construct() {
        $this->created_at = new \DateTime('now');
        $this->nucleo_agenda = new \Doctrine\Common\Collections\ArrayCollection();
        $this->perfil_agenda = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getPublico() {
        return $this->publico;
    }

    function setPublico($publico) {
        $this->publico = $publico;
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

    public function addNucleoAgenda(\Usuario\Entity\NucleoAgenda $NucleoAgenda) {
        $this->nucleo_agenda[] = $NucleoAgenda;

        return $this;
    }

    public function removeNucleoAgenda(\Usuario\Entity\NucleoAgenda $NucleoAgenda) {
        $this->nucleo_agenda->removeElement($NucleoAgenda);
    }

    /**

     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNucleoAgenda() {
        return $this->nucleo_agenda;
    }

    public function addPerfilAgenda(\Usuario\Entity\PerfilAgenda $PerfilAgenda) {
        $this->perfil_agenda[] = $PerfilAgenda;

        return $this;
    }

    public function removePerfilAgenda(\Usuario\Entity\PerfilAgenda $PerfilAgenda) {
        $this->perfil_agenda->removeElement($PerfilAgenda);
    }

    /**

     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerfilAgenda() {
        return $this->perfil_agenda;
    }

    function getData() {
        if (!$this->data) {
            return;
        }
        return $this->data->format('d/m/Y');
    }
    function getDia() {
        if (!$this->data) {
            return;
        }
        return $this->data->format('d');
    }
    function getMes() {
        if (!$this->data) {
            return;
        }
        return $this->data->format('m/Y');
    }

    function setData($data_uso) {

        if (is_null($data_uso)) {
            $this->data = null;
            return $this;
        }

        $data = new \DateTime($this->data('en', $data_uso));

        $this->data = $data;
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

    function getEnviado() {
        return $this->enviado;
    }

    function setEnviado($enviado) {
        $this->enviado = $enviado;
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
        return "Agenda";
    }

    public static function getPluralName() {
        return "Agenda";
    }

}
