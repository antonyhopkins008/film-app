<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="review")
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min=0, max=10)
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Film", inversedBy="reviews")
     * @ORM\JoinColumn(name="film_id", referencedColumnName="id", nullable=true)
     */
    private $film;

    /**
     * Review constructor.
     */
    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

    public function setRate(int $rate): void
    {
        $this->rate = $rate;
    }

    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
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
