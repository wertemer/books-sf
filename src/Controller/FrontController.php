<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Genres;

class FrontController extends AbstractController
{
    #[Route('/front', name: 'front')]
    public function index(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $genres=$this->getDoctrine()
            ->getRepository(Genres::class)
            ->findAll();
        return $this->render('front/index.html.twig', [
            'title' => 'Книги',
            'genres'    => $genres,
        ]);
    }
}
