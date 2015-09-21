<?php
namespace MBank\Tests\iOS;

class PaymentsInTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group PayIn
     */
    public function testPayInCard()
    {
        $wallet = $this->createWalletAndCheckCardStatus();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Cards_Button');
        $this->byElement('Cards_Button')->click();
        sleep(1);
        $this->waitForElementDisplayedByElement('Add_New_card_Button');
        // Add Card
        $this->byElement('Add_New_card_Button')->click();
        $this->fillCardForm('4652060724922338', '01', '17', '989', 'testtest');
        // Assert Card Is Added
        $this->waitForElementDisplayedByElement('First_Card_Assert');
        // Back to DashBoard
        $this->backToProfile();
        $this->backToDashBoard();
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->byElement('Add_funds_Button')->click();
        // Pay
        $this->walletPayForm('10');
        // Check 3DS Window
        $this->waitForElementDisplayedByElement('3DS_Window_2');
        $this->waitForElementDisplayedByElement('CVV_fielD_2');
        $this->byElement('CVV_fielD_2')->click();
        $this->byElement('CVV_fielD_2')->value('989');
        // Confirm
        $this->waitForElementDisplayedByElement('Done_Button');
        $this->byElement('Done_Button')->click();
        $this->waitForElementDisplayedByElement('Submit_2');
        $this->byElement('Submit_2')->click();
        // Check Transactions List
        $this->waitForElementDisplayedByElement('Transactions_Assert_PayIN');
        sleep(2);
        // Back to DashBoard
        $this->backToDashBoard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance in Wallet
        $Balance = $this->byElement('Wallet_Balance')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        if (APP_PLATFORM == 'ios') {
            $this->assertEquals($Balance, $wallet_data['data']['amount'] . '.00a');
        } elseif (APP_PLATFORM == 'web') {
            $this->assertEquals($Balance, $wallet_data['data']['amount']);
        }
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group PayIn
     */
    public function testPayInCardNegativeSum()
    {
        $wallet = $this->createWalletAndCheckCardStatus();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        $this->waitForElementDisplayedByElement('Cards_Button');
        $this->byElement('Cards_Button')->click();
        sleep(1);
        $this->waitForElementDisplayedByElement('Add_New_card_Button');
        // Add Card
        $this->byElement('Add_New_card_Button')->click();
        $this->fillCardForm('4652060724922338', '01', '17', '989', 'testtest');
        // Assert Card Is Added
        $this->waitForElementDisplayedByElement('First_Card_Assert');
        // Back to DashBoard
        $this->backToProfile();
        $this->backToDashBoard();
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->byElement('Add_funds_Button')->click();
        // Pay Zero Sum
        $this->walletPayForm('0');
        if (APP_PLATFORM == 'ios') {
            // Assert Alert Message
            $this->waitForElementDisplayedByElement('Alert_Pay_Message');
            // Pay Incorrect Sum
            $this->waitForElementDisplayedByElement('OK_Button');
            $this->byElement('OK_Button')->click();
            $this->walletPayForm('100000');
            // Assert Alert Message
            $this->waitForElementDisplayedByElement('Alert_Message');
        }
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function walletPayForm($sum)
    {
        $this->waitForElementDisplayedByElement('Amount_Field');
        $this->byElement('Amount_Field')->click();
        $this->byElement('Amount_Field')->value($sum);
        $this->byElement('PayIN')->click();
    }
}

