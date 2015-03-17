<?php

namespace MBank\Tests\iOS;


class CardsTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testAddCard()
    {
        $this->createWalletAndLoadDashboard();
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('Empty list');
        $this->byName('Add new card')->click();
        $this->fillCardVisaForm();

    }

    protected function fillCardVisaForm()
    {
        // Add card number
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')
             ->value('4652060724922338');

        // Add MM
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[2]')
             ->value('01');

        // Add YY
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[3]')
             ->value('17');

        // Add CVV code
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[4]')
            ->value('989');

        // Add CardHolder
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[5]')
            ->value('testtest');

        $this->byName('Add card')->click();

        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
    }

}
