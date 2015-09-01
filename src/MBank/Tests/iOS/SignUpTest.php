<?php
namespace MBank\Tests\iOS;

use MBank\Tests\MBankiOSTestCase;

class SignUpTest extends MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        parent::setUp();
        $this->wallet = $this->generateWalletData();
    }

    /**
     * @group SignUp
     */
    public function testSignUp()
    {
        // Sign up
        $this->waitForElementDisplayedByElement('Registration_Button');
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Phone_Field_Button');
        $this->byElement('Phone_Field_Button')->click();
        $this->byElement('Phone_Field_Button')->value($this->wallet->phone);
        $this->waitForElementDisplayedByElement('Password_Field_Button');
        $this->byElement('Password_Field_Button')->click();
        $this->byElement('Password_Field_Button')->value($this->wallet->password);
        $this->byElement('Done_Button')->click();
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_PIN_field');
        $code = $this->getAPIService()->getWalletActivationCode($this->wallet->phone);
        // Getting and filling out activation code for created wallet
        if (APP_PLATFORM == 'ios') {
            $this->waitForElementDisplayedByElement('Assert_PIN_field');
            $this->byElement('Assert_PIN_field')->value($code);
            $this->byElement('Confirm_Button')->click();
            // Skip PIN
            $this->waitForElementDisplayedByElement('Skip_Button');
            $this->byElement('Skip_Button')->click();
        } elseif (APP_PLATFORM == 'web') {
            $this->byElement(str_split($code)[1])->click();
            $this->byElement(str_split($code)[2])->click();
            $this->byElement(str_split($code)[3])->click();
            $this->byElement(str_split($code)[4])->click();
            $this->byElement(str_split($code)[5])->click();
        }
        // Assert Dashboard
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    /**
     * @group SignUp
     */
    public function testNonActiveWalletRecovery()
    {
        // Sign up
        $this->waitForElementDisplayedByElement('Registration_Button');
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Phone_Field_Button');
        $this->byElement('Phone_Field_Button')->click();
        $this->byElement('Phone_Field_Button')->value($this->wallet->phone);
        $this->waitForElementDisplayedByElement('Password_Field_Button');
        $this->byElement('Password_Field_Button')->click();
        $this->byElement('Password_Field_Button')->value($this->wallet->password);
        $this->byElement('Done_Button')->click();
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_PIN_field');
        $this->backToLogin();
        $this->waitForElementDisplayedByElement('HaveAnAccount');
        $this->byElement('HaveAnAccount')->click();
        $this->waitForElementDisplayedByElement('ForgotPassword');
        $this->byElement('ForgotPassword')->click();
        if (APP_PLATFORM == 'web') {
            $this->waitForElementDisplayedByElement('PasswordField');
            sleep(1);
            $this->byElement('PasswordField')->click();
            $this->byElement('PasswordField')->value(trim(($this->wallet->phone), "+"));
        }
        $this->waitForElementDisplayedByElement('Request code');
        $this->byElement('Request code')->click();
        $this->waitForElementDisplayedByElement('WalletNotActiveMessage');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    /**
     * @group SignUp
     */
    public function testSignUpWithWalletExists()
    {
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Phone_Field_Button');
        $this->byElement('Phone_Field_Button')->click();
        $this->byElement('Phone_Field_Button')->value('+380931254212');
        $this->waitForElementDisplayedByElement('Password_Field_Button');
        $this->byElement('Password_Field_Button')->click();
        $this->byElement('Password_Field_Button')->value('qweqweq');
        $this->byElement('Done_Button')->click();
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Exist_phone');
    }

    /**
     * @group SignUp
     */
    public function testSignUpWithShortPassword()
    {
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Phone_Field_Button');
        $this->byElement('Phone_Field_Button')->click();
        $this->byElement('Phone_Field_Button')->value($this->wallet->phone);
        $this->waitForElementDisplayedByElement('Password_Field_Button');
        $this->byElement('Password_Field_Button')->click();
        // Fill Short password
        $this->byElement('Password_Field_Button')->value('qqqq');
        $this->byElement('Done_Button')->click();
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Password_len');
    }

    /**
     * @group SignUp
     */
    public function testSignUpWithLongPassword()
    {
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Phone_Field_Button');
        $this->byElement('Phone_Field_Button')->click();
        $this->byElement('Phone_Field_Button')->value($this->wallet->phone);
        $this->waitForElementDisplayedByElement('Password_Field_Button');
        $this->byElement('Password_Field_Button')->click();
        // Fill Short password
        $this->byElement('Password_Field_Button')->value('aaaaaaaaaaaaaaaaaaA1');
        $this->byElement('Done_Button')->click();
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_PIN_field');
        $code = $this->getAPIService()->getWalletActivationCode($this->wallet->phone);
        // Getting and filling out activation code for created wallet
        if (APP_PLATFORM == 'ios') {
            $this->waitForElementDisplayedByElement('Assert_PIN_field');
            $this->byElement('Assert_PIN_field')->value($code);
            $this->byElement('Confirm_Button')->click();
            // Skip PIN
            $this->waitForElementDisplayedByElement('Skip_Button');
            $this->byElement('Skip_Button')->click();
        } elseif (APP_PLATFORM == 'web') {
            $this->byElement(str_split($code)[1])->click();
            $this->byElement(str_split($code)[2])->click();
            $this->byElement(str_split($code)[3])->click();
            $this->byElement(str_split($code)[4])->click();
            $this->byElement(str_split($code)[5])->click();
        }
        // Assert Dashboard
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    /**
     * @group SignUp
     */
    public function testSignUpPasswordStrengthChecker()
    {
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Registration_Button');
        if (APP_PLATFORM == 'ios') {
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
        } elseif (APP_PLATFORM == 'web') {
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
                $this->byElement('Password_Field_Button')->clear();
                $this->byElement('Password_Field_Button')->click();
                $this->byElement('Password_Field_Button')->value($data['password']);
                $this->assertEquals(trim($this->byElement('Strength_text')->text(), '\̆! '), $data['text']);
            }
        }
    }
}
