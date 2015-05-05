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
        $this->byElement('Profile_Button')->click();
        $this->byElement('Settings_Button')->click();
        $this->waitForElementDisplayedByElement('Delete_temporary_data');
        $this->byElement('Delete_temporary_data')->click();
        $this->byElement('YES_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Delete_TEMP');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    /**
     * @group Settings
     */
    public function testPublicOfferAndPrivacyPolicy()
    {
        $wallet = $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        // Check Public Offer Displayed
        $this->waitForElementDisplayedByName('Public Offer');
        $this->byName('Public Offer')->click();
        $this->waitForElementDisplayedByName('Back to Settings icon');
        $this->byName('Back to Settings icon')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIAButton[2]');
        // Check Privacy Policy Displayed
        $this->byName('Privacy Policy')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAWebView[1]');
        $this->waitForElementDisplayedByName('Back to Settings icon');
        $this->waitForElementDisplayedByName('Log out');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    /**
     * @group Settings
     */
    public function testSetMail()
    {
        $wallet = $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        // Set Mail
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATableView[1]/UIATableCell[6]/UIATextField[1]')
             ->value('sad-nu@mail.ru');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]')->click();
        $this->byName('Menu icon')->click();
        $this->waitForElementDisplayedByName('Your balance');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }
}
