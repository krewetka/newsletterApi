<?php

namespace NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $body;

    public function __construct($title = '', $body = '')
    {
        //FIXME remove later
        $this->id   = 1;
        $this->title = $title;
        $this->body = $body;
    }
}