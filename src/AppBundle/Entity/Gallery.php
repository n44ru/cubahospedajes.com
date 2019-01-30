<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 *
 * @ORM\Table(name="gallery", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Gallery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Imagegallery
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Imagegallery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Imagegalleryid", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $imagegalleryid;



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
     * Set imagegalleryid
     *
     * @param \AppBundle\Entity\Imagegallery $imagegalleryid
     * @return Gallery
     */
    public function setImagegalleryid(\AppBundle\Entity\Imagegallery $imagegalleryid = null)
    {
        $this->imagegalleryid = $imagegalleryid;

        return $this;
    }

    /**
     * Get imagegalleryid
     *
     * @return \AppBundle\Entity\Imagegallery 
     */
    public function getImagegalleryid()
    {
        return $this->imagegalleryid;
    }
}
