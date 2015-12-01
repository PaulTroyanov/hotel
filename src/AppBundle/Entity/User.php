<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $surname;

    /**
     * @ORM\Column(name="passport_id", type="string", length=255)
     */
    protected $passportId;

    /**
     * @ORM\Column(name="phone_number", type="string", length=255)
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $pledge;

    /**
     * @ORM\Column(name="room_id", type="integer")
     */
    protected $roomId;
}