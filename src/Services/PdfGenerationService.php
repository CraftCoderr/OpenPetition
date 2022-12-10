<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Signature;
use Dompdf\Dompdf;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PdfGenerationService
{
    private const DATE_FORMAT = 'd.m.Y';

    public function __construct(
        private readonly Environment $twig
    ) {
    }

    /**
     * @param Signature[] $signatures
     *
     * @return string
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generate(array $signatures): string
    {
        $formattedSignatures = $this->formatData($signatures);

        $html = $this->twig->render('signatures_list.html.twig', ['signatures' => $formattedSignatures]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output() ?? '';
    }

    /**
     * @param Signature[] $signatures
     *
     * @return array<string, string>
     */
    private function formatData(array $signatures): array
    {
        $data = [];
        foreach ($signatures as $i => $signature) {
            $data[] = [
                'number' => $i + 1,
                'name' => "{$signature->getName()} {$signature->getSurname()} {$signature->getPatronymic()}",
                'signing_date' => $signature->getSigningDate()?->format(self::DATE_FORMAT),
                'signature_writing' => $signature->getSignatureWriting(),
            ];
        }

        return $data;
    }
}
