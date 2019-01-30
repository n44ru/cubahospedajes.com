<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subdestinos
 *
 * @ORM\Table(name="subdestinos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

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
     *   @ORM\JoinColumn(name="destinoid", referencedColumnName="id", onDelete="CASCADE")
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
     * Set email
     *
     * @param string $email
     * @return Subdestinos
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
