<?php
namespace MBank\Tests\iOS;

use MBank\Tests\MBankiOSTestCase;

class SignUpTest extends MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    public function testSignUp()
    {
        // Sign up
        $this->acceptAlert();
        $this->byName('Registration')->click();
        $this->fillCredentialsForm($this->wallet->phone, $this->wallet->password);
        $this->byName('Registration')->click();

        // Getting and filling out activation code for created wallet
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATextField[1]');
        $code = $this->getAPIService()->getWalletActivationCode($this->wallet->phone);
        $code_field = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATextField[1]');
        $code_field->click();
        $code_field->clear();
        $code_field->value($code);

        $this->byName('Confirm')->click();

        // PIN should appear
        $this->waitForElementDisplayedByName('Skip');
        $this->byName('Skip');
    }

    // public function testSignUpWithWalletExists()
    // {

    // }

    // public function testSignUpPasswordStrengthChecker()
    // {

    // }
}
