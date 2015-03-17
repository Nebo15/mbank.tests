<?php
namespace MBank\Tests\iOS;

class ProfileTest extends \MBank\Tests\MBankiOSTestCase
{
    public function testProfilePhoto()
    {
        $wallet = $this->createWalletAndLoadDashboard();

        // Add photo in profile
        $this->byName('Profile')->click();
        $this->byName('Add photo')->click();
        $this->byName('From gallery')->click();

        $this->waitForElementDisplayedByName('OK');
        $this->byName('OK')->click();
        // Load photo
        $this->waitForElementDisplayedByName('Moments');
        $this->byName('Moments')->click();

        // Check photo directory
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIACollectionView[1]/UIACollectionCell[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIACollectionView[1]/UIACollectionCell[1]')->click();

        $this->waitForElementDisplayedByName('OK');
        $this->byName('OK')->click();

        // Check photo was actually uploaded in app
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[2]');

        // Check that photo was actually uploaded
        sleep(4);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertTrue(array_key_exists('picture_url', $wallet_data['data']), "Can't find profile image");
    }
}
