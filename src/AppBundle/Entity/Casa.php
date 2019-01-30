<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Casa
 *
 * @ORM\Table(name="casa", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Casa
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
     * @ORM\Column(name="responsable", type="string", length=255, nullable=true)
     */
    private $responsable;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="activa", type="string", length=2, nullable=true)
     */
    private $activa;

    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="string", length=1000, nullable=true)
     */
    private $texto;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=true)
     */
    private $precio;

    /**
     * @var integer
     *
     * @ORM\Column(name="cuartos", type="integer", nullable=true)
     */
    private $cuartos;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacidad", type="integer", nullable=true)
     */
    private $capacidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="bath", type="integer", nullable=true)
     */
    private $bath;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="metatitle", type="string", length=255, nullable=true)
     */
    private $metatitle;

    /**
     * @var string
     *
     * @ORM\Column(name="metadesc", type="string", length=255, nullable=true)
     */
    private $metadesc;

    /**
     * @var string
     *
     * @ORM\Column(name="metakeyword", type="string", length=255, nullable=true)
     */
    private $metakeyword;

    /**
     * @var string
     *
     * @ORM\Column(name="reservamultiple", type="string", length=2, nullable=true)
     */
    private $reservamultiple;

    /**
     * @var float
     *
     * @ORM\Column(name="preciooferta", type="float", precision=10, scale=0, nullable=true)
     */
    private $preciooferta;

    /**
     * @var string
     *
     * @ORM\Column(name="reglas", type="string", length=2000, nullable=true)
     */
    private $reglas;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

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
     *   @ORM\JoinColumn(name="Subdestinosid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $subdestinosid;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Casa
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
     * @return Casa
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
     * Set responsable
     *
     * @param string $responsable
     * @return Casa
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return Casa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Casa
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set activa
     *
     * @param string $activa
     * @return Casa
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
     * Set texto
     *
     * @param string $texto
     * @return Casa
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
     * Set precio
     *
     * @param float $precio
     * @return Casa
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
     * Set cuartos
     *
     * @param integer $cuartos
     * @return Casa
     */
    public function setCuartos($cuartos)
    {
        $this->cuartos = $cuartos;

        return $this;
    }

    /**
     * Get cuartos
     *
     * @return integer 
     */
    public function getCuartos()
    {
        return $this->cuartos;
    }

    /**
     * Set capacidad
     *
     * @param integer $capacidad
     * @return Casa
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
     * Set bath
     *
     * @param integer $bath
     * @return Casa
     */
    public function setBath($bath)
    {
        $this->bath = $bath;

        return $this;
    }

    /**
     * Get bath
     *
     * @return integer 
     */
    public function getBath()
    {
        return $this->bath;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Casa
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set metatitle
     *
     * @param string $metatitle
     * @return Casa
     */
    public function setMetatitle($metatitle)
    {
        $this->metatitle = $metatitle;

        return $this;
    }

    /**
     * Get metatitle
     *
     * @return string 
     */
    public function getMetatitle()
    {
        return $this->metatitle;
    }

    /**
     * Set metadesc
     *
     * @param string $metadesc
     * @return Casa
     */
    public function setMetadesc($metadesc)
    {
        $this->metadesc = $metadesc;

        return $this;
    }

    /**
     * Get metadesc
     *
     * @return string 
     */
    public function getMetadesc()
    {
        return $this->metadesc;
    }

    /**
     * Set metakeyword
     *
     * @param string $metakeyword
     * @return Casa
     */
    public function setMetakeyword($metakeyword)
    {
        $this->metakeyword = $metakeyword;

        return $this;
    }

    /**
     * Get metakeyword
     *
     * @return string 
     */
    public function getMetakeyword()
    {
        return $this->metakeyword;
    }

    /**
     * Set reservamultiple
     *
     * @param string $reservamultiple
     * @return Casa
     */
    public function setReservamultiple($reservamultiple)
    {
        $this->reservamultiple = $reservamultiple;

        return $this;
    }

    /**
     * Get reservamultiple
     *
     * @return string 
     */
    public function getReservamultiple()
    {
        return $this->reservamultiple;
    }

    /**
     * Set preciooferta
     *
     * @param float $preciooferta
     * @return Casa
     */
    public function setPreciooferta($preciooferta)
    {
        $this->preciooferta = $preciooferta;

        return $this;
    }

    /**
     * Get preciooferta
     *
     * @return float 
     */
    public function getPreciooferta()
    {
        return $this->preciooferta;
    }

    /**
     * Set reglas
     *
     * @param string $reglas
     * @return Casa
     */
    public function setReglas($reglas)
    {
        $this->reglas = $reglas;

        return $this;
    }

    /**
     * Get reglas
     *
     * @return string 
     */
    public function getReglas()
    {
        return $this->reglas;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Casa
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * @return Casa
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
