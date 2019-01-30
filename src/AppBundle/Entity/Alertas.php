<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alertas
 *
 * @ORM\Table(name="alertas", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Alertas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="reservas", type="integer", nullable=false)
     */
    private $reservas;

    /**
     * @var integer
     *
     * @ORM\Column(name="casas_activas", type="integer", nullable=false)
     */
    private $casasActivas;

    /**
     * @var integer
     *
     * @ORM\Column(name="casas_inactivas", type="integer", nullable=false)
     */
    private $casasInactivas;

    /**
     * @var integer
     *
     * @ORM\Column(name="testimonios", type="integer", nullable=false)
     */
    private $testimonios;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set reservas
     *
     * @param integer $reservas
     * @return Alertas
     */
    public function setReservas($reservas)
    {
        $this->reservas = $reservas;

        return $this;
    }

    /**
     * Get reservas
     *
     * @return integer 
     */
    public function getReservas()
    {
        return $this->reservas;
    }

    /**
     * Set casasActivas
     *
     * @param integer $casasActivas
     * @return Alertas
     */
    public function setCasasActivas($casasActivas)
    {
        $this->casasActivas = $casasActivas;

        return $this;
    }

    /**
     * Get casasActivas
     *
     * @return integer 
     */
    public function getCasasActivas()
    {
        return $this->casasActivas;
    }

    /**
     * Set casasInactivas
     *
     * @param integer $casasInactivas
     * @return Alertas
     */
    public function setCasasInactivas($casasInactivas)
    {
        $this->casasInactivas = $casasInactivas;

        return $this;
    }

    /**
     * Get casasInactivas
     *
     * @return integer 
     */
    public function getCasasInactivas()
    {
        return $this->casasInactivas;
    }

    /**
     * Set testimonios
     *
     * @param integer $testimonios
     * @return Alertas
     */
    public function setTestimonios($testimonios)
    {
        $this->testimonios = $testimonios;

        return $this;
    }

    /**
     * Get testimonios
     *
     * @return integer 
     */
    public function getTestimonios()
    {
        return $this->testimonios;
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
}
