<?php

namespace MBank\Tests\iOS;


class CardsTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Cards
     */
    public function testAddCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add First Card
        $this->byName('Add new card')->click();
        $this->fillCardForm('4652060724922338','01','17','989','testtest');
        // Assert First Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
        // Add Second Card
        $this->byName('Add new card')->click();
        $this->fillCardForm('5417150396276825','01','17','789','testtestd');
        // Assert Second Card Is Added
        $this->waitForElementDisplayedByName('5417 15** **** 6825');
        // Remove Second Card
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAButton[1]')
             ->click();
        $this->byName('Да')->click();
        // Assert Second Is Removed
        sleep(2);
        $card2Deleted = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]')->text();
        $this->assertEquals('moved to row 1 of 1', $card2Deleted);
        // Assert First Card Is Present
        $card1Present = $this->byName('4652 06** **** 2338');
        $this->assertTrue($card1Present->displayed());
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    /**
     * @group Cards
     */
    public function testCashDisplayed()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Add funds')->click();
        // Check Cash Field
        $this->waitForElementDisplayedByName('Add card');
        $this->byName('Cash')->click();
        sleep(4);
        // Assert The Map Is Displayed
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAMapView[1]/UIAElement[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }
}
