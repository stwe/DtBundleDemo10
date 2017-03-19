<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EntityA
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @package AppBundle\Entity
 */
class EntityA
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
     * @ORM\ManyToOne(targetEntity="EntityB")
     */
    private $entityB;

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
     * Get entityB.
     *
     * @return mixed
     */
    public function getEntityB()
    {
        return $this->entityB;
    }

    /**
     * Set entityB.
     *
     * @param mixed $entityB
     *
     * @return $this
     */
    public function setEntityB($entityB)
    {
        $this->entityB = $entityB;

        return $this;
    }
}
