<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="trailer")
 */
class Trailer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Length(min=3)
     * @Assert\NotBlank()
     */
    private $duration;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $sourcePath;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Film", inversedBy="trailers")
     * @ORM\JoinColumn(name="film_id", referencedColumnName="id", nullable=true)
     */
    private $film;

    public function getSourcePath(): string
    {
        return $this->sourcePath;
    }

    public function setSourcePath(string $sourcePath): void
    {
        $this->sourcePath = $sourcePath;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDuration(): \DateInterval
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getFilm(): Film
    {
        return $this->film;
    }

    public function setFilm(Film $film): void
    {
        $this->film = $film;
    }
}
