<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicOfferController extends AbstractController
{
    #[Route('/public-offer', name: 'app_public_offer')]
    public function index(): Response
    {
        return $this->render('public_offer.html.twig', [
            'sitename' => $this->getParameter('app.sitename'),
            'siteurl' => $this->getParameter('app.siteurl'),
            'sitemail' => $this->getParameter('app.sitemail'),
            'siteowner_who' => $this->getParameter('app.siteowner_who'),
            'siteowner_by_whom' => $this->getParameter('app.siteowner_by_whom'),
            'siteowner_birthdate' => $this->getParameter('app.siteowner_birthdate'),
            'petition_autor_who' => $this->getParameter('app.petition_author_who'),
            'petition_author_birthdate' => $this->getParameter('app.petition_author_birthdate'),
            'petition_target' => $this->getPArameter('app.petition_target'),
            'petition_author_to_whom' => $this->getParameter('app.petition_author_to_whom'),
            'petition_url' => $this->getParameter('app.petition_url'),
        ]);
    }
}
