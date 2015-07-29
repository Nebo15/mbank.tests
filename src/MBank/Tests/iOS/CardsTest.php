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
        if (APP_ENV == 'ios') {
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
            $this->waitForElementDisplayedByElement('Second_Card_Assert');
        } elseif (APP_ENV == 'web') {
            $this->markTestSkipped();
//            $this->waitForElementDisplayedByElement('Add_New_card_Button');
//            sleep(2);
//            $this->byElement('Add_New_card_Button')->click();
//            $this->waitForElementDisplayedByElement('Add_card_number_Button');
//            // Add card
//            $cardNumber = $this->byElement('Add_card_number_Button');
//            $cardNumber->click();
//            $cardNumber->value('5417150396276825');
//            // Add YY
//            $this->byElement('Add_YY_Button')->click();
//            sleep(1);
//            $this->tap(1, 194, 616, 10); // add year 17
//            $this->byElement('Done_Button')->click();
//            // Add CVV code
//            $cvv = $this->byElement('CVV_Button');
//            $cvv->click();
//            $cvv->value('789');
//            // Add CardHolder
//            $cardHolder = $this->byElement('Cardholder_Button');
//            $cardHolder->click();
//            $cardHolder->value('testtestd');
//            $this->byElement('Start_button')->click();
//            // Assert test pay
//            sleep(3);
//            $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[4]');
//            $this->byXPath('//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[4]')->click();
            //TODO for WEB_APP
        }
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
