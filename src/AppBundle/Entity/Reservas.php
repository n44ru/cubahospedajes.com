<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservas
 *
 * @ORM\Table(name="reservas", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FKReservas613800", columns={"Casaid"})})
 * @ORM\Entity
 */
class Reservas
{
    /**
     * @var string
     *
     * @ORM\Column(name="fechallegada", type="string", length=255, nullable=true)
     */
    private $fechallegada;

    /**
     * @var integer
     *
     * @ORM\Column(name="fechasalida", type="integer", nullable=true)
     */
    private $fechasalida;

    /**
     * @var string
     *
     * @ORM\Column(name="horallegada", type="string", length=255, nullable=true)
     */
    private $horallegada;

    /**
     * @var string
     *
     * @ORM\Column(name="horasalida", type="string", length=255, nullable=true)
     */
    private $horasalida;

    /**
     * @var integer
     *
     * @ORM\Column(name="adultos", type="integer", nullable=true)
     */
    private $adultos;

    /**
     * @var integer
     *
     * @ORM\Column(name="ninos", type="integer", nullable=true)
     */
    private $ninos;

    /**
     * @var integer
     *
     * @ORM\Column(name="bebes", type="integer", nullable=true)
     */
    private $bebes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * Set fechallegada
     *
     * @param string $fechallegada
     * @return Reservas
     */
    public function setFechallegada($fechallegada)
    {
        $this->fechallegada = $fechallegada;

        return $this;
    }

    /**
     * Get fechallegada
     *
     * @return string 
     */
    public function getFechallegada()
    {
        return $this->fechallegada;
    }

    /**
     * Set fechasalida
     *
     * @param integer $fechasalida
     * @return Reservas
     */
    public function setFechasalida($fechasalida)
    {
        $this->fechasalida = $fechasalida;

        return $this;
    }

    /**
     * Get fechasalida
     *
     * @return integer 
     */
    public function getFechasalida()
    {
        return $this->fechasalida;
    }

    /**
     * Set horallegada
     *
     * @param string $horallegada
     * @return Reservas
     */
    public function setHorallegada($horallegada)
    {
        $this->horallegada = $horallegada;

        return $this;
    }

    /**
     * Get horallegada
     *
     * @return string 
     */
    public function getHorallegada()
    {
        return $this->horallegada;
    }

    /**
     * Set horasalida
     *
     * @param string $horasalida
     * @return Reservas
     */
    public function setHorasalida($horasalida)
    {
        $this->horasalida = $horasalida;

        return $this;
    }

    /**
     * Get horasalida
     *
     * @return string 
     */
    public function getHorasalida()
    {
        return $this->horasalida;
    }

    /**
     * Set adultos
     *
     * @param integer $adultos
     * @return Reservas
     */
    public function setAdultos($adultos)
    {
        $this->adultos = $adultos;

        return $this;
    }

    /**
     * Get adultos
     *
     * @return integer 
     */
    public function getAdultos()
    {
        return $this->adultos;
    }

    /**
     * Set ninos
     *
     * @param integer $ninos
     * @return Reservas
     */
    public function setNinos($ninos)
    {
        $this->ninos = $ninos;

        return $this;
    }

    /**
     * Get ninos
     *
     * @return integer 
     */
    public function getNinos()
    {
        return $this->ninos;
    }

    /**
     * Set bebes
     *
     * @param integer $bebes
     * @return Reservas
     */
    public function setBebes($bebes)
    {
        $this->bebes = $bebes;

        return $this;
    }

    /**
     * Get bebes
     *
     * @return integer 
     */
    public function getBebes()
    {
        return $this->bebes;
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
     * Set casaid
     *
     * @param \AppBundle\Entity\Casa $casaid
     * @return Reservas
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
