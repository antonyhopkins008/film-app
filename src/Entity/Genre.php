<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="genre")
 * @UniqueEntity("name")
 */
class Genre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=400, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=200)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Film", inversedBy="genres")
     * @ORM\JoinTable(name="films_genres",
     *     joinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="film_id", referencedColumnName="id")}
     * )
     */
    private $films;

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

    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function setFilm(Film $film): self
    {
        if (!$this->films->contains($film)) {
            $this->films->add($film);
            $film->setGenre($this);
        }

        return $this;
    }
}
