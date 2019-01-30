<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traducciones
 *
 * @ORM\Table(name="Traducciones", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Traducciones
{
    /**
     * @var string
     *
     * @ORM\Column(name="texto1", type="string", length=1000, nullable=true)
     */
    private $texto1;

    /**
     * @var string
     *
     * @ORM\Column(name="texto2", type="string", length=1000, nullable=true)
     */
    private $texto2;

    /**
     * @var string
     *
     * @ORM\Column(name="texto3", type="string", length=1000, nullable=true)
     */
    private $texto3;

    /**
     * @var string
     *
     * @ORM\Column(name="texto4", type="string", length=1000, nullable=true)
     */
    private $texto4;

    /**
     * @var string
     *
     * @ORM\Column(name="texto5", type="string", length=1000, nullable=true)
     */
    private $texto5;

    /**
     * @var string
     *
     * @ORM\Column(name="texto6", type="string", length=1000, nullable=true)
     */
    private $texto6;

    /**
     * @var string
     *
     * @ORM\Column(name="texto7", type="string", length=1000, nullable=true)
     */
    private $texto7;

    /**
     * @var string
     *
     * @ORM\Column(name="texto8", type="string", length=1000, nullable=true)
     */
    private $texto8;

    /**
     * @var string
     *
     * @ORM\Column(name="texto9", type="string", length=1000, nullable=true)
     */
    private $texto9;

    /**
     * @var string
     *
     * @ORM\Column(name="texto10", type="string", length=1000, nullable=true)
     */
    private $texto10;

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
     * @var \AppBundle\Entity\Banner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Banner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Bannerid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $bannerid;

    /**
     * @var \AppBundle\Entity\Idiomas
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Idiomas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Idiomasid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idiomasid;

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
     * Set texto1
     *
     * @param string $texto1
     * @return Traducciones
     */
    public function setTexto1($texto1)
    {
        $this->texto1 = $texto1;

        return $this;
    }

    /**
     * Get texto1
     *
     * @return string 
     */
    public function getTexto1()
    {
        return $this->texto1;
    }

    /**
     * Set texto2
     *
     * @param string $texto2
     * @return Traducciones
     */
    public function setTexto2($texto2)
    {
        $this->texto2 = $texto2;

        return $this;
    }

    /**
     * Get texto2
     *
     * @return string 
     */
    public function getTexto2()
    {
        return $this->texto2;
    }

    /**
     * Set texto3
     *
     * @param string $texto3
     * @return Traducciones
     */
    public function setTexto3($texto3)
    {
        $this->texto3 = $texto3;

        return $this;
    }

    /**
     * Get texto3
     *
     * @return string 
     */
    public function getTexto3()
    {
        return $this->texto3;
    }

    /**
     * Set texto4
     *
     * @param string $texto4
     * @return Traducciones
     */
    public function setTexto4($texto4)
    {
        $this->texto4 = $texto4;

        return $this;
    }

    /**
     * Get texto4
     *
     * @return string 
     */
    public function getTexto4()
    {
        return $this->texto4;
    }

    /**
     * Set texto5
     *
     * @param string $texto5
     * @return Traducciones
     */
    public function setTexto5($texto5)
    {
        $this->texto5 = $texto5;

        return $this;
    }

    /**
     * Get texto5
     *
     * @return string 
     */
    public function getTexto5()
    {
        return $this->texto5;
    }

    /**
     * Set texto6
     *
     * @param string $texto6
     * @return Traducciones
     */
    public function setTexto6($texto6)
    {
        $this->texto6 = $texto6;

        return $this;
    }

    /**
     * Get texto6
     *
     * @return string 
     */
    public function getTexto6()
    {
        return $this->texto6;
    }

    /**
     * Set texto7
     *
     * @param string $texto7
     * @return Traducciones
     */
    public function setTexto7($texto7)
    {
        $this->texto7 = $texto7;

        return $this;
    }

    /**
     * Get texto7
     *
     * @return string 
     */
    public function getTexto7()
    {
        return $this->texto7;
    }

    /**
     * Set texto8
     *
     * @param string $texto8
     * @return Traducciones
     */
    public function setTexto8($texto8)
    {
        $this->texto8 = $texto8;

        return $this;
    }

    /**
     * Get texto8
     *
     * @return string 
     */
    public function getTexto8()
    {
        return $this->texto8;
    }

    /**
     * Set texto9
     *
     * @param string $texto9
     * @return Traducciones
     */
    public function setTexto9($texto9)
    {
        $this->texto9 = $texto9;

        return $this;
    }

    /**
     * Get texto9
     *
     * @return string 
     */
    public function getTexto9()
    {
        return $this->texto9;
    }

    /**
     * Set texto10
     *
     * @param string $texto10
     * @return Traducciones
     */
    public function setTexto10($texto10)
    {
        $this->texto10 = $texto10;

        return $this;
    }

    /**
     * Get texto10
     *
     * @return string 
     */
    public function getTexto10()
    {
        return $this->texto10;
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
     * @return Traducciones
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
     * Set bannerid
     *
     * @param \AppBundle\Entity\Banner $bannerid
     * @return Traducciones
     */
    public function setBannerid(\AppBundle\Entity\Banner $bannerid = null)
    {
        $this->bannerid = $bannerid;

        return $this;
    }

    /**
     * Get bannerid
     *
     * @return \AppBundle\Entity\Banner 
     */
    public function getBannerid()
    {
        return $this->bannerid;
    }

    /**
     * Set idiomasid
     *
     * @param \AppBundle\Entity\Idiomas $idiomasid
     * @return Traducciones
     */
    public function setIdiomasid(\AppBundle\Entity\Idiomas $idiomasid = null)
    {
        $this->idiomasid = $idiomasid;

        return $this;
    }

    /**
     * Get idiomasid
     *
     * @return \AppBundle\Entity\Idiomas 
     */
    public function getIdiomasid()
    {
        return $this->idiomasid;
    }

    /**
     * Set casaid
     *
     * @param \AppBundle\Entity\Casa $casaid
     * @return Traducciones
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
