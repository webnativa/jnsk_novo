<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nucleo_agenda")
 * @ORM\Entity(repositoryClass="Usuario\Repository\NucleoAgenda")
 */
class NucleoAgenda {

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

    public function setAgenda(\Usuario\Entity\Agenda $Agenda = null) {
        $this->agenda = $Agenda;

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

    function getAgenda() {
        return $this->agenda;
    }

}
