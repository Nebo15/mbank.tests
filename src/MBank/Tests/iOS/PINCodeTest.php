<?php
namespace MBank\Tests\iOS;

class PINCodeTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testSetPinCodeInSettings()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboard();
            $this->byName('Profile')->click();
            $this->byName('Settings')->click();
            // Create Pin On Settings Page
            $this->byName('Turn on the PIN')->click();
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('PIN created');
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }

    public function testPinOnLoginPage()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboardWithPIN();
            $this->waitForElementDisplayedByName('Skip');
            // Create Pin
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Pin created');
            $this->waitForElementDisplayedByName('Your balance');
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }

    public function testCanSkipOnSecondStep()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboardWithPIN();
            $this->waitForElementDisplayedByName('Skip');
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            // Skip second step
            $this->byName('Skip')->click();
            $this->waitForElementDisplayedByName('Your balance');
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }

    public function testFirstAskPIN()
    {
        if (APP_ENV == 'ios') {
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
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }

    public function testPinCode()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboardWithPIN();
            $this->waitForElementDisplayedByName('Skip');
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Pin created');
            $this->waitForElementDisplayedByName('Your balance');
            // Change Pin
            $this->byName('Profile')->click();
            $this->byName('Settings')->click();
            $this->byName('Change the PIN')->click();
            $this->fillPinCode('1234');
            $this->fillPinCode('5678');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            $this->fillPinCode('5678');
            $this->waitForElementDisplayedByName('New PIN created');
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }

    public function testPinWithWrongCode()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboardWithPIN();
            $this->waitForElementDisplayedByName('Skip');
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            $this->fillPinCode('0000');
            $this->waitForElementDisplayedByName('Invalid PIN-code');
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }

    public function testPinTimeout()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboardWithPIN();
            $this->waitForElementDisplayedByName('Skip');
            // Create Pin
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            $this->fillPinCode('1234');
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
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Settings');
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }

    public function testPinReset()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboardWithPIN();
            $this->waitForElementDisplayedByName('Skip');
            // Create Pin
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Enter the PIN once again');
            $this->fillPinCode('1234');
            $this->waitForElementDisplayedByName('Pin created');
            $this->waitForElementDisplayedByName('Your balance');
            // Lock Phone
            $this->backgroundApp(11);
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
            $this->waitForElementDisplayedByName('Sign in');
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($this->$wallet->phone);
        }
    }
}
