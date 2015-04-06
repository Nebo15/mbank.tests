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

    /**
     * @group SignUp
     */
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
        // Assert wallet status is true
        $wallet_data = $this->getAPIService()->getWallet($this->wallet->phone, $this->wallet->password);
        // $this->assertTrue($wallet_data['data']['verified']);

        // TODO: Check that initial PIN setup shows after SignUp
        // $this->byName('Skip')->click();
    }

    /**
     * @group SignUp
     */
    public function testSignUpWithWalletExists()
    {
        // Sign up
        $this->acceptAlert();
        $this->byName('Registration')->click();
        $this->fillCredentialsForm('380931254212', $this->wallet->password);
        $this->byName('Registration')->click();
        $this->waitForElementDisplayedByName('пользователь с таким номером телефона уже зарегистрирован');
    }

    /**
     * @group SignUp
     */
     public function testSignUpWithShortPassword()
     {
         $this->acceptAlert();
         $this->byName('Registration')->click();
         // Short password
         $this->fillCredentialsForm($this->wallet->phone, '1111');
         $this->byName('Registration')->click();
         $this->waitForElementDisplayedByName('пароль должен быть не короче 6 символов');
    }

    /**
     * @group SignUp
     */
    public function testSignUpPasswordStrengthChecker()
    {
        $passwords = [
            'very_weak' => [
                'password' => '111111',
                'text' => 'очень слабый',
            ],
            'weak' => [
                'password' => 'querty',
                'text' => 'слабый',
            ],
            'average' => [
                'password' => '123querty',
                'text' => 'средний',
            ],
            'medium' => [
                'password' => '123quertyA@',
                'text' => 'сильный',
            ],
            'strong' => [
                'password' => '123quertyA@zasftrhfkfid',
                'text' => 'очень сильный',
            ],
        ];
        $this->acceptAlert();
        $this->byName('Registration')->click();

        foreach($passwords as $stength => $data) {
            $this->fillCredentialsForm($this->wallet->phone, $data['password']);
            // TODO: проверять текст "силы пароля"
            // $strength_text = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIAStaticText[1]')
            // $this->assertEqual($strength_text, $data['text']);
        }
    }
}
