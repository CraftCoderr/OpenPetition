<?php

namespace App\Controller\Petition;

use App\Entity\Signature;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;

class SignatureController extends AbstractController
{
    #[Route('/petition/signature', methods: ['POST'], name: 'app_petition_signature')]
    public function index(Request $request, ValidatorInterface $validator, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $signature = new Signature;

        $signature->setName($request->request->get('name'));
        $signature->setSurname($request->request->get('surname'));
        $signature->setPatronymic($request->request->get('patronymic'));
        $signature->setEmail($request->request->get('email'));
        $signature->setSignatureWriting($request->request->get('signature_writing'));
        $signature->setSigningDate(new \DateTime('now'));

        $errors = $validator->validate($signature);

        if (count($errors) > 0) {
            return new JsonResponse([
                'message' => (string) $errors
            ]);
        }

        $entityManager->persist($signature);

        $entityManager->flush();

        return new JsonResponse(['message' => 'Signature created successfully'], 201);
    }
}
