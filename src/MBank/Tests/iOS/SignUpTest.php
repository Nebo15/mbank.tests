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
        if (APP_ENV == 'ios') {
            // Sign up
            $this->acceptAlert();
            $this->byElement('Registration_Button')->click();
            $this->fillCredentialsForm($this->wallet->phone, $this->wallet->password);
            $this->byElement('Registration_Button')->click();
            // Getting and filling out activation code for created wallet
            $this->waitForElementDisplayedByElement('Assert_PIN_field');
            $code = $this->getAPIService()->getWalletActivationCode($this->wallet->phone);
            $code_field = $this->byElement('Assert_PIN_field');
            $code_field->click();
            $code_field->clear();
            $code_field->value($code);
            $this->byElement('Confirm_Button')->click();
            // Skip PIN
            $this->waitForElementDisplayedByElement('Skip_Button');
            $this->byElement('Skip_Button')->click();
            // Assert Dashboard
            $this->waitForElementDisplayedByElement('Profile_Button');
        } elseif (APP_ENV == 'web') {
            $this->byElement('Registration_Button')->click();
            $this->fillCredentialsForm($this->wallet->phone, $this->wallet->password);
            $this->byElement('GO_Button')->click();
            // Getting and filling out activation code for created wallet
            $this->waitForElementDisplayedByElement('Assert_PIN_field');
            $code = $this->getAPIService()->getWalletActivationCode($this->wallet->phone);
            //TODO need click method for buttons
//            $this->byName(str_split($code)[1])->click();
//          //Assert Dashboard
//            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        /// Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    /**
     * @group SignUp
     */
    public function testSignUpWithWalletExists()
    {
        if (APP_ENV == 'ios') {
            // Sign up
            $this->acceptAlert();
            $this->byElement('Registration_Button')->click();
            $this->fillCredentialsForm('380931254212', $this->wallet->password);
            $this->byElement('Registration_Button')->click();
            $this->waitForElementDisplayedByElement('Exist_phone');
        } elseif (APP_ENV == 'web') {
            $this->byElement('Registration_Button')->click();
            $this->fillCredentialsForm('380931254212', $this->wallet->password);
            $this->byElement('GO_Button')->click();
            $this->waitForElementDisplayedByElement('Alert_message');
        }
    }

    /**
     * @group SignUp
     */
    public function testSignUpWithShortPassword()
    {
        if (APP_ENV == 'ios') {
            $this->acceptAlert();
        }
            $this->byElement('Registration_Button')->click();
            // Short password
            $this->fillCredentialsForm($this->wallet->phone, '1111');
            $this->byElement('Registration_Button')->click();
            $this->waitForElementDisplayedByElement('Password_len');
    }

    /**
     * @group SignUp
     */
    public function testSignUpPasswordStrengthChecker()
    {
        if (APP_ENV == 'ios') {
            $this->acceptAlert();
            $this->byElement('Registration_Button')->click();
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
                $this->fillPasswordField($data['password']);
                $this->assertEquals($this->byElement('Strength_text')->text(), $data['text']);
            }
        } elseif (APP_ENV == 'web') {
            $this->byElement('Registration_Button')->click();
            $passwords = [
                'слабый' => [
                    'password' => '!@#$%',
                    'text' => 'слабенькии',
                ],
                'средний' => [
                    'password' => '!@#$%aa',
                    'text' => 'среднии',
                ],
                'сильный' => [
                    'password' => '!@#$%aaqqqqqq',
                    'text' => 'хорош',
                ],
            ];
            foreach ($passwords as $stength => $data) {
                $this->fillPasswordField($data['password']);
                $this->assertEquals(trim($this->byElement('Strength_text')->text(),'\̆! '), $data['text']);
            }
        }
    }
}
