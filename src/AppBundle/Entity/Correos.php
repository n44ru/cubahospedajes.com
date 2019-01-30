<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Correos
 *
 * @ORM\Table(name="correos", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Correos
{
    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="asunto", type="string", length=1000, nullable=true)
     */
    private $asunto;

    /**
     * @var string
     *
     * @ORM\Column(name="msgcliente", type="string", length=2000, nullable=false)
     */
    private $msgcliente;

    /**
     * @var string
     *
     * @ORM\Column(name="msghostal", type="string", length=2000, nullable=false)
     */
    private $msghostal;

    /**
     * @var string
     *
     * @ORM\Column(name="msgadmins", type="string", length=2000, nullable=false)
     */
    private $msgadmins;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Correos
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set asunto
     *
     * @param string $asunto
     * @return Correos
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;

        return $this;
    }

    /**
     * Get asunto
     *
     * @return string 
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Set msgcliente
     *
     * @param string $msgcliente
     * @return Correos
     */
    public function setMsgcliente($msgcliente)
    {
        $this->msgcliente = $msgcliente;

        return $this;
    }

    /**
     * Get msgcliente
     *
     * @return string 
     */
    public function getMsgcliente()
    {
        return $this->msgcliente;
    }

    /**
     * Set msghostal
     *
     * @param string $msghostal
     * @return Correos
     */
    public function setMsghostal($msghostal)
    {
        $this->msghostal = $msghostal;

        return $this;
    }

    /**
     * Get msghostal
     *
     * @return string 
     */
    public function getMsghostal()
    {
        return $this->msghostal;
    }

    /**
     * Set msgadmins
     *
     * @param string $msgadmins
     * @return Correos
     */
    public function setMsgadmins($msgadmins)
    {
        $this->msgadmins = $msgadmins;

        return $this;
    }

    /**
     * Get msgadmins
     *
     * @return string 
     */
    public function getMsgadmins()
    {
        return $this->msgadmins;
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
