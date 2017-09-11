<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="perfil_agenda")
 * @ORM\Entity(repositoryClass="Usuario\Repository\PerfilAgenda")
 */
class PerfilAgenda {

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
     * @ORM\ManyToOne(targetEntity="\Usuario\Entity\Agenda", inversedBy="nucleo_agenda", cascade={"persist"})
     * @ORM\JoinColumn(name="agenda_id", referencedColumnName="id")
     *
     */
    private $agenda;

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

    public function setAgenda(\Usuario\Entity\Agenda $Agenda = null) {
        $this->agenda = $Agenda;

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

    function getAgenda() {
        return $this->agenda;
    }

}
