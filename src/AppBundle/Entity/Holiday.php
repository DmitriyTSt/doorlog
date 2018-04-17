<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Holiday
 *
 * @ORM\Table(name="holiday")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HolidayRepository")
 */
class Holiday
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;

    /**
     * @var int
     *
     * @ORM\Column(name="created_at", type="integer", nullable=true)
     */
    private $created_at;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="cnt", type="integer", nullable=true)
     */
    private $cnt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param integer $createdAt
     *
     * @return Holiday
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Holiday
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set cnt
     *
     * @param integer $cnt
     *
     * @return Holiday
     */
    public function setCnt($cnt)
    {
        $this->cnt = $cnt;

        return $this;
    }

    /**
     * Get cnt
     *
     * @return int
     */
    public function getCnt()
    {
        return $this->cnt;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}

