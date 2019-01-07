<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="film", uniqueConstraints={
 *      @UniqueConstraint(columns={"title", "country"})
 * })
 * @ORM\Entity(repositoryClass="App\Repository\FilmRepository")
 * @UniqueEntity("title")
 */
class Film
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true)
     * @Assert\Length(min=1900)
     */
    private $releaseYear;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     */
    private $budget = 0;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $sourcePath;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasSubtitles = false;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Length(min=3)
     */
    private $durationSeconds;

    /**
     * @ORM\Column(type="text", nullable=false, name="poster_img")
     */
    private $posterImg;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genre", mappedBy="films")
     */
    private $genres;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Studio", mappedBy="films")
     */
    private $studios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="film")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Achievement", mappedBy="films")
     */
    private $achievements;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Comment",
     *     mappedBy="film",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trailer", mappedBy="film")
     */
    private $trailers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Actor", mappedBy="films")
     */
    private $actors;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producer", inversedBy="films")
     */
    private $producer;

    /**
     * Film constructor.
     */
    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->trailers = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->achievements = new ArrayCollection();
        $this->studios = new ArrayCollection();

        $this->publishedAt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourcePath(): string
    {
        return $this->sourcePath;
    }

    public function setSourcePath(string $sourcePath): void
    {
        $this->sourcePath = $sourcePath;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPosterImg(): ?string
    {
        return $this->posterImg;
    }

    public function setPosterImg(string $posterImg): void
    {
        $this->posterImg = $posterImg;
    }

    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function setGenres($genres): void
    {
        $this->genres = $genres;
    }

    public function getStudios()
    {
        return $this->studios;
    }

    public function setStudio(Studio $studio): self
    {
        if (!$this->studios->contains($studio)) {
            $this->studios->add($studio);
            $studio->setFilm($this);
        }

        return $this;
    }

    public function getReleaseYear()
    {
        return $this->releaseYear;
    }

    public function setReleaseYear($releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    public function getReviews()
    {
        return $this->reviews;
    }

    public function setReviews($reviews): void
    {
        $this->reviews = $reviews;
    }

    public function getAchievements()
    {
        return $this->achievements;
    }

    public function setAchievement(Achievement $achievement): self
    {
        if (!$this->achievements->contains($achievement)) {
            $this->achievements->contains($achievement);
            $achievement->setFilm($this);
        }

        return $this;
    }

    public function getHasSubtitles()
    {
        return $this->hasSubtitles;
    }

    public function setHasSubtitles($hasSubtitles): void
    {
        $this->hasSubtitles = $hasSubtitles;
    }

    public function getDuration(): int
    {
        return $this->durationSeconds;
    }

    public function setDuration(int $durationSeconds): void
    {
        $this->durationSeconds = $durationSeconds;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }

        return $this;
    }

    public function getTrailers(): ?Collection
    {
        return $this->trailers;
    }

    public function setTrailers($trailers): void
    {
        $this->trailers = $trailers;
    }

    public function getActors()
    {
        return $this->actors;
    }

    public function setActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
            $actor->setFilm($this);
        }

        return $this;
    }

    public function getProducer()
    {
        return $this->producer;
    }

    public function setProducer($producer): void
    {
        $this->producer = $producer;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getBudget()
    {
        return $this->budget;
    }

    public function setBudget($budget): void
    {
        $this->budget = $budget;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function setGenre(Genre $genre)
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->setFilm($this);
        }

        return $this;
    }
}
