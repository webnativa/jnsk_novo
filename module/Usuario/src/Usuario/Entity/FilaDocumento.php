<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fila_documentos")
 * @ORM\Entity(repositoryClass="Usuario\Repository\FilaDocumento")
 */
class FilaDocumento {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Usuario\Entity\Usuario", inversedBy="usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id",  nullable=false)
     */
    private $usuario;

    /**
     * @var string $documento
     *
     * @ORM\Column(name="documento", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $documento;

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

    /**
     * @var datetime $data_envio
     *
     * @ORM\Column(name="data_envio", type="datetime", nullable=true)
     */
    private $data_envio;

    public function __construct() {
        $this->created_at = new \DateTime('now');
        $this->enviado = false;
    }

    public function setDataEnvio() {
        $this->data_envio = new \DateTime('now');
    }
    
    function getUsuario() {
        return $this->usuario;
    }
    
    function getEnviado() {
        return $this->enviado;
    }

    function setEnviado($enviado) {
        $this->enviado = $enviado;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function getDocumento() {
        return $this->documento;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    public function getDataCriacao() {
        return $this->created_at->format('d/m/Y');
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

    function getDataCadastro() {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Fila Documento";
    }

    public static function getPluralName() {
        return "Fila Documento";
    }

}
