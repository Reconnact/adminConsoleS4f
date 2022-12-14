<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Followers
 *
 * @ORM\Table(name="followers", indexes={@ORM\Index(name="profileID", columns={"profileID"}), @ORM\Index(name="followerID", columns={"followerID"})})
 * @ORM\Entity
 */
class Followers
{
    /**
     * @var int
     *
     * @ORM\Column(name="followingID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $followingid;

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
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="followerID", referencedColumnName="profileID")
     * })
     */
    private $followerid;

    public function getFollowingid(): ?int
    {
        return $this->followingid;
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

    public function getFollowerid(): ?Profile
    {
        return $this->followerid;
    }

    public function setFollowerid(?Profile $followerid): self
    {
        $this->followerid = $followerid;

        return $this;
    }


}
