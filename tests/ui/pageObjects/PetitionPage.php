<?php

namespace App\Tests\ui\pageObjects;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class PetitionPage
{
    private RemoteWebDriver $remoteWebDriver;

    private array $elements = [
        "full_name_input_xpath" => "//input[@name = 'fullname']",
        "email_input_xpath" => "//input[@name = 'email']",
        "submit_button_xpath" => "//input[@value = 'Подписать обращение']",
        "signature_input_xpath" => "//canvas[@id='sign_sketch']",
        "successfully_message_xpath" => "//strong[text()='Ваша подпись принята']",
        "full_name_error_xpath" => "//label[@id = 'fullname-error']",
        "email_error_xpath" => "//label[@id = 'email-error']",
        "signature_error_xpath" => "//label[@id = 'signature-error']",
    ];

    function __construct(RemoteWebDriver $remoteWebDriver)
    {
        $this->remoteWebDriver = $remoteWebDriver;
    }

    /**
     * @return array
     */
    public static function getErrorMessages(): array
    {
        return [
            "full_name_error_msg" => "Пожалуйста, введите имя и фамилию раздельно (отчество по желанию)",
            "email_error_msg" => "Пожалуйста, введите корректный email",
            "signature_error_msg" => "Пожалуйста, поставьте подпись",
            "empty_field_msg" => "Пожалуйста, заполните это поле",
        ];
    }

    public static function getSuccessfullyMessages(): array
    {
        return [
            "sign_success_msg" => "Ваша подпись принята"
        ];
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function fillFullNameInput(string $value): void
    {
        $this->remoteWebDriver->wait(5)
            ->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath(
                $this->elements["full_name_input_xpath"])))->sendKeys($value);
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function fillEmailInput(string $value): void
    {
        $this->remoteWebDriver->wait(5)
            ->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath(
                $this->elements["email_input_xpath"])))->sendKeys($value);
    }

    public function clickOnSubmitButton(): void
    {
        $submitButton = $this->remoteWebDriver->findElements(WebDriverBy::xpath($this->elements["submit_button_xpath"]));
        $this->remoteWebDriver->executeScript("arguments[0].click();", $submitButton);
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function getFullNameErrorMessage(): string
    {
        return $this->remoteWebDriver->wait(5)
            ->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath(
                $this->elements["full_name_error_xpath"])))->getText();
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function getEmailErrorMessage(): string
    {
        return $this->remoteWebDriver->wait(5)
            ->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath(
                $this->elements["email_error_xpath"])))->getText();
    }

    public function fillSignatureInput(): void
    {
        $this->remoteWebDriver->executeScript("window.focus();");
        $this->remoteWebDriver->executeScript("window.scrollTo(0,document.body.scrollHeight);");
        sleep(2);
        $signatureInput = $this->remoteWebDriver->findElement(WebDriverBy::xpath($this->elements["signature_input_xpath"]));
        $action = $this->remoteWebDriver->action();
        $action->moveToElement($signatureInput)->clickAndHold()
            ->moveByOffset(0, -100)
            ->release()
            ->perform();
        $this->remoteWebDriver->takeScreenshot("test.png");
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function getSignatureErrorMessage(): string
    {
        return $this->remoteWebDriver->wait(5)
            ->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath(
                $this->elements["signature_error_xpath"])))->getText();
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     */
    public function getSuccessfullyMessage(): string
    {
        return $this->remoteWebDriver->wait(5)
            ->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath(
                $this->elements["successfully_message_xpath"])))->getText();
    }
}