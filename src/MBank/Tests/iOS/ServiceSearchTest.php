<?php

namespace MBank\Tests\iOS;


class ServiceSearchTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group ServiceSearch
     */
    public function testSearch()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        // Select Service
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Games_networks');
        $this->byElement('Games_networks')->click();
        // Fill Search Field
        sleep(2);
        $this->waitForElementDisplayedByElement('SearchField');
        $this->byElement('SearchField')->click();
        $this->byElement('SearchField')->value('ste');
        $this->waitForElementDisplayedByElement('SearchButton');
        $this->byElement('SearchButton')->click();
        // Assert Service
        $this->assertEquals('Steam', $this->byElement('SteamSearch')->text());
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
