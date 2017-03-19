<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EntityB
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @package AppBundle\Entity
 */
class EntityB
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="EntityC")
     */
    private $entityC;

    /**
     * Get id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get entityC.
     *
     * @return mixed
     */
    public function getEntityC()
    {
        return $this->entityC;
    }

    /**
     * Set entityC.
     *
     * @param mixed $entityC
     *
     * @return $this
     */
    public function setEntityC($entityC)
    {
        $this->entityC = $entityC;

        return $this;
    }
}
