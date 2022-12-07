<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonalDataPolicyController extends AbstractController
{
    #[Route('/personal-data-policy', name: 'app_personal_data_policy', priority: 10)]
    public function index(): Response
    {
        return $this->render('personal_data_policy.html.twig', [
            'sitename' => $this->getParameter('app.sitename'),
            'siteurl' => $this->getParameter('app.siteurl'),
            'sitemail' => $this->getParameter('app.sitemail'),
            'siteowner_who' => $this->getParameter('app.siteowner_who'),
            'siteowner_by_whom' => $this->getParameter('app.siteowner_by_whom'),
            'siteowner_birthdate' => $this->getParameter('app.siteowner_birthdate')
        ]);
    }
}
