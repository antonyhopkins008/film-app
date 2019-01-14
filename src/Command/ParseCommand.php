<?php

namespace App\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class ParseCommand extends Command
{
    protected static $defaultName = 'app:parse';

    protected const FAST_TORRENT = 'http://ftp.fast-torrent.ru/most-films/';

    protected function configure()
    {
        $this
            ->setDescription('Parse site')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
        }

        $client = new Client();
        $res = $client->get(self::FAST_TORRENT);

        $html = $res->getBody()->getContents();

        $crawler = new Crawler($html);
        $films = [];
        $crawler->filter('div.film-wrap')->each(function (Crawler $node, $i) {
            $film = new Film();
            $film->setTitle($node->filter('[itemprop="name"]'));
            $film->setEngTitle($node->filter('[itemprop="alternativeHeadline"]'));
            $film->setGenres($node->filter('[itemprop="genre"]'));
            $film->setRating($node->filter('.inline-rating')->attr('average'));
            $films[] = $film;
        });

        $fileSystem = new Filesystem();
        try {
            $fileSystem->mkdir(sys_get_temp_dir().'/'.random_int(0, 1000));
        } catch (IOExceptionInterface $exception) {
            echo 'An error occurred while creating your directory at '.$exception->getPath();
        } catch (\Exception $e) {
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
