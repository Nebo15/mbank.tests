<?php
namespace MBank\Tests\iOS;


class PINCodeTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testSetPinCodeInSettings()
    {
        $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        // Create Pin On Settings Page
        $this->byName('Turn on the PIN')->click();
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('PIN created');

    }

    public function testPinOnLoginPage()
    {
        $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        // Create Pin
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByName('Your balance');

    }

    public function testCanSkipOnSecondStep()
    {
        $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        // Skip second step
        $this->byName('Skip')->click();
        $this->waitForElementDisplayedByName('Your balance');
    }

    public function testChangePin()
    {
        $this->createWalletAndLoadDashboardWithPIN();
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
    }

    public function testPinWithWrongCode()
    {
        $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillIncorrectPin();
        $this->waitForElementDisplayedByName('Code entered is invalid');
    }

    public function testPinTimeout()
    {
        $this->createWalletAndLoadDashboardWithPIN();
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
        $this->backgroundApp(1);
        // Unlock And Check Code Screen
        $this->waitForElementDisplayedByName('Enter code');
        // Fill The Pin
        $this->fillPin();
        $this->waitForElementDisplayedByName('Settings');

    }

    public function testPinReset()
    {
        $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByName('Skip');
        // Create Pin
        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByName('Your balance');
        // Lock Phone
        $this->backgroundApp(1);
        // Unlock And Check Code Screen
        $this->waitForElementDisplayedByName('Enter code');
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
