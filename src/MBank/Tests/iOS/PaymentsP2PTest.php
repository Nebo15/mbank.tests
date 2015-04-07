<?php
namespace MBank\Tests\iOS;

class PaymentsP2PTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testP2PFromWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]');
        // Pay into friend wallet
        $phone_number = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('+380931254212');
        // Fill pay form
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('10');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextView[1]')->value('BatmanPay');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        // Pay
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testP2PPayToNotVerifiedWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]');
        // Pay into friend wallet not indent
        $phone_number = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('+15662868526');
        // Fill pay form
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('10');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        // Assert Wallet Not Indent
        $this->waitForElementDisplayedByName('для совершения этого действия требуется идентификация пользователя кошелька');
        $this->byName('Cancel')->click();
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testP2PPayToYourself()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]');
        // Pay into friend wallet
        $phone_number = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value($wallet->phone);
        // Fill pay form
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('10');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        $this->waitForElementDisplayedByName('Can\'t transfer money to yourself');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    /**
     * TODO: верицифировать в платежах нужно через API (выпилить после правок метода в APIService)
     * @param $wallet
     */
    public function fillIndentForm($wallet)
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
        // Check alert messages before personalisation of user data
        $this->waitForElementDisplayedByName('Thank you! Your information will be reviewed as soon as possible. You will receive a notification after the process will be complete');
        $this->byName('Back')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Вернуться')->click();
        $this->waitForElementDisplayedByName('Profile');
    }
}
