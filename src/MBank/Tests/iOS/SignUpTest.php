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
        // Assert the wallet created
        $this->getAPIService()->getWallet($this->wallet->phone, $this->wallet->password);
        //TODO Wallet status
    }

    public function testSignUpWithWalletExists()
    {
        // Sign up
        $this->acceptAlert();
        $this->byName('Registration')->click();
        $this->fillCredentialsForm('380931254212', $this->wallet->password);
        $this->byName('Registration')->click();
        $this->waitForElementDisplayedByName('пользователь с таким номером телефона уже зарегистрирован');
    }

     public function testSignUpShortPasswordStrengthChecker()
     {
         $this->acceptAlert();
         $this->byName('Registration')->click();
         // Short password
         $this->fillCredentialsForm($this->wallet->phone, '1111');
         $this->byName('Registration')->click();
         $this->waitForElementDisplayedByName('пароль должен быть не короче 6 символов');
     }

    public function testSignUpLongPasswordStrengthChecker()
    {
        $this->acceptAlert();
        $this->byName('Registration')->click();
        // Long password
        $this->fillCredentialsForm($this->wallet->phone, '11111111111111111111');
        $this->byName('Registration')->click();
        $this->waitForElementDisplayedByName('Password invalid');
    }
}
