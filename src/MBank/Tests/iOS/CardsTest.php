<?php

namespace MBank\Tests\iOS;


class CardsTest extends \MBank\Tests\MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    public function testAddCard()
    {
        $this->createWalletAndLoadDashboard();
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        $this->fillCardVisaForm1();
        $this->fillCardVisaForm2();
        // Remove One Card
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAButton[1]')
             ->click();
        $this->byName('Да')->click();
        // Assert Card2 is removed
        sleep(2);
        $card2Deleted = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]')->text();
        $this->assertEquals('row 1 of 1', $card2Deleted);
        // Assert Card1 is present
        $card1Present = $this->byName('4652 06** **** 2338');
        $this->assertTrue($card1Present->displayed());
        // Delete wallet
        $this->getAPIService()->deleteWallet($this->wallet->phone);
    }

    protected function fillCardVisaForm1()
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

    protected function fillCardVisaForm2()
    {
        // Add card number
        $this->byName('Add new card')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->value('5417150396276825');
        // Add MM
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[2]')->value('01');
        // Add YY
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[3]')->value('17');
        // Add CVV code
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[4]')->value('789');
        // Add CardHolder
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[5]')->value('testtestd');
        $this->byName('Add card')->click();
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('5417 15** **** 6825');
    }

    public function testCashDisplayed()
    {
        $this->createWalletAndLoadDashboard();
        $this->byName('Add funds')->click();
        // Check Cash Field
        $this->waitForElementDisplayedByName('Add card');
        $this->byName('Cash')->click();
        sleep(4);
        // Assert The Map Is Displayed
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAMapView[1]/UIAElement[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($this->wallet->phone);
    }
}
