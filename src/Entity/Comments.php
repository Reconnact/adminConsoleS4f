<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="postID", columns={"postID"}), @ORM\Index(name="profileID", columns={"profileID"})})
 * @ORM\Entity
 */
class Comments
{
    /**
     * @var int
     *
     * @ORM\Column(name="commentID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentid;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=1000, nullable=false)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="commentDate", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $commentdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="postID", referencedColumnName="postID")
     * })
     */
    private $postid;

    /**
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profileID", referencedColumnName="profileID")
     * })
     */
    private $profileid;

    public function getCommentid(): ?int
    {
        return $this->commentid;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCommentdate(): ?\DateTimeInterface
    {
        return $this->commentdate;
    }

    public function setCommentdate(\DateTimeInterface $commentdate): self
    {
        $this->commentdate = $commentdate;

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

    public function getProfileid(): ?Profile
    {
        return $this->profileid;
    }

    public function setProfileid(?Profile $profileid): self
    {
        $this->profileid = $profileid;

        return $this;
    }


}
