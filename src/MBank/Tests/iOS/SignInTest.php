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
        $this->markTestSkipped("Issue not resolved MBNK-1795");
        // $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]'); // Selecting element is an assertion by itself
        // $this->assertTrue($this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]')->displayed());
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
        $this->markTestSkipped("Issue not resolved MBNK-1795");
        // $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]'); // Selecting element is an assertion by itself
        // $this->assertTrue($this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]')->displayed());
    }

    // public function testResetPassword()
    // {

    // }

    // public function testResetPasswordWithWrongCode()
    // {

    // }

    // public function testResetPasswordWithRetyLimitExceeded()
    // {

    // }
}
