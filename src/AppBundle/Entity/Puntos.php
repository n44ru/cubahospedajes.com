<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Puntos
 *
 * @ORM\Table(name="Puntos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FKPuntos960715", columns={"Subdestinosid"})})
 * @ORM\Entity
 */
class Puntos
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
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="string", length=255, nullable=true)
     */
    private $texto;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Subdestinos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Subdestinos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Subdestinosid", referencedColumnName="id")
     * })
     */
    private $subdestinosid;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Puntos
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
     * Set direccion
     *
     * @param string $direccion
     * @return Puntos
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Puntos
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
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
     * Set subdestinosid
     *
     * @param \AppBundle\Entity\Subdestinos $subdestinosid
     * @return Puntos
     */
    public function setSubdestinosid(\AppBundle\Entity\Subdestinos $subdestinosid = null)
    {
        $this->subdestinosid = $subdestinosid;

        return $this;
    }

    /**
     * Get subdestinosid
     *
     * @return \AppBundle\Entity\Subdestinos 
     */
    public function getSubdestinosid()
    {
        return $this->subdestinosid;
    }
}
