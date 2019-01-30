<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recomendados
 *
 * @ORM\Table(name="recomendados", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Recomendados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="peso", type="integer", nullable=true)
     */
    private $peso;

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
     *   @ORM\JoinColumn(name="Casaid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $casaid;

    /**
     * @var \AppBundle\Entity\Puntos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Puntos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Puntosid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $puntosid;



    /**
     * Set peso
     *
     * @param integer $peso
     * @return Recomendados
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return integer 
     */
    public function getPeso()
    {
        return $this->peso;
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
     * @return Recomendados
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
     * @return Recomendados
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
