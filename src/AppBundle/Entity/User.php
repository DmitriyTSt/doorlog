<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=32, nullable=true)
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=32, nullable=true)
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=32, nullable=true)
     */
    private $middle_name;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=32, nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="background", type="string", length=32, nullable=true)
     */
    private $background;

    /**
     * @var int
     *
     * @ORM\Column(name="created_at", type="integer", nullable=true, options={"unsigned":true})
     */
    private $created_at;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=64, nullable=true)
     */
    private $role;

    /**
     * @var bool
     *
     * @ORM\Column(name="in_office", type="boolean")
     */
    private $in_office;

    /**
     * @var int
     *
     * @ORM\Column(name="birthday", type="integer", nullable=true, options={"unsigned":true})
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=32, nullable=true, unique=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=true, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=64, nullable=true)
     */
    private $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="slack", type="string", length=16, nullable=true)
     */
    private $slack;

    /**
     * @var string
     *
     * @ORM\Column(name="telegram", type="string", length=64, nullable=true)
     */
    private $telegram;

    /**
     * @var string
     *
     * @ORM\Column(name="card", type="string", length=32, nullable=true)
     */
    private $card;

    /**
     * @var string
     *
     * @ORM\Column(name="personal_id", type="string", length=32, nullable=true, unique=true)
     */
    private $personal_id;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=5, nullable=true)
     */
    private $salt;

    /**
     * @var bool
     *
     * @ORM\Column(name="halftime", type="boolean")
     */
    private $halftime;

    /**
     * @var ArrayCollection|Device[]
     *
     * @ORM\OneToMany(targetEntity="Device", mappedBy="user")
     */
    private $devices;

    public function __construct()
    {
        $date = new \DateTime('now');
        $this->setCreatedAt($date->getTimestamp());
        $this->setSalt(md5(microtime() . uniqid()));
        $this->devices = new ArrayCollection();
    }


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     *
     * @return User
     */
    public function setMiddleName($middleName)
    {
        $this->middle_name = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set background
     *
     * @param string $background
     *
     * @return User
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set createdAt
     *
     * @param integer $createdAt
     *
     * @return User
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
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set inOffice
     *
     * @param boolean $inOffice
     *
     * @return User
     */
    public function setInOffice($inOffice)
    {
        $this->in_office = $inOffice;

        return $this;
    }

    /**
     * Get inOffice
     *
     * @return bool
     */
    public function getInOffice()
    {
        return $this->in_office;
    }

    /**
     * Set birthday
     *
     * @param integer $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return int
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set skype
     *
     * @param string $skype
     *
     * @return User
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set slack
     *
     * @param string $slack
     *
     * @return User
     */
    public function setSlack($slack)
    {
        $this->slack = $slack;

        return $this;
    }

    /**
     * Get slack
     *
     * @return string
     */
    public function getSlack()
    {
        return $this->slack;
    }

    /**
     * Set telegram
     *
     * @param string $telegram
     *
     * @return User
     */
    public function setTelegram($telegram)
    {
        $this->telegram = $telegram;

        return $this;
    }

    /**
     * Get telegram
     *
     * @return string
     */
    public function getTelegram()
    {
        return $this->telegram;
    }

    /**
     * Set card
     *
     * @param string $card
     *
     * @return User
     */
    public function setCard($card)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Get card
     *
     * @return string
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Set personalId
     *
     * @param string $personalId
     *
     * @return User
     */
    public function setPersonalId($personalId)
    {
        $this->personal_id = $personalId;

        return $this;
    }

    /**
     * Get personalId
     *
     * @return string
     */
    public function getPersonalId()
    {
        return $this->personal_id;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set halftime
     *
     * @param boolean $halftime
     *
     * @return User
     */
    public function setHalftime($halftime)
    {
        $this->halftime = $halftime;

        return $this;
    }

    /**
     * Get halftime
     *
     * @return bool
     */
    public function getHalftime()
    {
        return $this->halftime;
    }

    /**
     * Set devices
     *
     * @param array $devices
     *
     * @return User
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;

        return $this;
    }

    /**
     * Get devices
     *
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }
}

