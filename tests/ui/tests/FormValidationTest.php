<?php

namespace App\Tests\ui\tests;

use App\Tests\ui\BaseTest;
use App\Tests\ui\helpers\DBHelper;
use App\Tests\ui\pageObjects\PetitionPage;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

class FormValidationTest extends BaseTest
{
    private RemoteWebDriver $driver;
    private PetitionPage $petitionPage;
    private static DBHelper $dbHelper;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$dbHelper = new DBHelper(self::getEntityManager());
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function setUp(): void
    {
        self::$dbHelper->addPetition();
        $this->driver = $this->getRemoteDriver();
        $this->driver->get($this->getBaseURL());
        $this->petitionPage = new PetitionPage($this->driver);
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    #[DataProvider('fullNameAdditionProvider')]
    #[TestDox('Filling full name: [$fullName] Expected: [$expected]')]
    public function testFullNameValidation($fullName, $expected): void
    {
        $this->petitionPage->fillFullNameInput($fullName);
        $this->petitionPage->clickOnSubmitButton();

        $this->assertSame($expected, $this->petitionPage->getFullNameErrorMessage());
    }

    public static function fullNameAdditionProvider(): array
    {
        return [
            ["", petitionPage::getErrorMessages()["empty_field_msg"]],
            [" autotest", petitionPage::getErrorMessages()["full_name_error_msg"]],
            ["autotest  ", petitionPage::getErrorMessages()["full_name_error_msg"]],
            ["  autotest", petitionPage::getErrorMessages()["full_name_error_msg"]],
        ];
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    #[DataProvider('emailAdditionProvider')]
    #[TestDox('Filling email: [$email] Expected: [$expected]')]
    public function testEmailValidation($email, $expected): void
    {
        $this->petitionPage->fillEmailInput($email);
        $this->petitionPage->clickOnSubmitButton();

        $this->assertSame($expected, $this->petitionPage->getEmailErrorMessage());
    }

    public static function emailAdditionProvider(): array
    {
        return [
            ["", petitionPage::getErrorMessages()["empty_field_msg"]],
            ["autotest", petitionPage::getErrorMessages()["email_error_msg"]],
            ["autotest@", petitionPage::getErrorMessages()["email_error_msg"]],
            ["@autotest", petitionPage::getErrorMessages()["email_error_msg"]],
            [" autotest@ ", petitionPage::getErrorMessages()["email_error_msg"]],
        ];
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function testSignatureValidation()
    {
        $this->petitionPage->clickOnSubmitButton();

        $this->assertSame(petitionPage::getErrorMessages()["signature_error_msg"], $this->petitionPage->getSignatureErrorMessage());
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    #[TestDox('Filling all field positive data and sign')]
    public function testFillingOfPositiveData()
    {
        $positiveData = ["full_name" => "autotest autotest", "email" => "autotest@gmail.com"];
        $this->petitionPage->fillFullNameInput($positiveData["full_name"]);
        $this->petitionPage->fillEmailInput($positiveData["email"]);
        $this->petitionPage->fillSignatureInput();
        $this->petitionPage->clickOnSubmitButton();

        $this->assertSame(petitionPage::getSuccessfullyMessages()["sign_successfully_msg"],
            $this->petitionPage->getSuccessfullyMessage());
    }

    public function tearDown(): void
    {
        $this->driver->quit();
    }
}