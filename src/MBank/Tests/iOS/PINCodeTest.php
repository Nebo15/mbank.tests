<?php
namespace MBank\Tests\iOS;

class PINCodeTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testSetPinCodeInSettings()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Settings_Button');
        $this->byElement('Settings_Button')->click();
        // Create Pin On Settings Page
        $this->byName('Turn on the PIN')->click();
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('PIN created');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPinOnLoginPage()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByElement('Skip_Button');
        // Create Pin
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testCanSkipOnSecondStep()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByElement('Skip_Button');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        // Skip second step
        $this->byElement('Skip_Button')->click();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testFirstAskPIN()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Logout and Login again
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Settings_Button');
        $this->byElement('Settings_Button')->click();
        $this->waitForElementDisplayedByElement('Log out');
        $this->byElement('Log out')->click();
        // Check SignINForm Present
        $this->waitForElementDisplayedByElement('Sign_in_Button');
        // Login again and assert the PIN is skipped
        $this->byElement('Sign_in_Button')->click();
        $this->byElement('Pass_field')->value($wallet->password);
        $this->byElement('Sign')->click();
        $this->waitForElementDisplayedByElement('Profile_Button');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPinCode()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByElement('Skip_Button');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Change Pin
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Settings_Button');
        $this->tap(1, 247 ,233, 10); // Settings Button
        $this->byName('Change the PIN')->click();
        $this->fillPinCode('1234');
        $this->fillPinCode('5678');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPinCode('5678');
        $this->waitForElementDisplayedByName('New PIN created');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPinWithWrongCode()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByElement('Skip_Button');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPinCode('0000');
        $this->waitForElementDisplayedByName('Invalid PIN-code');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPinTimeout()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByElement('Skip_Button');
        // Create Pin
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check timeout Pin Immediately In Settings
        $this->byElement('Profile_Button')->click();
        $this->waitForElementDisplayedByElement('Settings_Button');
        $this->tap(1, 247 ,233, 10); // Settings Button
        $this->waitForElementDisplayedByName('Immediately');
        // Lock Phone
        $this->backgroundApp(10);
        // Unlock And Check Code Screen
        $this->waitForElementDisplayedByName('Enter PIN-code');
        // Fill The Pin
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByElement('Settings_Button');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPinReset()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboardWithPIN();
        $this->waitForElementDisplayedByElement('Skip_Button');
        // Create Pin
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPinCode('1234');
        $this->waitForElementDisplayedByName('Pin created');
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Lock Phone
        $this->backgroundApp(10);
        // Unlock And Check Code Screen
        $this->waitForElementDisplayedByName('Enter PIN-code');
        // Fill Incorrect Pin
        $this->fillPinCode('0000');
        $this->waitForElementDisplayedByName('Invalid code. You have 4 attempts');
        $this->fillPinCode('0000');
        $this->waitForElementDisplayedByName('Invalid code. You have 3 attempts');
        $this->fillPinCode('0000');
        $this->waitForElementDisplayedByName('Invalid code. You have 2 attempts');
        $this->fillPinCode('0000');
        $this->waitForElementDisplayedByName('Invalid code. You have 1 attempt');
        $this->fillPinCode('0000');
        // Check SignINForm Present
        $this->waitForElementDisplayedByElement('Sign_in_Button');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
