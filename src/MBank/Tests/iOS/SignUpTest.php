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
        // Skip PIN
        $this->waitForElementDisplayedByName('Skip');
        $this->byName('Skip')->click();
        // Assert Dashboard
        $this->waitForElementDisplayedByName('Profile');
        // Delete wallet
        $this->getAPIService()->deleteWallet($this->wallet->phone);
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
        $this->acceptAlert();
        $this->byName('Registration')->click();

        $passwords = [
            'очень слабый' => [
                'password' => '111111',
                'text' => 'Very weak',
            ],
            'слабый' => [
                'password' => 'querty',
                'text' => 'Weak',
            ],
            'средний' => [
                'password' => '123querty',
                'text' => 'Medium',
            ],
            'сильный' => [
                'password' => '123quertyA@',
                'text' => 'Strong',
            ],
            'очень сильный' => [
                'password' => '123quertyA@zasftrhfkfid',
                'text' => 'Very Strong',
            ],
        ];

        foreach ($passwords as $stength => $data) {
            $this->fillCredentialsForm($this->wallet->phone, $data['password']);

            $strength_text = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIAStaticText[1]')->text();
            $this->assertEquals($strength_text, $data['text']);
        }
    }
}
