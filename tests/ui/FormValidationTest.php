<?php

namespace App\Tests\ui;

use App\Tests\ui\pageObjects\PetitionPage;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FormValidationTest extends TestCase
{
    private const selenium_server_url = "http://selenium:4444/wd/hub";
    private RemoteWebDriver $driver;
    private PetitionPage $petitionPage;

    public function setUp(): void
    {
        $this->driver = RemoteWebDriver::create(self::selenium_server_url, DesiredCapabilities::chrome());
        $this->driver->get("http://caddy/kosmos1");
        $this->petitionPage = new PetitionPage($this->driver);
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    #[DataProvider('fullNameAdditionProvider')]
    public function testFullNameValidation($fullName, $expected): void
    {
        $this->petitionPage->fillFullNameInput($fullName);
        $this->petitionPage->clickOnSubmitButton();

        $this->assertSame($expected, $this->petitionPage->getFullNameErrorMessage());
    }

    public static function fullNameAdditionProvider() : array
    {
        return [
            ["", petitionPage::getErrorMessages()["empty_field_msg"]],
            [" autotest", petitionPage::getErrorMessages()["full_name_error_msg"]],
            ["autotest ", petitionPage::getErrorMessages()["full_name_error_msg"]],
            ["autotest", petitionPage::getErrorMessages()["full_name_error_msg"]],
        ];
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    #[DataProvider('emailAdditionProvider')]
    public function testEmailValidation($fullName, $expected): void
    {
        $this->petitionPage->fillEmailInput($fullName);
        $this->petitionPage->clickOnSubmitButton();

        $this->assertSame($expected, $this->petitionPage->getEmailErrorMessage());
    }

    public static function emailAdditionProvider() : array
    {
        return [
            ["", petitionPage::getErrorMessages()["empty_field_msg"]],
            ["autotest", petitionPage::getErrorMessages()["email_error_msg"]],
            ["autotest@", petitionPage::getErrorMessages()["email_error_msg"]],
            ["autotest@ ", petitionPage::getErrorMessages()["email_error_msg"]],
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
    public function testFillingOfPositiveData()
    {
        $positiveData = ["full_name" => "autotest autotest", "email" => "autotest@gmail.com"];
        $this->petitionPage->fillFullNameInput($positiveData["full_name"]);
        $this->petitionPage->fillEmailInput($positiveData["email"]);
        $this->petitionPage->fillSignatureInput();
        $this->petitionPage->clickOnSubmitButton();
        $this->assertSame(petitionPage::getSuccessfullyMessages()["sign_success"], $this->petitionPage->getSuccessfullyMessage());
    }

    public function tearDown(): void
    {
        $this->driver->quit();
    }

}