<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\PetitionRepository;
use App\Services\PdfGenerationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(name: 'app:export-signatures')]
class CreateSignaturesListFileCommand extends Command
{
    private const DS = DIRECTORY_SEPARATOR;
    private const FOLDER = 'export';
    private const FILENAME_PREFIX = 'signatures-';
    private const FILE_EXTENSION = '.pdf';

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly PetitionRepository $petitionRepository,
        private readonly PdfGenerationService $pdfGenerationService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('petition_public_id', InputArgument::REQUIRED, 'Public id of petition')
            ->addArgument('header_text', InputArgument::OPTIONAL, 'Text of header section', '')
            ->addArgument('header_height', InputArgument::OPTIONAL, 'Height of header section in pixels', 0)
            ->addArgument('excluded_signatures', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Line number list of excluded signatures', []);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $petitionPublicId = $input->getArgument('petition_public_id');

        $petition = $this->petitionRepository->getByPublicId($petitionPublicId);
        $signatures = $petition->getSignatures()->getValues();

        $excluded_signatures = $input->getArgument('excluded_signatures');
        foreach ($excluded_signatures as $number) {
            unset($signatures[$number - 1]);
        }

        $signatures = array_values($signatures);

        $generatedPdf = $this->pdfGenerationService->generate(
            intval($input->getArgument('header_height')), $input->getArgument('header_text'), $signatures);

        $projectDir = $this->kernel->getProjectDir();
        $filePath = $projectDir . self::DS . self::FOLDER . self::DS . self::FILENAME_PREFIX . $petitionPublicId . self::FILE_EXTENSION;
        file_put_contents($filePath, $generatedPdf);

        return file_exists($filePath) ? Command::SUCCESS : Command::FAILURE;
    }
}

