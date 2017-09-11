<?php

namespace Marketing\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="newsLetter")
 * @ORM\Entity(repositoryClass="Marketing\Repository\NewsLetter")
 */
class NewsLetter {

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
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=60, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

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
     * @var string $telefone
     *
     * @ORM\Column(name="telefone", type="string", length=60, precision=0, scale=0, nullable=true, unique=false)
     */
    private $telefone;
    
    public function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
    
    function getTelefone(){
        return $this->telefone;
    }

    function setTelefone($val){
        $this->telefone = $val;
    }

    function getCreatedAt() {
        return $this->created_at->format('d/m/Y H:i:s');
    }

        public function setDataCancelamento() {
        $this->data_cancelamento = new \DateTime('now');
    }

    public static function getVerboseName() {
        return "Newsletter";
    }

    public static function getPluralName() {
        return "Newsletter";
    }

}
