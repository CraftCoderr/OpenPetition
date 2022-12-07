<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class PetitionController extends AbstractController
{
    #[Route('/{petition_id}', name: 'app_petition_page')]
    public function index(string $petition_id, KernelInterface $kernel): Response
    {
        if ($petition_id != $this->getParameter('app.petition_id')) {
            $this->redirectToRoute('app_petition_page', ['petition_id' => $this->getParameter('app.petition_id')]);
        }

        $finder = new Finder();
        $finder->files()->ignoreUnreadableDirs()->path($this->getParameter('app.petition_text_file'))->in($kernel->getProjectDir() . '/app_parameters');

        $petition_text_file = null;

        foreach ($finder as $petition_text_file) {}

        if (is_null($petition_text_file)) {
            $petition_text = 'Текст отсутствует';
        } else {
            $petition_text = $petition_text_file->getContents();
        }

        return $this->render('petition.html.twig', [
            'petition_id' => $petition_id,
            'sitename' => $this->getParameter('app.sitename'),
            'siteurl' => $this->getParameter('app.siteurl'),
            'sitemail' => $this->getParameter('app.sitemail'),
            'people_signed' => "357",
            'petition_title' => $this->getParameter('app.petition_title'),
            'petition_subtitle' => $this->getParameter('app.petition_subtitle'),
            'petition_target_to_whom' => $this->getParameter('app.petition_target_to_whom'),
            'petition_target' => $this->getParameter('app.petition_target'),
            'petition_author_to_whom' => $this->getParameter('app.petition_author_to_whom'),
            'petition_text' => $petition_text
        ]);
    }

    #[Route('/{petition_id}/public-offer', name: 'app_public_offer', priority: 1)]
    public function publicOffer(): Response
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
