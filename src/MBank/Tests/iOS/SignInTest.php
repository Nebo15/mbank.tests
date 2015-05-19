<?php
namespace MBank\Tests\iOS;

class SignInTest extends \MBank\Tests\MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    /**
     * @group SignIn
     */
    public function testSignIn()
    {
        // Create wallet over API, if would fail if wallet is not created
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
        $this->signIn($this->wallet->phone, $this->wallet->password);
        if (APP_ENV == 'ios') {
            // PIN should appear
            $this->waitForElementDisplayedByElement('Skip_Button');
            $this->byElement('Skip_Button')->click();
        } elseif (APP_ENV == 'web') {
            $this->waitForElementDisplayedByElement('Your_balance_Button');
        }
        /// Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    /**
     * @group SignIn
     */
    public function testLoadDashboard()
    {
        // Create wallet over API
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
        // SignIn and skip to Dashboard
        $this->loadDashboard($this->wallet->phone, $this->wallet->password);
        /// Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    public function testSignInWithIncorrectPassword()
    {
        if (APP_ENV == 'web') {
        $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Create wallet over API
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
        // Accept initial alert
        if (APP_ENV == 'ios') {
            $this->acceptAlert();
        }
        // Go to Sign In screen
        $this->byElement('Sign_in_Button')->click();
        // Enter and submit login data
        $this->fillCredentialsForm($this->wallet->phone, $this->wallet->password."inc");
        $this->byElement('Sign_in_Button')->click();
        // Wait for error displayed
        $this->waitForElementDisplayedByElement('Error_Message');
        // Checking error message
        $error_message = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATextView[2]');
        $this->assertEquals($error_message->text(), "You have entered an invalid phone number or password. Please, try again.");
        $this->assertTrue($error_message->displayed(), "Login error is not visible");
        $this->byElement('OK_Button')->click();
        // We should stay on login screen
        $this->waitForElementDisplayedByElement('Assert_Screen'); // Selecting element is an assertion by itself
        /// Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    public function testSignInWithWalletNotExists()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $this->acceptAlert();
        $this->byElement('Sign_in_Button')->click();
        $this->fillCredentialsForm($this->wallet->phone, $this->wallet->password);
        $this->byElement('Sign_in_Button')->click();
        $this->waitForElementDisplayedByElement('Error_Message');
        $error_message = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATextView[2]');
        $this->assertEquals($error_message->text(), "You have entered an invalid phone number or password. Please, try again.");
        $this->assertTrue($error_message->displayed(), "Login error is not visible");
        $this->byElement('OK_Button')->click();
        // We should stay on login screen
        $this->waitForElementDisplayedByElement('Login_Screen');
    }

    public function testResetPassword()
    {
         // Create wallet
         $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
         $this->signIn($this->wallet->phone, $this->wallet->password);
        if (APP_ENV == 'ios') {
            $this->skipPinCode();
            // Get New Password
            $code = $this->getAPIService()->getNewPassword($this->wallet->phone);
            // Change Password
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->byElement('Profile_Button')->click();
            $this->byElement('Settings_Button')->click();
            $this->byElement('Change_password_Button')->click();
            $this->waitForElementDisplayedByElement('Request_Password');
            $this->byElement('YES_Button')->click();
            $this->waitForElementDisplayedByElement('Secure_Field_1');
            $this->byElement('Secure_Field_1')->value('jdsfhjkfsdhfkjs');
            $this->byElement('Secure_Field_2')->value($code);
            $this->byElement('Confirm_Button')->click();
            // Assert the password is changed
            $this->waitForElementDisplayedByElement('Change_Password_Alert');
            $this->byElement('OK_Button')->click();
            $this->waitForElementDisplayedByElement('Sign_in_Button');
        } elseif (APP_ENV == 'web') {
            $code = $this->getAPIService()->getNewPassword($this->wallet->phone);
            // Change Password
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            sleep(1);
            $this->tap(1, 214, 218, 10); //Profile Button
            $this->byElement('Settings_Button')->click();
            $this->byElement('Change_password_Button')->click();
            $this->waitForElementDisplayedByElement('Secure_Field_1');
            $this->byElement('Secure_Field_1')->value('jdsfhjkfsdhfkjs');
            $this->byElement('Secure_Field_2')->value($code);
            $this->byElement('Confirm_Button')->click();
            // Assert the password is changed
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            //TODO need asserts message for web
        }
        /// Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    public function testResetPasswordWithWrongCode()
    {
        // Create wallet
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
        $this->signIn($this->wallet->phone, $this->wallet->password);
        if (APP_ENV == 'ios') {
            $this->skipPinCode();
            // Change Password
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->byElement('Profile_Button')->click();
            $this->byElement('Settings_Button')->click();
            $this->byElement('Change_password_Button')->click();
            $this->waitForElementDisplayedByElement('Request_Password');
            $this->byElement('YES_Button')->click();
            $this->waitForElementDisplayedByElement('Secure_Field_1');
            $this->byElement('Secure_Field_1')->value('jdsfhjkfsdhfkjs');
            $this->byElement('Secure_Field_2')->value('4433456');
            $this->byElement('Confirm_Button')->click();
            // Assert Alert Message
            $this->waitForElementDisplayedByElement('Error_Password');
        } elseif (APP_ENV == 'web') {
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            sleep(1);
            $this->tap(1, 214, 218, 10); //Profile Button
            $this->byElement('Settings_Button')->click();
            $this->byElement('Change_password_Button')->click();
            $this->waitForElementDisplayedByElement('Secure_Field_1');
            $this->byElement('Secure_Field_1')->value('jdsfhjkfsdhfkjs');
            $this->byElement('Secure_Field_2')->value('4433456');
            $this->byElement('Confirm_Button')->click();
            // Assert Alert Message
            $this->waitForElementDisplayedByElement('Alert_message');
        }
        /// Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }

    public function testResetPasswordWithRetryLimitExceeded()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Create wallet
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
        // SignIn
        $this->signIn($this->wallet->phone, $this->wallet->password);
        $this->skipPinCode();
        // Try Change Password
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Profile_Button')->click();
        $this->byElement('Settings_Button')->click();
        $this->byName('Change password')->click();
        $this->waitForElementDisplayedByElement('Request_Password');
        $this->byElement('YES_Button')->click();
        $this->waitForElementDisplayedByElement('Secure_Field_1');
        $this->byElement('Secure_Field_1')->value('jdsfhjkfsdhfkjs');
        $this->byElement('Secure_Field_2')->value('4321234');
        $this->byElement('Confirm_Button')->click();
        // Check retry limit
        $this->waitForElementDisplayedByElement('Error_Password');
        $this->byElement('OK_Button')->click();
        $this->byElement('Confirm_Button')->click();
        $this->waitForElementDisplayedByElement('Error_Password');
        $this->byElement('OK_Button')->click();
        $this->byElement('Confirm_Button')->click();
        $this->waitForElementDisplayedByElement('Error_Password');
        $this->byElement('OK_Button')->click();
        $this->byElement('Confirm_Button')->click();
        $this->waitForElementDisplayedByElement('Error_Password');
        $this->byElement('OK_Button')->click();
        $this->byElement('Confirm_Button')->click();
        $this->waitForElementDisplayedByElement('Error_Password');
        $this->byElement('OK_Button')->click();
        $this->byElement('Confirm_Button')->click();
        // Assert limit message
        $this->waitForElementDisplayedByElement('Limit_message');
        /// Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->wallet->phone);
        }
    }
}
