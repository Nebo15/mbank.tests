<?php

namespace MBank\Tests\iOS;


class SettingsTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testDeleteTempData()
    {
        $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('Settings')->click();
        $this->waitForElementDisplayedByName('Delete temporary data');
        $this->byName('Delete temporary data')->click();
        $this->byName('Yes')->click();
        $this->waitForElementDisplayedByName('Temporary data deleted');
    }


//TODO add tests for all settings
//        $this->waitForElementDisplayedByName('Public Offer');
//        $this->byName('Public Offer')->click();
//
//        $this->waitForElementDisplayedByName('Back to Settings icon');
//        $this->byName('Back to Settings icon')->click();
//
//        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIAButton[2]');
//        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIAButton[2]')
//            ->click();
//
//        $this->waitForElementDisplayedByName('Sign in');
}