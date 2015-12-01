<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Process\Process;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact_form_data")
 * @ORM\HasLifecycleCallbacks()
 */
class ContactForm
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    protected $message;

    /**
     * @ORM\Column(name="date_create", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="ip_address", type="string", length=255)
     */
    protected $ipAddress;

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreatedAtValue();
        $this->detectAndSetIpAddress();
    }

    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime(date('Y-m-d H:i:s'));
    }

    public function detectAndSetIpAddress()
    {
        $process = new Process("curl -s ipv4.icanhazip.com");
        $process->run();
        $this->ipAddress = $process->getOutput();
    }
}