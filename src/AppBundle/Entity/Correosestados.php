<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Correosestados
 *
 * @ORM\Table(name="correosestados", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Correosestados
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
     * @var \AppBundle\Entity\Estados
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estadosid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $estadosid;

    /**
     * @var \AppBundle\Entity\Correos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Correos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="correosid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $correosid;



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
     * Set estadosid
     *
     * @param \AppBundle\Entity\Estados $estadosid
     * @return Correosestados
     */
    public function setEstadosid(\AppBundle\Entity\Estados $estadosid = null)
    {
        $this->estadosid = $estadosid;

        return $this;
    }

    /**
     * Get estadosid
     *
     * @return \AppBundle\Entity\Estados 
     */
    public function getEstadosid()
    {
        return $this->estadosid;
    }

    /**
     * Set correosid
     *
     * @param \AppBundle\Entity\Correos $correosid
     * @return Correosestados
     */
    public function setCorreosid(\AppBundle\Entity\Correos $correosid = null)
    {
        $this->correosid = $correosid;

        return $this;
    }

    /**
     * Get correosid
     *
     * @return \AppBundle\Entity\Correos 
     */
    public function getCorreosid()
    {
        return $this->correosid;
    }
}
