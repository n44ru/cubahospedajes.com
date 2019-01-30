<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Settings
{
    /**
     * @var string
     *
     * @ORM\Column(name="email_global", type="string", length=255, nullable=true)
     */
    private $emailGlobal;

    /**
     * @var string
     *
     * @ORM\Column(name="webtitulo", type="string", length=255, nullable=true)
     */
    private $webtitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="webdesc", type="string", length=255, nullable=true)
     */
    private $webdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="webkeywords", type="string", length=255, nullable=true)
     */
    private $webkeywords;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set emailGlobal
     *
     * @param string $emailGlobal
     * @return Settings
     */
    public function setEmailGlobal($emailGlobal)
    {
        $this->emailGlobal = $emailGlobal;

        return $this;
    }

    /**
     * Get emailGlobal
     *
     * @return string 
     */
    public function getEmailGlobal()
    {
        return $this->emailGlobal;
    }

    /**
     * Set webtitulo
     *
     * @param string $webtitulo
     * @return Settings
     */
    public function setWebtitulo($webtitulo)
    {
        $this->webtitulo = $webtitulo;

        return $this;
    }

    /**
     * Get webtitulo
     *
     * @return string 
     */
    public function getWebtitulo()
    {
        return $this->webtitulo;
    }

    /**
     * Set webdesc
     *
     * @param string $webdesc
     * @return Settings
     */
    public function setWebdesc($webdesc)
    {
        $this->webdesc = $webdesc;

        return $this;
    }

    /**
     * Get webdesc
     *
     * @return string 
     */
    public function getWebdesc()
    {
        return $this->webdesc;
    }

    /**
     * Set webkeywords
     *
     * @param string $webkeywords
     * @return Settings
     */
    public function setWebkeywords($webkeywords)
    {
        $this->webkeywords = $webkeywords;

        return $this;
    }

    /**
     * Get webkeywords
     *
     * @return string 
     */
    public function getWebkeywords()
    {
        return $this->webkeywords;
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
