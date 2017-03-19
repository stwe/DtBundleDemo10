<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EntityC
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @package AppBundle\Entity
 */
class EntityC
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
     * @ORM\ManyToOne(targetEntity="EntityD")
     */
    private $entityD;

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
     * Set id.
     *
     * @param mixed $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Get entityD.
     *
     * @return mixed
     */
    public function getEntityD()
    {
        return $this->entityD;
    }

    /**
     * Set entityD.
     *
     * @param mixed $entityD
     *
     * @return $this
     */
    public function setEntityD($entityD)
    {
        $this->entityD = $entityD;

        return $this;
    }
}
