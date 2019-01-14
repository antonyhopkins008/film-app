<?php

namespace App\Command;

use Exception;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class Film
{
    private $title;
    private $engTitle;
    private $genres = [];
    private $rating;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(Crawler $crawler): void
    {
        try {
            $this->title = $crawler->text();
        } catch (Exception $exception) {
            $this->title = null;
        }
    }

    public function getEngTitle(): string
    {
        return $this->engTitle;
    }

    public function setEngTitle(Crawler $crawler): void
    {
        try {
            $this->engTitle = $crawler->text();
        } catch (Exception $exception) {
            $this->engTitle = null;
        }
    }

    public function setGenres(Crawler $filter)
    {
        try {
            $this->genres = $filter->each(function (Crawler $node) {
                return $node->text();
            });
        } catch (InvalidArgumentException $exception) {
            //nothing here
        }
    }

    public function setRating(string $rating)
    {
        try {
            $this->rating = (float) $rating;
        } catch (InvalidArgumentException $exception) {
            //nothing here
        }
    }

    public function __toString()
    {
        $result = '';
        foreach ($this as $key => $value) {
            if (is_array($value)) {
                $result .= $key.':';
                foreach ($value as $k => $v) {
                    $result .= $v.'|';
                }
            } else {
                $result .= $key.':'.$value.'|';
            }
        }

        return $result;
    }
}
