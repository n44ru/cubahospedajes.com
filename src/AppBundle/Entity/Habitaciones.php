<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habitaciones
 *
 * @ORM\Table(name="Habitaciones", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FKHabitacion891968", columns={"Casaid"})})
 * @ORM\Entity
 */
class Habitaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="capacidad", type="integer", nullable=true)
     */
    private $capacidad;

    /**
     * @var string
     *
     * @ORM\Column(name="ocupada", type="string", length=2, nullable=true)
     */
    private $ocupada;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=true)
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="activa", type="string", length=2, nullable=true)
     */
    private $activa;

    /**
     * @var integer
     *
     * @ORM\Column(name="camas", type="integer", nullable=true)
     */
    private $camas;

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
     * Set capacidad
     *
     * @param integer $capacidad
     * @return Habitaciones
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer 
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set ocupada
     *
     * @param string $ocupada
     * @return Habitaciones
     */
    public function setOcupada($ocupada)
    {
        $this->ocupada = $ocupada;

        return $this;
    }

    /**
     * Get ocupada
     *
     * @return string 
     */
    public function getOcupada()
    {
        return $this->ocupada;
    }

    /**
     * Set precio
     *
     * @param float $precio
     * @return Habitaciones
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set activa
     *
     * @param string $activa
     * @return Habitaciones
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return string 
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Set camas
     *
     * @param integer $camas
     * @return Habitaciones
     */
    public function setCamas($camas)
    {
        $this->camas = $camas;

        return $this;
    }

    /**
     * Get camas
     *
     * @return integer 
     */
    public function getCamas()
    {
        return $this->camas;
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
     * @return Habitaciones
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
