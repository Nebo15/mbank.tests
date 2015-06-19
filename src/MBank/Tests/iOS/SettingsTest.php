<?php
namespace MBank\Tests\iOS;

class SettingsTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testDeleteTempData()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Settings_Button');
        $this->byElement('Settings_Button')->click();
        $this->waitForElementDisplayedByElement('Delete_temporary_data');
        $this->byElement('Delete_temporary_data')->click();
        $this->byElement('YES_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Delete_TEMP');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPublicOfferAndPrivacyPolicy()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Settings_Button');
        $this->byElement('Settings_Button')->click();
        // Check Public Offer Displayed
        $this->waitForElementDisplayedByName('Public Offer');
        $this->byName('Public Offer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]');
        $this->waitForElementDisplayedByName('Back to Settings icon');
        $this->byName('Back to Settings icon')->click();
        $this->waitForElementDisplayedByName('Privacy Policy');
        // Check Privacy Policy Displayed
        $this->byName('Privacy Policy')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]');
        $this->waitForElementDisplayedByName('Back to Settings icon');
        $this->waitForElementDisplayedByName('Log out');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
