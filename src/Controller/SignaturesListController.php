<?php

namespace App\Controller;

use App\Repository\SignatureRepository;
use App\Services\PdfGenerationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignaturesListController extends AbstractController
{
    #[Route('/signature-list/{petition_id}', name: 'signature_list')]
    public function getSignatureListByPetitionId(
        SignatureRepository $signatureRepository,
        PdfGenerationService $pdfGenerationService
    ): Response {
        $signatures = $signatureRepository->findAll();

        $dompdf = $pdfGenerationService->generate($signatures);

        return new Response(
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
