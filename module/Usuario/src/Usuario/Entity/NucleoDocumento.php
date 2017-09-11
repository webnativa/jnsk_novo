<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nucleo_documento")
 * @ORM\Entity(repositoryClass="Usuario\Repository\NucleoDocumento")
 */
class NucleoDocumento {

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

    public function setDocumento(\Usuario\Entity\Documento $Documento = null) {
        $this->documento = $Documento;

        return $this;
    }

    public function setNucleo(\Projeto\Entity\Nucleo $nucleo = null) {
        $this->nucleo = $nucleo;

        return $this;
    }

    public function getNucleo() {
        return $this->nucleo;
    }

    function getDocumento() {
        return $this->documento;
    }

}
