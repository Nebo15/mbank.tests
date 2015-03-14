<?php
namespace MBank\Tests;

abstract class MBankiOSTestCase extends \PHPUnit_Extensions_AppiumTestCase
{
    public static $browsers = array(
        array(
            'local' => true,
            'port' => 4723,
            'seleniumServerRequestsTimeout' => 120,
            'browserName' => '',
            'desiredCapabilities' => array(
                'deviceName' => 'iPhone 6',
                'platformVersion' => '8.2',
                'platformName' => 'iOS',
                'app' => APP_PATH,
                'newCommandTimeout' => 160,
                'sendKeyStrategy' => 'setValue',
                'launchTimeout' => 15000,
            )
        )
    );

    protected function assertWalletCreated($response, $message = "Failed to create wallet")
    {
        $this->assertTrue($response['meta']['code'] == 200, $message, $response);
    }

    protected function waitForElementDisplayedByName($name, $timeout = 20000)
    {
        $this->waitUntil(function () use ($name) {
            $el = $this->byName($name);
            return $el && $el->displayed();
        }, $timeout);
    }

    protected function waitForElementDisplayedByXPath($xpath, $timeout = 20000)
    {
        $this->waitUntil(function () use ($xpath) {
            $el = $this->byXPath($xpath);
            return $el && $el->displayed();
        }, $timeout);
    }

    protected function fillPhoneNumberField($phone_number)
    {
        // Remove + sign in the beginning of phone number
        if ($phone_number[0] == "+") {
            $phone_number = substr($phone_number, 1);
        }

        $phone_number_field = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]');
        $phone_number_field->click();
        $phone_number_field->clear();
        $phone_number_field->value($phone_number);
    }

    protected function fillPasswordField($password)
    {
        $password_field = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIASecureTextField[1]');
        $password_field->click();
        $password_field->clear();
        $password_field->value($password);
    }

    protected function fillCredentialsForm($login, $password)
    {
        $this->fillPhoneNumberField($login);
        $this->fillPasswordField($password);
    }

    protected function fillSignUpForm($login, $password)
    {
        $this->fillCredentialsForm($login, $password);
    }

    protected function fillPinCode($code)
    {
        $this->assertEquals(strlen($code), 4, "PIN code should be 4 number long");

        for ($i = 0; $i < strlen($code); $i++) {
            $this->byName($code[$i])->click();
        }
    }

    protected function skipPinCode()
    {
        $this->waitForElementDisplayedByName('Skip');
        $this->byName('Skip')->click();
    }

    protected function signIn($phone, $password)
    {
        $this->acceptAlert();
        $this->byName('Sign in')->click();
        $this->fillCredentialsForm($phone, $password);
        $this->byName('Sign in')->click();
    }

    protected function loadDashboard($phone, $password)
    {
        $this->signIn($phone, $password);
        $this->skipPinCode();
    }

    protected function generateWalletData()
    {
        $generator = new \MBank\Services\WalletGenerationService();
        return $generator->getWallet();
    }

    protected function getAPIService()
    {
        return new \MBank\Services\MBankAPIService();
    }
}
