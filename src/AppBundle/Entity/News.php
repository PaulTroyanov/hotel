<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="news")
 * @ORM\HasLifecycleCallbacks()
 */
class News
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
    protected $head;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $body;

    /**
     * @ORM\Column(name="date_create", type="datetime")
     */
    protected $createdAt;

    /**
     * @param string $head
     */
    public function setHead($head)
    {
        $this->head = $head;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime(date('Y-m-d H:i:s'));
    }
}