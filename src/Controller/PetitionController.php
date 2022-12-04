<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PetitionController extends AbstractController
{
    #[Route('/petition', name: 'petition')]
    public function index(): Response
    {
        return $this->render('petition.html.twig', [
            'sitename' => $this->getParameter('app.sitename'),
            'siteurl' => $this->getParameter('app.siteurl'),
            'sitemail' => $this->getParameter('app.sitemail'),
        ]);
    }
}
