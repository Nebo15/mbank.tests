<?php
namespace MBank\Tests\iOS;

class PaymentsInTest extends \MBank\Tests\MBankiOSTestCase
{
    public function testPayIn()
    {
        $wallet = $this->createWalletAndLoadDashboard();
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
        $this->walletPayAndCheckBalance();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals('10010', $wallet_data['data']['amount']);
    }

    public function testPayInNegativeSum()
    {
        $this->createWalletAndLoadDashboard();

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
        // Pay Zero Sum
        $this->walletPayZeroSum();
        // Assert Alert Message
        $this->waitForElementDisplayedByName('Enter the amount');
        // Pay Incorrect Sum
        $this->byName('OK')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->clear();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->value('10000');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]')->click();
        // Assert Alert Message
        $this->waitForElementDisplayedByName('превышен лимит на остаток на счете кошелька');
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

    public function walletPayZeroSum()
    {
        $this->byName('Add funds')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[3]');
        // Pay Zero Sum
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->value('0');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]')->click();
    }

    public function walletPayAndCheckBalance()
    {
        $this->byName('Add funds')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[3]');
        // Check Balance
        $Balance = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[3]')->text();
        $this->assertEquals('10000.00a', $Balance);
        // Pay
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->value('10');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]')->click();
        // Check Transactions
        $this->waitForElementDisplayedByName('OK');
        $this->byName('OK')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Back to DashBoard and check the balance
        $this->byName('Menu icon')->click();
        $this->waitForElementDisplayedByName('Your balance');
        // Check Balance
        $Balance2 = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[2]')->text();
        $this->assertEquals('10010.00a', $Balance2);
    }
}

