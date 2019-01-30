<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CasaEtiqueta
 *
 * @ORM\Table(name="Casa_Etiqueta", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FKCasa_Etiqu10414", columns={"Casaid"}), @ORM\Index(name="FKCasa_Etiqu730566", columns={"Etiquetasid"})})
 * @ORM\Entity
 */
class CasaEtiqueta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Etiquetas
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Etiquetas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Etiquetasid", referencedColumnName="id")
     * })
     */
    private $etiquetasid;

    /**
     * @var \AppBundle\Entity\Casa
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Casa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Casaid", referencedColumnName="id")
     * })
     */
    private $casaid;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set etiquetasid
     *
     * @param \AppBundle\Entity\Etiquetas $etiquetasid
     * @return CasaEtiqueta
     */
    public function setEtiquetasid(\AppBundle\Entity\Etiquetas $etiquetasid = null)
    {
        $this->etiquetasid = $etiquetasid;

        return $this;
    }

    /**
     * Get etiquetasid
     *
     * @return \AppBundle\Entity\Etiquetas 
     */
    public function getEtiquetasid()
    {
        return $this->etiquetasid;
    }

    /**
     * Set casaid
     *
     * @param \AppBundle\Entity\Casa $casaid
     * @return CasaEtiqueta
     */
    public function setCasaid(\AppBundle\Entity\Casa $casaid = null)
    {
        $this->casaid = $casaid;

        return $this;
    }

    /**
     * Get casaid
     *
     * @return \AppBundle\Entity\Casa 
     */
    public function getCasaid()
    {
        return $this->casaid;
    }
}
