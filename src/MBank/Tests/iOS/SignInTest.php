<?php
namespace MBank\Tests\iOS;

class SignInTest extends \MBank\Tests\MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    public function testSignIn()
    {
        // Create wallet over API, if would fail if wallet is not created
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);

        // SignIn
        $this->signIn($this->wallet->phone, $this->wallet->password);

        // PIN should appear
        $this->waitForElementDisplayedByName('Skip');
        $this->byName('Skip');
    }

    public function testLoadDashboard()
    {
        // Create wallet over API
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);

        // SignIn and skip to Dashboard
        $this->loadDashboard($this->wallet->phone, $this->wallet->password);
    }

    public function testSignInWithIncorrectPassword()
    {
        // Create wallet over API
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);

        // Accept initial alert
        $this->acceptAlert();

        // Go to Sign In screen
        $this->byName('Sign in')->click();

        // Enter and submit login data
        $this->fillCredentialsForm($this->wallet->phone, $this->wallet->password."inc");
        $this->byName('Sign in')->click();

        // Wait for error displayed
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATextView[2]');

        // Checking error message
        $error_message = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATextView[2]');
        $this->assertEquals($error_message->text(), "Please, enter your login and password again");
        $this->assertTrue($error_message->displayed(), "Login error is not visible");
        $this->byName('Ok')->click();

        // We should stay on login screen
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]'); // Selecting element is an assertion by itself
        $this->assertTrue($this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]')->displayed());
    }

    public function testSignInWithWalletNotExists()
    {
        $this->acceptAlert();
        $this->byName('Sign in')->click();

        $this->fillCredentialsForm($this->wallet->phone, $this->wallet->password);
        $this->byName('Sign in')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATextView[2]');

        $error_message = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATextView[2]');
        $this->assertEquals($error_message->text(), "Please, enter your login and password again");
        $this->assertTrue($error_message->displayed(), "Login error is not visible");
        $this->byName('Ok')->click();

        // We should stay on login screen
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]'); // Selecting element is an assertion by itself
        $this->assertTrue($this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]')->displayed());
    }

     public function testResetPassword()
     {
         // Create wallet
         $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
         // SignIn
         $this->signIn($this->wallet->phone, $this->wallet->password);
         // Skip Pin
         $this->waitForElementDisplayedByName('Skip');
         $this->byName('Skip')->click();
         // Get New Password
         $code = $this->getAPIService()->changePassword($this->wallet->phone);
         // Change Pin
         $this->waitForElementDisplayedByName('Profile');
         $this->byName('Profile')->click();
         $this->byName('Settings')->click();
         $this->byName('Change password')->click();
         $this->waitForElementDisplayedByName('Request password');
         $this->byName('Yes')->click();
         $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIASecureTextField[1]');
         $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIASecureTextField[1]')
              ->value('jdsfhjkfsdhfkjs');
         $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')
              ->value($code);
         $this->byName('Confirm')->click();
         // Assert the password is changed
         $this->waitForElementDisplayedByName('Password changed');
         $this->byName('OK')->click();
         $this->waitForElementDisplayedByName('Sign in');
     }

    public function testResetPasswordWithWrongCode()
    {
        // Create wallet
        $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
        // SignIn
        $this->signIn($this->wallet->phone, $this->wallet->password);
        // Skip Pin
        $this->waitForElementDisplayedByName('Skip');
        $this->byName('Skip')->click();
        // Change Pin
        $this->waitForElementDisplayedByName('Profile');
        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        $this->byName('Change password')->click();
        $this->waitForElementDisplayedByName('Request password');
        $this->byName('Yes')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIASecureTextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIASecureTextField[1]')
            ->value('jdsfhjkfsdhfkjs');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')
            ->value('4321234');
        $this->byName('Confirm')->click();
        // Assert the password is changed
        $this->waitForElementDisplayedByName('код безопасности не совпадает с отправленным в смс');
        $this->byName('OK')->click();
    }

     public function testResetPasswordWithRetryLimitExceeded()
     {
         // Create wallet
         $this->getAPIService()->createActiveWallet($this->wallet->phone, $this->wallet->password);
         // SignIn
         $this->signIn($this->wallet->phone, $this->wallet->password);
         // Skip Pin
         $this->waitForElementDisplayedByName('Skip');
         $this->byName('Skip')->click();
         // Try Change Pin
         $this->waitForElementDisplayedByName('Profile');
         $this->byName('Profile')->click();
         $this->byName('Settings')->click();
         $this->byName('Change password')->click();
         $this->waitForElementDisplayedByName('Request password');
         $this->byName('Yes')->click();
         $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIASecureTextField[1]');
         $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIASecureTextField[1]')
             ->value('jdsfhjkfsdhfkjs');
         $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')
             ->value('4321234');
         $this->byName('Confirm')->click();
         // Check retry limit
         $this->checkRetryLimits();
         // Assert limit message
         $this->waitForElementDisplayedByName('превышен лимит попыток ввода кода безопасности');
     }

    public function checkRetryLimits()
    {
        $this->waitForElementDisplayedByName('код безопасности не совпадает с отправленным в смс');
        $this->byName('OK')->click();
        $this->byName('Confirm')->click();
        $this->waitForElementDisplayedByName('код безопасности не совпадает с отправленным в смс');
        $this->byName('OK')->click();
        $this->byName('Confirm')->click();
        $this->waitForElementDisplayedByName('код безопасности не совпадает с отправленным в смс');
        $this->byName('OK')->click();
        $this->byName('Confirm')->click();
        $this->waitForElementDisplayedByName('код безопасности не совпадает с отправленным в смс');
        $this->byName('OK')->click();
        $this->byName('Confirm')->click();
        $this->waitForElementDisplayedByName('код безопасности не совпадает с отправленным в смс');
        $this->byName('OK')->click();
        $this->byName('Confirm')->click();
    }
}
