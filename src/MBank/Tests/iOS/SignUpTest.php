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
        if (APP_ENV == 'ios') {
            // Getting and filling out activation code for created wallet
            $this->waitForElementDisplayedByElement('Assert_PIN_field');
            $this->byElement('Assert_PIN_field')->value($code);
            $this->byElement('Confirm_Button')->click();
            // Skip PIN
            $this->waitForElementDisplayedByElement('Skip_Button');
            $this->byElement('Skip_Button')->click();
        } elseif (APP_ENV == 'web') {
            // Getting and filling out activation code for created wallet
//            //TODO need click method for buttons
//            $code1 = (str_split($code)[1]);
//            $this->byName($code1)->click();
//            $this->byName(str_split($code)[3])->click();
//            $this->byName(str_split($code)[4])->click();
//            $this->byName(str_split($code)[5])->click();
        }
        // Assert Dashboard
        $this->waitForElementDisplayedByElement('Your_balance_Button');
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
    public function testSignUpPasswordStrengthChecker()
    {
        $this->byElement('Registration_Button')->click();
        $this->waitForElementDisplayedByElement('Registration_Button');
        if (APP_ENV == 'ios') {
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
