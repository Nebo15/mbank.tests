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
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        $this->fillCardForm('4652060724922338','01','17','989','testtest');
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
        // Back to DashBoard
        $this->byName('Back to Profile icon')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Add funds')->click();
        // Pay
        $this->walletPaySum('10');
        // Check Transactions List
        $this->waitForElementDisplayedByName('OK');
        $this->byName('OK')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Back to DashBoard and check the balance
        $this->byName('Menu icon')->click();
        $this->waitForElementDisplayedByName('Your balance');
        // Check Balance in Wallet
        $Balance = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[2]')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'].'.00a');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayInNegativeSum()
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
        $this->byName('Menu icon')->click();
        $this->byName('Add funds')->click();
        // Pay Zero Sum
        $this->walletPaySum('0');
        // Assert Alert Message
        $this->waitForElementDisplayedByName('Enter the amount');
        // Pay Incorrect Sum
        $this->byName('OK')->click();
        $this->walletPaySum('10000');
        // Assert Alert Message
        $this->waitForElementDisplayedByName('превышен лимит на остаток на счете кошелька');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function walletPaySum($sum)
    {
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[3]');
        // Pay Zero Sum
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->value($sum);
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]')->click();
    }
}

