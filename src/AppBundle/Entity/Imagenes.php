<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imagenes
 *
 * @ORM\Table(name="Imagenes", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FKImagenes803015", columns={"Habitacionesid"}), @ORM\Index(name="FKImagenes411793", columns={"Casaid"}), @ORM\Index(name="FKImagenes754365", columns={"Puntosid"})})
 * @ORM\Entity
 */
class Imagenes
{
    /**
     * @var string
     *
     * @ORM\Column(name="imagen1", type="string", length=255, nullable=true)
     */
    private $imagen1;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen2", type="string", length=255, nullable=true)
     */
    private $imagen2;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen3", type="string", length=255, nullable=true)
     */
    private $imagen3;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen4", type="string", length=255, nullable=true)
     */
    private $imagen4;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen5", type="string", length=255, nullable=true)
     */
    private $imagen5;

    /**
     * @var string
     *
     * @ORM\Column(name="imagenvr1", type="string", length=255, nullable=true)
     */
    private $imagenvr1;

    /**
     * @var string
     *
     * @ORM\Column(name="imagenvr2", type="string", length=255, nullable=true)
     */
    private $imagenvr2;

    /**
     * @var string
     *
     * @ORM\Column(name="imagenvr3", type="string", length=255, nullable=true)
     */
    private $imagenvr3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Habitaciones
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Habitaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Habitacionesid", referencedColumnName="id")
     * })
     */
    private $habitacionesid;

    /**
     * @var \AppBundle\Entity\Puntos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Puntos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Puntosid", referencedColumnName="id")
     * })
     */
    private $puntosid;

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
     * Set imagen1
     *
     * @param string $imagen1
     * @return Imagenes
     */
    public function setImagen1($imagen1)
    {
        $this->imagen1 = $imagen1;

        return $this;
    }

    /**
     * Get imagen1
     *
     * @return string 
     */
    public function getImagen1()
    {
        return $this->imagen1;
    }

    /**
     * Set imagen2
     *
     * @param string $imagen2
     * @return Imagenes
     */
    public function setImagen2($imagen2)
    {
        $this->imagen2 = $imagen2;

        return $this;
    }

    /**
     * Get imagen2
     *
     * @return string 
     */
    public function getImagen2()
    {
        return $this->imagen2;
    }

    /**
     * Set imagen3
     *
     * @param string $imagen3
     * @return Imagenes
     */
    public function setImagen3($imagen3)
    {
        $this->imagen3 = $imagen3;

        return $this;
    }

    /**
     * Get imagen3
     *
     * @return string 
     */
    public function getImagen3()
    {
        return $this->imagen3;
    }

    /**
     * Set imagen4
     *
     * @param string $imagen4
     * @return Imagenes
     */
    public function setImagen4($imagen4)
    {
        $this->imagen4 = $imagen4;

        return $this;
    }

    /**
     * Get imagen4
     *
     * @return string 
     */
    public function getImagen4()
    {
        return $this->imagen4;
    }

    /**
     * Set imagen5
     *
     * @param string $imagen5
     * @return Imagenes
     */
    public function setImagen5($imagen5)
    {
        $this->imagen5 = $imagen5;

        return $this;
    }

    /**
     * Get imagen5
     *
     * @return string 
     */
    public function getImagen5()
    {
        return $this->imagen5;
    }

    /**
     * Set imagenvr1
     *
     * @param string $imagenvr1
     * @return Imagenes
     */
    public function setImagenvr1($imagenvr1)
    {
        $this->imagenvr1 = $imagenvr1;

        return $this;
    }

    /**
     * Get imagenvr1
     *
     * @return string 
     */
    public function getImagenvr1()
    {
        return $this->imagenvr1;
    }

    /**
     * Set imagenvr2
     *
     * @param string $imagenvr2
     * @return Imagenes
     */
    public function setImagenvr2($imagenvr2)
    {
        $this->imagenvr2 = $imagenvr2;

        return $this;
    }

    /**
     * Get imagenvr2
     *
     * @return string 
     */
    public function getImagenvr2()
    {
        return $this->imagenvr2;
    }

    /**
     * Set imagenvr3
     *
     * @param string $imagenvr3
     * @return Imagenes
     */
    public function setImagenvr3($imagenvr3)
    {
        $this->imagenvr3 = $imagenvr3;

        return $this;
    }

    /**
     * Get imagenvr3
     *
     * @return string 
     */
    public function getImagenvr3()
    {
        return $this->imagenvr3;
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
     * Set habitacionesid
     *
     * @param \AppBundle\Entity\Habitaciones $habitacionesid
     * @return Imagenes
     */
    public function setHabitacionesid(\AppBundle\Entity\Habitaciones $habitacionesid = null)
    {
        $this->habitacionesid = $habitacionesid;

        return $this;
    }

    /**
     * Get habitacionesid
     *
     * @return \AppBundle\Entity\Habitaciones 
     */
    public function getHabitacionesid()
    {
        return $this->habitacionesid;
    }

    /**
     * Set puntosid
     *
     * @param \AppBundle\Entity\Puntos $puntosid
     * @return Imagenes
     */
    public function setPuntosid(\AppBundle\Entity\Puntos $puntosid = null)
    {
        $this->puntosid = $puntosid;

        return $this;
    }

    /**
     * Get puntosid
     *
     * @return \AppBundle\Entity\Puntos 
     */
    public function getPuntosid()
    {
        return $this->puntosid;
    }

    /**
     * Set casaid
     *
     * @param \AppBundle\Entity\Casa $casaid
     * @return Imagenes
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
