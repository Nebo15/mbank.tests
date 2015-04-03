<?php
namespace MBank\Tests\iOS;


class PINCodeTest extends \MBank\Tests\MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    public function testSetPinCodeInSettings()
    {
        $wallet = $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        // Create Pin On Settings Page
        $this->byName('Turn on the PIN')->click();
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('PIN created');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPinOnLoginPage()
    {
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        // Create Pin
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByName('Your balance');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testCanSkipOnSecondStep()
    {
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        // Skip second step
        $this->byName('Skip')->click();
        $this->waitForElementDisplayedByName('Your balance');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testFirstAskPIN()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        // Logout and Login again
        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        $this->waitForElementDisplayedByName('Log out');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[2]')
             ->click();
        // Check SignINForm Present
        $this->waitForElementDisplayedByName('Sign in');
        // Login again and assert the PIN is skipped
        $this->byName('Sign in')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIASecureTextField[1]')
             ->value($wallet->password);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIAButton[1]')
             ->click();
        $this->waitForElementDisplayedByName('Profile');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);

    }

    public function testChangePin()
    {
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByName('Your balance');
        // Change Pin
        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        $this->byName('Change the PIN')->click();
        $this->fillPin();
        $this->changePin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->changePin();
        $this->waitForElementDisplayedByName('New PIN created');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPinWithWrongCode()
    {
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillIncorrectPin();
        $this->waitForElementDisplayedByName('Invalid PIN-code');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPinTimeout()
    {
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        // Create Pin
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByName('Your balance');
        // Check timeout Pin Immediately In Settings
        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        $this->waitForElementDisplayedByName('Immediately');
        // Lock Phone
        $this->backgroundApp(11);
        // Unlock And Check Code Screen
        $this->waitForElementDisplayedByName('Enter PIN-code');
        // Fill The Pin
        $this->fillPin();
        $this->waitForElementDisplayedByName('Settings');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPinReset()
    {
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        // Create Pin
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByName('Your balance');
        // Lock Phone
        $this->backgroundApp(11);
        // Unlock And Check Code Screen
        $this->waitForElementDisplayedByName('Enter PIN-code');
        // Fill Incorrect Pin
        $this->fillIncorrectPin();
        $this->waitForElementDisplayedByName('Invalid code. You have 4 attempts');
        $this->fillIncorrectPin();
        $this->waitForElementDisplayedByName('Invalid code. You have 3 attempts');
        $this->fillIncorrectPin();
        $this->waitForElementDisplayedByName('Invalid code. You have 2 attempts');
        $this->fillIncorrectPin();
        $this->waitForElementDisplayedByName('Invalid code. You have 1 attempt');
        $this->fillIncorrectPin();
        // Check SignINForm Present
        $this->waitForElementDisplayedByName('Sign in');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    protected function fillPin()
    {
        $this->byName('1')->click();
        $this->byName('2')->click();
        $this->byName('3')->click();
        $this->byName('4')->click();
    }

    protected function changePin()
    {
        $this->byName('2')->click();
        $this->byName('2')->click();
        $this->byName('2')->click();
        $this->byName('2')->click();
    }

    protected function fillIncorrectPin()
    {
        $this->byName('1')->click();
        $this->byName('1')->click();
        $this->byName('1')->click();
        $this->byName('1')->click();
    }
}
