<?php

namespace MBank\Tests\iOS;


class TransactionsTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testRepeatPay()
    {
        $wallet = $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        $this->fillCardForm('4652060724922338','01','17','989','testtest');
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
        // Back to DashBoard
        $this->byName('Back to Profile icon')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
        // Pay from Card
        $this->cardPayServices();
        $this->waitForElementDisplayedByName('Repeat');
        // Pay from card retry
        $this->retryPayCard();
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testRepeatPayWithChanges()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        $this->fillCardForm('4652060724922338','01','17','989','testtest');
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
        // Back to Dashboard
        $this->byName('Back to Profile icon')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
        $this->waitForElementDisplayedByName('Profile');
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet); //TODO заменить методом с APIService.php
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
        // Card Pay
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Repeat Pay With Changes
        $this->repeatPay();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayOutMultibankWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServiceMultibank($wallet);
        // Retry Pay Wallet With Changes
        $this->retryPayWallet();
        // Back To DashBoard
        $this->byName('Menu icon')->click();
        $this->waitForElementDisplayedByName('Your balance');
        // Check Balance In Wallet
        $Balance = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[2]')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'].'.00a');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function retryPayWallet()
    {
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes, with changes')->click();
        sleep(2);
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]')
             ->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(2);
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function cardPayServices()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Games and social networks')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->byName('Steam')->click();
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('50444');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('1');
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function walletPayServiceMultibank($wallet)
    {
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
        // Pay Card to Card
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Card2Card')->click();
        // Submit Multibank service
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[6]')->click();
        // Pay1
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Pay')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('0931254212');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
            ->value('044583151');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[10]/UIATextField[1]')
            ->value('1');
        $this->byName('Pay')->click();
        // Pay2
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('testlol');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('random');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[10]/UIATextField[1]')
             ->value('11111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[11]/UIATextField[1]')
             ->value('test');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]')
             ->value('tested');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]')
            ->click();
        // Pay
        $this->byName('Pay')->click();
        // Confirm Pay
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(2);
        $this->byName('Pay')->click();
        // Check Transaction Log
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function retryPayCard()
    {
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function repeatPay()
    {
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes, with changes')->click();
        $this->waitForElementDisplayedByName('Transfer');
        sleep(1);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
    }

    /**
     * @param $wallet //TODO выпилить после правок метода в файлике APIService
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
            ->value($wallet->person->passport_issued_at);
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
