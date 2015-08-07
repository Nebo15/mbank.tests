<?php
namespace MBank\Tests\iOS;

class SettingsTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Settings
     */
    public function testDeleteTempData()
    {
        $wallet = $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Settings_Button');
        $this->byElement('Settings_Button')->click();
        $this->waitForElementDisplayedByElement('Delete_temporary_data');
        $this->byElement('Delete_temporary_data')->click();
        if (APP_ENV == 'ios') {
            $this->byElement('YES_Button')->click();
            $this->waitForElementDisplayedByElement('Assert_Delete_TEMP');
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Settings
     */
    public function testPublicOfferAndPrivacyPolicy()
    {
        if (APP_ENV == 'web') {
            $this->waitForElementDisplayedByElement('Public Offer');
            $this->byElement('Public Offer')->click();
            $this->waitForElementDisplayedByElement('Public_Offer_Assert');
            sleep(2);
            $this->tap(1, 50, 62, 10); // Back To DashBoard
            $this->waitForElementDisplayedByElement('Privacy Policy');
            $this->byElement('Privacy Policy')->click();
            $this->waitForElementDisplayedByElement('Privacy_Policy_Assert');
        } elseif (APP_ENV == 'ios') {
            $this->loadDashboard('+380931254212', 'qwerty');
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->submitProfileButton();
            $this->waitForElementDisplayedByElement('Settings_Button');
            $this->byElement('Settings_Button')->click();
            // Check Public Offer Displayed
            $this->waitForElementDisplayedByName('Public Offer');
            $this->byName('Public Offer')->click();
            // Assert Public Offer
            $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]');
            $this->waitForElementDisplayedByName('Back to Settings icon');
            $this->byName('Back to Settings icon')->click();
            $this->waitForElementDisplayedByName('Privacy Policy');
            // Check Privacy Policy Displayed
            $this->byName('Privacy Policy')->click();
            // Assert Privacy Policy
            $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]');
            $this->waitForElementDisplayedByName('Back to Settings icon');
            $this->waitForElementDisplayedByName('Log out');
        }
    }
}
