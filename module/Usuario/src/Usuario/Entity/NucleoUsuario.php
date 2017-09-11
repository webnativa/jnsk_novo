<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nucleo_usuario")
 * @ORM\Entity(repositoryClass="Usuario\Repository\NucleoUsuario")
 */
class NucleoUsuario {

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
     * @ORM\ManyToOne(targetEntity="\Usuario\Entity\Usuario", inversedBy="nucleo_usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     *
     */
    private $usuario;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\Projeto\Entity\Nucleo", inversedBy="nucleo_usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="nucleo_id", referencedColumnName="id")
     */
    private $nucleo;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function setUsuario(\Usuario\Entity\Usuario $usuario = null) {
        $this->usuario = $usuario;

        return $this;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setNucleo(\Projeto\Entity\Nucleo $nucleo = null) {
        $this->nucleo = $nucleo;

        return $this;
    }

    public function getNucleo() {
        return $this->nucleo;
    }

}
