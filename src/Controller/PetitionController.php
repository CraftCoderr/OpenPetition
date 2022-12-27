<?php

namespace App\Controller;

use App\Entity\Petition;
use App\Entity\Signature;
use App\Repository\PetitionRepository;
use App\Repository\SignatureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PetitionController extends AbstractController
{
    #[Route('/{public_id}', name: 'app_petition_page')]
    public function index(
        string $public_id,
        PetitionRepository $petitionRepository
    ): Response {
        $petition = $petitionRepository->getPetitionByPublicId($public_id);

        $signaturesCount = $petitionRepository->getSignatureCount($petition);

        return $this->render('petition.html.twig', [
            'petition_id' => $petition->getId(),
            'sitename' => $this->getParameter('app.sitename'),
            'siteurl' => $this->getParameter('app.siteurl'),
            'sitemail' => $this->getParameter('app.sitemail'),
            'people_signed' => $signaturesCount,
            'petition_title' => $petition->getTitle(),
            'petition_subtitle' => $petition->getSubtitle(),
            'petition_target_to_whom' => $petition->getTargetToWhom(),
            'petition_target' => $petition->getTarget(),
            'petition_author_to_whom' => $petition->getAuthorToWhom(),
            'petition_text' => $petition->getText(),
        ]);
    }

    #[Route('/{petition_id}/public-offer', name: 'app_public_offer', priority: 1)]
    public function publicOffer(string $petition_id): Response
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
            'petition_target' => $this->getParameter('app.petition_target'),
            'petition_author_to_whom' => $this->getParameter('app.petition_author_to_whom'),
            'petition_url' => $this->getParameter('app.siteurl') . $this->generateUrl('app_petition_page', ['petition_id' => $petition_id]),
        ]);
    }

    #[Route('/{petition_id}/signature', name: 'app_petition_signature', methods: ['POST'], priority: 1)]
    public function signature(
        Request $request,
        ValidatorInterface $validator,
        ManagerRegistry $doctrine,
        PetitionRepository $petitionRepository
    ): JsonResponse {
        $entityManager = $doctrine->getManager();

        $signature = new Signature;

        $signature->setName($request->get('name'));
        $signature->setSurname($request->get('surname'));
        $signature->setPatronymic($request->get('patronymic'));
        $signature->setEmail($request->get('email'));
        $signature->setSignatureWriting($request->get('signature_writing'));
        $signature->setSigningDate(new \DateTime('now'));

        $petitionId = $request->get('petition_id');
        $petition = $petitionRepository->get($petitionId);
        $signature->setPetition($petition);

        $errors = $validator->validate($signature);

        if (count($errors) > 0) {
            return new JsonResponse([
                'message' => (string) $errors
            ], 400);
        }

        $entityManager->persist($signature);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Signature created successfully'], 201);
    }
}
