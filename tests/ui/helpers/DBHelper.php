<?php

namespace App\Tests\ui\helpers;

use App\Entity\Petition;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class DBHelper
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function addPetition(): void
    {
        $jsonString = file_get_contents(__DIR__ . "/../resources/petition.json");
        $dataForPetition = json_decode($jsonString, true);

        $petition = new Petition();
        $petition->setClosed($dataForPetition["closed"]);
        $petition->setTitle($dataForPetition["title"]);
        $petition->setSubtitle($dataForPetition["subtitle"]);
        $petition->setText($dataForPetition["text"]);
        $petition->setTarget($dataForPetition["target"]);
        $petition->setTargetToWhom($dataForPetition["target_to_whom"]);
        $petition->setAuthor($dataForPetition["author"]);
        $petition->setAuthorToWhom($dataForPetition["author_to_whom"]);
        $petition->setAuthorBirthdate($dataForPetition["author_birthdate"]);
        $petition->setPublicId($dataForPetition["public_id"]);

        if (!$this->isPetitionExist()) {
            $this->entityManager->persist($petition);
            $this->entityManager->flush();
        }
    }

    private function isPetitionExist(): bool
    {
        return !is_null($this->entityManager->getRepository(Petition::class)->findOneBy(["public_id" => "autotest"]));
    }
}