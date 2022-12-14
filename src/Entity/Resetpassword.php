<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resetpassword
 *
 * @ORM\Table(name="resetpassword", indexes={@ORM\Index(name="profileID", columns={"profileID"})})
 * @ORM\Entity
 */
class Resetpassword
{
    /**
     * @var int
     *
     * @ORM\Column(name="resetID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $resetid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var \Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profileID", referencedColumnName="profileID")
     * })
     */
    private $profileid;

    public function getResetid(): ?int
    {
        return $this->resetid;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

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
