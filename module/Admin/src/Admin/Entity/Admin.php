<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="administradores")
 * @ORM\Entity(repositoryClass="Admin\Repository\Admin")
 */
class Admin {

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
     * @ORM\Column(name="nome", type="string", length=60, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nome;

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
     * @ORM\Column(name="senha", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
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

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getSenha() {
        return $this->senha;
    }

    function _setSenha($senha) {
        $this->senha = self::HASH . sha1($senha);
    }

    public function setSenha($plaintextPassword) {
        $salt = $this->senha;
        $this->senha = crypt($plaintextPassword, '$5$rounds=5000$' . $salt . '$');
        return $this;
    }

    public static function hashPassword($player, $password) {
        return ($player->getSenha() === crypt($password, $player->getSenha()));
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

    public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Administrador";
    }

    public static function getPluralName() {
        return "Administradores";
    }

}
