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
        sleep(5);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertTrue(array_key_exists('picture_url', $wallet_data['data']), "Can't find profile image");
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testSetIdentificationUserData()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->identFillForm($wallet);
        // Check alert messages before personalisation of user data
        $this->waitForElementDisplayedByName('Thank you! Your information will be reviewed as soon as possible. You will receive a notification after the process will be complete');
        $this->byName('Back')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Вернуться')->click();
        $this->waitForElementDisplayedByName('Profile');
        // Personified User
        $this->getAPIService()->personifiedUserData($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testSetInvalidIdentificationUserData()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
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
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    /**
     * @param $wallet
     */
    public function identFillForm($wallet)
    {
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]')
             ->value($wallet->person->family_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')
             ->value($wallet->person->given_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[3]')
             ->value($wallet->person->patronymic_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[4]')
             ->value($wallet->person->passport_series_number);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]')
             ->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[5]')
             ->value('1970.11.01');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]')
             ->value($wallet->person->itn);
        $this->byName('Next')->click();
    }
}
