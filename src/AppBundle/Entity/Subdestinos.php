<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subdestinos
 *
 * @ORM\Table(name="Subdestinos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FKSubdestino837253", columns={"destinoid"})})
 * @ORM\Entity
 */
class Subdestinos
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Destinos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Destinos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destinoid", referencedColumnName="id")
     * })
     */
    private $destinoid;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Subdestinos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

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
     * Set destinoid
     *
     * @param \AppBundle\Entity\Destinos $destinoid
     * @return Subdestinos
     */
    public function setDestinoid(\AppBundle\Entity\Destinos $destinoid = null)
    {
        $this->destinoid = $destinoid;

        return $this;
    }

    /**
     * Get destinoid
     *
     * @return \AppBundle\Entity\Destinos 
     */
    public function getDestinoid()
    {
        return $this->destinoid;
    }
}
