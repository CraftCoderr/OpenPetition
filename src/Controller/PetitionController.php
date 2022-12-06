<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class PetitionController extends AbstractController
{
    #[Route('/petition', name: 'petition')]
    public function index(KernelInterface $kernel): Response
    {
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
}
