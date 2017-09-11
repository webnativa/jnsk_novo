<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="perfil_documento")
 * @ORM\Entity(repositoryClass="Usuario\Repository\PerfilDocumento")
 */
class PerfilDocumento {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\Usuario\Entity\Documento", inversedBy="nucleo_documento", cascade={"persist"})
     * @ORM\JoinColumn(name="documento_id", referencedColumnName="id")
     *
     */
    private $documento;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\Usuario\Entity\Perfil", inversedBy="perfil_usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="perfil_id", referencedColumnName="id")
     */
    private $perfil;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function setDocumento(\Usuario\Entity\Documento $Documento = null) {
        $this->documento = $Documento;

        return $this;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setPerfil(\Usuario\Entity\Perfil $perfil = null) {
        $this->perfil = $perfil;

        return $this;
    }

    public function getPerfil() {
        return $this->perfil;
    }

    function getDocumento() {
        return $this->documento;
    }

}
