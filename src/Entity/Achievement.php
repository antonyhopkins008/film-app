<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="achievement")
 * @UniqueEntity("name")
 */
class Achievement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(min="3", max=100)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Film", inversedBy="achievements")
     * @ORM\JoinTable(name="films_achievements",
     *     joinColumns={@ORM\JoinColumn(name="achievement_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="film_id", referencedColumnName="id")}
     * )
     */
    private $films;

    /**
     * Achievement constructor.
     */
    public function __construct()
    {
        $this->films = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setFilm(Film $film): self
    {
        if (!$this->films->contains($film)) {
            $this->films->add($film);
            $film->setAchievement($this);
        }

        return $this;
    }

    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
