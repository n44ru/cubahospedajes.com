<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imagenes
 *
 * @ORM\Table(name="imagenes", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Imagenes
{
    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \AppBundle\Entity\Casa
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Casa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Casaid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $casaid;



    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Imagenes
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Imagenes
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
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
