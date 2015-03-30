<?php

namespace MBank\Tests\iOS;


class SettingsTest extends \MBank\Tests\MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    public function testDeleteTempData()
    {
        $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        $this->waitForElementDisplayedByName('Delete temporary data');
        $this->byName('Delete temporary data')->click();
        $this->byName('Yes')->click();
        $this->waitForElementDisplayedByName('Temporary data deleted');
        // Delete wallet
        $this->getAPIService()->deleteWallet($this->wallet->phone);
    }


    public function testPublicOfferAndPrivacyPolicy()
    {
        $this->createWalletAndLoadDashboard();

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
        $this->getAPIService()->deleteWallet($this->wallet->phone);
    }

    public function testLimits()
    {
        $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        // Check the limits is displayed
        $this->byName('View limits')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableGroup[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($this->wallet->phone);
    }
}