<?php

namespace MBank\Tests\iOS;


class CardsTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testAddCard()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboard();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->byElement('Profile_Button')->click();
            $this->byElement('Cards_Button')->click();
            $this->waitForElementDisplayedByElement('Cards_Button');
            $this->waitForElementDisplayedByElement('Empty_list_Button');
            $this->waitForElementDisplayedByElement('Add_New_card_Button');
            $this->waitForElementDisplayedByElement('Back_to_Profile_Button');
            // Add First Card
            $this->byElement('Add_New_card_Button')->click();
            $this->fillCardForm('4652060724922338', '01', '17', '989', 'testtest');
            // Assert First Card Is Added
            $this->waitForElementDisplayedByElement('First_Card_Assert');
            // Add Second Card
            $this->byElement('Add_New_card_Button')->click();
            $this->fillCardForm('5417150396276825', '01', '17', '789', 'testtestd');
            // Assert Second Card Is Added
            $this->waitForElementDisplayedByElement('Second_Card_Assert');
            // Remove Second Card
            $this->byElement('Remove_Card_Button')->click();
            $this->byElement('DA_Button')->click();
            // Assert Second Is Removed
            sleep(2);
            $cardDelete = $this->byElement('Delete_Card_Assert')->text();
            $this->assertEquals('moved to row 1 of 1', $cardDelete);
            // Assert First Card Is Present
            $this->waitForElementDisplayedByElement('First_Card_Assert');
            // Delete wallet
        if (ENVIRONMENT == 'DEV') {
                $this->getAPIService()->deleteWallet($wallet->phone);
            }
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    /**
     * @group Cards
     */
    public function testCashDisplayed()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->byElement('Add_funds_Button')->click();
        // Check Cash Field
        $this->waitForElementDisplayedByElement('Cash_Button');
        $this->byElement('Cash_Button')->click();
        sleep(4);
        // Assert The Map Is Displayed
        $this->waitForElementDisplayedByElement('Map_Assert');
        // Delete wallet
        if (ENVIRONMENT == 'DEV')
        {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
