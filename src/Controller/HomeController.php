<?php

namespace App\Controller;

use App\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Film::class);
        $films = $repository->findAll();

        if (!$films) {
            throw $this->createNotFoundException('Nothing was found');
        }

        return $this->render('home/index.html.twig', [
            'films' => $films,
        ]);
    }

    /**
     * @Route("/film/{id}", name="watch")
     */
    public function film($id)
    {
        $repository = $this->getDoctrine()->getRepository(Film::class);
        $film = $repository->findOneBy(['id' => $id]);

        return $this->render('home/watch.html.twig', [
            'film' => $film,
        ]);
    }
}
