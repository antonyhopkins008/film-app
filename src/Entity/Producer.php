<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="producer", uniqueConstraints={
 *     @UniqueConstraint(columns={"first_name", "last_name"})
 * })
 */
class Producer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="first_name")
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="100")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", name="last_name")
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="100")
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Film", targetEntity="producer", mappedBy="producer")
     */
    private $films;

    /**
     * Producer constructor.
     */
    public function __construct()
    {
        $this->films = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function setFilms(Collection $films): void
    {
        $this->films = $films;
    }
}
