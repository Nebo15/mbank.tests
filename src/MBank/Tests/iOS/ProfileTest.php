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

    public function testTransferP2P()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();

        $this->waitForElementDisplayedByName('Attention!');

        $this->byName('Next')->click();

        // Set Valid Data
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]')
            ->value($wallet->person->family_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')
            ->value($wallet->person->given_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[3]')
            ->value($wallet->person->patronymic_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[4]')
            ->value($wallet->person->passport_series_number);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[5]')
            ->value($wallet->person->passport_issued_at);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]')
            ->value($wallet->person->itn);

// TODO Crashed on validation
//        $this->byName('Next')->click();

        sleep(111);
    }

    public function testTransferInvalidData()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();

        $this->waitForElementDisplayedByName('Attention!');

        $this->byName('Next')->click();

        // Set Invalid Data
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]')->value('lol');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('name');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[3]')->value('test');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[4]')->value('furman');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[5]')
            ->value($wallet->person->passport_issued_at);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]')->value("44/444");

        $this->byName('Next')->click();

        $this->waitForElementDisplayedByName('Invalid personal number');

    }
}
