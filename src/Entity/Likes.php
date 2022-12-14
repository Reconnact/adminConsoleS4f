<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Likes
 *
 * @ORM\Table(name="likes", indexes={@ORM\Index(name="profileID", columns={"profileID"}), @ORM\Index(name="postID", columns={"postID"})})
 * @ORM\Entity
 */
class Likes
{
    /**
     * @var int
     *
     * @ORM\Column(name="likeID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $likeid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profileID", referencedColumnName="profileID")
     * })
     */
    private $profileid;

    /**
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="postID", referencedColumnName="postID")
     * })
     */
    private $postid;

    public function getLikeid(): ?int
    {
        return $this->likeid;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getProfileid(): ?Profile
    {
        return $this->profileid;
    }

    public function setProfileid(?Profile $profileid): self
    {
        $this->profileid = $profileid;

        return $this;
    }

    public function getPostid(): ?Post
    {
        return $this->postid;
    }

    public function setPostid(?Post $postid): self
    {
        $this->postid = $postid;

        return $this;
    }


}
