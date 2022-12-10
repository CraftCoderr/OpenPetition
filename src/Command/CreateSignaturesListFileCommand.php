<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\SignatureRepository;
use App\Services\PdfGenerationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(name: 'app:create-signatures-list-pdf-file')]
class CreateSignaturesListFileCommand extends Command
{
    private const DS = DIRECTORY_SEPARATOR;
    private const FOLDER = 'export';
    private const FILENAME = 'signature';
    private const FILE_EXTENSION = '.pdf';

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly SignatureRepository $signatureRepository,
        private readonly PdfGenerationService $pdfGenerationService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $signatures = $this->signatureRepository->findAll();

        $generatedPdf = $this->pdfGenerationService->generate($signatures);

        $projectDir = $this->kernel->getProjectDir();
        $filePath = $projectDir . self::DS . self::FOLDER . self::DS . self::FILENAME . self::FILE_EXTENSION;
        file_put_contents($filePath, $generatedPdf);

        return file_exists($filePath) ? Command::SUCCESS : Command::FAILURE;
    }
}

