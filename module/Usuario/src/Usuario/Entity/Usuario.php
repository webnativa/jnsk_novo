<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 * @ORM\Entity(repositoryClass="Usuario\Repository\Usuario")
 */
class Usuario {

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
     * @ORM\ManyToOne(targetEntity="\Cooperativa\Entity\Cooperativa", inversedBy="cooperativas")
     * @ORM\JoinColumn(name="cooperativa_id", referencedColumnName="id",  nullable=true)
     */
    private $cooperativa;

    /**
     * @ORM\ManyToOne(targetEntity="\Usuario\Entity\Perfil", inversedBy="perfis")
     * @ORM\JoinColumn(name="perfil_id", referencedColumnName="id",  nullable=true)
     */
    private $perfil;

    /**
     * @ORM\OneToMany(targetEntity="\Usuario\Entity\NucleoUsuario", mappedBy="usuario", cascade={"persist"})
     */
    protected $nucleo_usuario;

    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $token;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=60, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var string $senha
     *
     * @ORM\Column(name="senha", type="string", length=160, precision=0, scale=0, nullable=true, unique=false)
     */
    private $senha;

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

    const HASH = '1264bdfe5ff3215cf6abac2152fff607f7dc78dc';
    
    public function __construct() {
        $this->created_at = new \DateTime('now');
        $this->nucleo_usuario = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addNucleoUsuario(\Usuario\Entity\NucleoUsuario $nucleoUsuario) {
        $this->nucleo_usuario[] = $nucleoUsuario;

        return $this;
    }

    public function removeNucleoUsuario(\Usuario\Entity\NucleoUsuario $nucleoUsuario) {
        $this->nucleo_usuario->removeElement($nucleoUsuario);
    }

    /**

     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNucleoUsuario() {
        return $this->nucleo_usuario;
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

    public function setNome($nome) {
        $this->nome = trim($nome);
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    function getPerfil() {
        return $this->perfil;
    }

    function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    function getCooperativa() {
        return $this->cooperativa;
    }

    function setCooperativa($cooperativa) {
        $this->cooperativa = $cooperativa;
    }

    function getDataCadastro() {
        return $this->created_at->format('d/m/Y H:i');
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = strtolower($email);
    }

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    

    function getToken() {
        return $this->token;
    }

    function setToken() {
        $this->token = uniqid() . time() . md5('esaude');
    }

    function setTokenNull() {
        $this->token = null;
    }

    function getSenha() {
        return $this->senha;
    }

    public function setSenha($plaintextPassword) {

        if (empty($plaintextPassword)) {
            return $this;
        }
        $salt = $this->senha;
        $this->senha = crypt($plaintextPassword, '$5$rounds=5000$' . $salt . '$');
        return $this;
    }

    public static function hashPassword($player, $password) {
        return ($player->getSenha() === crypt($password, $player->getSenha()));
    }

    public static function getVerboseName() {
        return "Usuário";
    }

    public static function getPluralName() {
        return "Usuários";
    }

}
