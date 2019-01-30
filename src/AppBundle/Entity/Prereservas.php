<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prereservas
 *
 * @ORM\Table(name="prereservas", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Prereservas
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
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="fechallegada", type="string", length=255, nullable=true)
     */
    private $fechallegada;

    /**
     * @var string
     *
     * @ORM\Column(name="fechasalida", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="cantpersonas", type="integer", nullable=true)
     */
    private $cantpersonas;

    /**
     * @var integer
     *
     * @ORM\Column(name="canthab", type="integer", nullable=true)
     */
    private $canthab;

    /**
     * @var string
     *
     * @ORM\Column(name="datosvuelo", type="string", length=255, nullable=true)
     */
    private $datosvuelo;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="string", length=255, nullable=true)
     */
    private $comentario;

    /**
     * @var \AppBundle\Entity\Estados
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Estadosid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $estadosid;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Prereservas
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
     * Set email
     *
     * @param string $email
     * @return Prereservas
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Prereservas
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set fechallegada
     *
     * @param string $fechallegada
     * @return Prereservas
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
     * @param string $fechasalida
     * @return Prereservas
     */
    public function setFechasalida($fechasalida)
    {
        $this->fechasalida = $fechasalida;

        return $this;
    }

    /**
     * Get fechasalida
     *
     * @return string 
     */
    public function getFechasalida()
    {
        return $this->fechasalida;
    }

    /**
     * Set horallegada
     *
     * @param string $horallegada
     * @return Prereservas
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
     * @return Prereservas
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
     * Set cantpersonas
     *
     * @param integer $cantpersonas
     * @return Prereservas
     */
    public function setCantpersonas($cantpersonas)
    {
        $this->cantpersonas = $cantpersonas;

        return $this;
    }

    /**
     * Get cantpersonas
     *
     * @return integer 
     */
    public function getCantpersonas()
    {
        return $this->cantpersonas;
    }

    /**
     * Set canthab
     *
     * @param integer $canthab
     * @return Prereservas
     */
    public function setCanthab($canthab)
    {
        $this->canthab = $canthab;

        return $this;
    }

    /**
     * Get canthab
     *
     * @return integer 
     */
    public function getCanthab()
    {
        return $this->canthab;
    }

    /**
     * Set datosvuelo
     *
     * @param string $datosvuelo
     * @return Prereservas
     */
    public function setDatosvuelo($datosvuelo)
    {
        $this->datosvuelo = $datosvuelo;

        return $this;
    }

    /**
     * Get datosvuelo
     *
     * @return string 
     */
    public function getDatosvuelo()
    {
        return $this->datosvuelo;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return Prereservas
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
     * Set comentario
     *
     * @param string $comentario
     * @return Prereservas
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
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
     * @return Prereservas
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
     * Set estadosid
     *
     * @param \AppBundle\Entity\Estados $estadosid
     * @return Prereservas
     */
    public function setEstadosid(\AppBundle\Entity\Estados $estadosid = null)
    {
        $this->estadosid = $estadosid;

        return $this;
    }

    /**
     * Get estadosid
     *
     * @return \AppBundle\Entity\Estados
     */
    public function getEstadosid()
    {
        return $this->estadosid;
    }
}
