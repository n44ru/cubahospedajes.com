<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coordenadas
 *
 * @ORM\Table(name="Coordenadas", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="FKCoordenada522742", columns={"Puntosid"}), @ORM\Index(name="FKCoordenada643416", columns={"Casaid"})})
 * @ORM\Entity
 */
class Coordenadas
{
    /**
     * @var string
     *
     * @ORM\Column(name="coordenadas", type="string", length=255, nullable=true)
     */
    private $coordenadas;

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
     * @var \AppBundle\Entity\Puntos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Puntos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Puntosid", referencedColumnName="id")
     * })
     */
    private $puntosid;



    /**
     * Set coordenadas
     *
     * @param string $coordenadas
     * @return Coordenadas
     */
    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    /**
     * Get coordenadas
     *
     * @return string 
     */
    public function getCoordenadas()
    {
        return $this->coordenadas;
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
     * @return Coordenadas
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

    /**
     * Set puntosid
     *
     * @param \AppBundle\Entity\Puntos $puntosid
     * @return Coordenadas
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
}
