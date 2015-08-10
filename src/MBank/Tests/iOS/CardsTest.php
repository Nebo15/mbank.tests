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
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Cards_Button');
        $this->byElement('Cards_Button')->click();
        sleep(2);
        $this->waitForElementDisplayedByElement('Add_New_card_Button');
        // Add First Card
        $this->byElement('Add_New_card_Button')->click();
        $this->fillCardForm('4652060724922338', '01', '17', '989', 'testtest');
        // Assert First Card Is Added
        $this->waitForElementDisplayedByElement('First_Card_Assert');
        // Add Second Card
        $this->waitForElementDisplayedByElement('Add_New_card_Button');
        $this->byElement('Add_New_card_Button')->click();
        $this->fillCardForm('5417150396276825', '01', '17', '789', 'testtestd');
        // Assert Second Card Is Added
        $this->waitForElementDisplayedByElement('Second_Card_Assert');
        // Remove Second Card
        if (APP_ENV == 'ios') {
            $this->byElement('Remove_Card_Button')->click();
            $this->byElement('DA_Button')->click();
            // Assert Second Is Removed
            sleep(2);
            $cardDelete = $this->byElement('Delete_Card_Assert')->text();
            $this->assertEquals('moved to row 1 of 1', $cardDelete);
        } elseif (APP_ENV == 'web') {
            $this->tap(1, 350, 115, 10); // Remove card
        }
        // Assert First Card Is Present
        $this->waitForElementDisplayedByElement('Second_Card_Assert');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Cards
     */
    public function testCashDisplayed()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->byElement('Add_funds_Button')->click();
        // Check Cash Field
        $this->waitForElementDisplayedByElement('Cash_Button');
        $this->byElement('Cash_Button')->click();
        sleep(4);
        // Assert The Map Is Displayed
        $this->waitForElementDisplayedByElement('Map_Assert');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
