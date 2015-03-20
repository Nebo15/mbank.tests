<?php
namespace MBank\Tests\iOS;

class PaymentsOutTest extends \MBank\Tests\MBankiOSTestCase
{
    public function testPayOutWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServices();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals('9990', $wallet_data['data']['amount']);
    }

    public function testPayOutCard()
    {
        $this->createWalletAndLoadDashboard();
        // Add Card
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        sleep(1);
        $this->byName('Add new card')->click();
        $this->fillCardVisaForm();
        // Back to DashBoard
        $this->byName('Back to Profile icon')->click();
        $this->byName('Menu icon')->click();
        // Pay from Card
        $this->cardPayServices();
        // Assert Transactions Log
        $this->waitForElementDisplayedByName('Repeat');
        // Pay from card retry
        $this->retryPayCard();
    }

    public function testPayOutMultibankWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServiceMultibank();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals('9939', $wallet_data['data']['amount']);
        // Retry Pay Wallet With Changes
        $this->retryPayWallet();
    }

    public function testPayOutTricolorWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServiceTricolor();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals('9999', $wallet_data['data']['amount']);
        // Retry Pay Wallet With Changes
    }

    public function walletPayServices()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('MLM')->click();
        $this->byName('Faberlic')->click();
        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue->click();
        $setValue->value('66');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('10');
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByName('Faberlic');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAStaticText[4]');
    }

    public function walletPayServiceMultibank()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Card2Card')->click();
        // Submit Multibank service
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[6]')->click();

        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay1
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('0931254212');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('044583151');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[10]/UIATextField[1]')
             ->value('1');
        $this->byName('Pay')->click();
        // Pay2
        $this->waitPayDisplay();
        $setValue2 = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue2->click();
        $setValue2->value('testlol');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('random');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[10]/UIATextField[1]')
             ->value('11111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[11]/UIATextField[1]')
             ->value('test');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]')
             ->value('tested');
        $this->byName('Pay')->click();
        // Confirm Pay
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(2);
        $this->byName('Pay')->click();

        // Check Transaction Log
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function cardPayServices()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('MLM')->click();
        $this->byName('Faberlic')->click();
        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue1 = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue1->click();
        $setValue1->value('50');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('11');
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

    public function walletPayServiceTricolor()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Cable networks')->click();
        $this->byName('НТВ Плюс')->click();
        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay1
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('1234567890');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
            ->value('1');
        $this->byName('Pay')->click();
        // Confirm Pay
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(1);
        $this->byName('Pay')->click();

        // Check Transaction Log
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    protected function fillCardVisaForm()
    {
        // Add card number
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->value('4652060724922338');
        // Add MM
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[2]')->value('01');
        // Add YY
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[3]')->value('17');
        // Add CVV code
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[4]')->value('989');
        // Add CardHolder
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[5]')->value('testtest');
        $this->byName('Add card')->click();
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
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

    public function retryPayWallet()
    {
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes, with changes')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Pay')->click();
        $this->waitPayDisplay();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]')
             ->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(2);
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function waitPayDisplay()
    {
        sleep(11);
        $this->waitForElementDisplayedByName('hex transparent');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        sleep(1);
    }
}
