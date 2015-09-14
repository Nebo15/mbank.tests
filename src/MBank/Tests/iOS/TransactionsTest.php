<?php
namespace MBank\Tests\iOS;

class TransactionsTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Transactions
     */
    public function testRepeatPayCard()
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
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Pay from Card
        $this->cardPayServices();
        $this->waitForElementDisplayedByElement('Repeat');
        // Pay from card retry
        $this->retryPayCard();
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Transactions
     */
    public function testRepeatPayOutMultibankWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->walletPayServiceMultibank();
        // Retry Pay Wallet With Changes
        $this->retryPayWallet();
        // Back To DashBoard
        $this->backToDashBoard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance In Wallet
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
     * @group Transactions
     */
    public function testOutFromWalletRepeatWithoutChanges()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Pay Into Service
        $this->walletPayServices();
        // Retry Pay
        $this->repeatPayWithoutChanges();
        // Assert Dashboard
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->waitForElementDisplayedByElement('Pay_button');
        // Check Balance
        $Balance = $this->byElement('Wallet_Balance')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        if (APP_PLATFORM == 'ios') {
            $this->assertEquals($Balance, $wallet_data['data']['amount'] . '.00a');
        } elseif (APP_PLATFORM == 'web') {
            $this->assertEquals($Balance, $wallet_data['data']['amount']);
        }
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Transactions
     */
    public function testEmptyTransactionsLog()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->waitForElementDisplayedByElement('TransactionsLog');
        $this->byElement('TransactionsLog')->click();
        //Assert Empty Log
        $this->waitForElementDisplayedByElement('TransactionsLogAssert');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Transactions
     */
    public function walletPayServices()
    {
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Select Service
        sleep(1);
        $this->waitForElementDisplayedByElement('Games_networks');
        $this->byElement('Games_networks')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->byElement('Steam')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->click();
        $this->byElement('Pay_Field')->value('11111');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('1');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(10);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function retryPayWallet()
    {
        sleep(5);
        $this->waitForElementDisplayedByElement('Repeat');
        $this->byElement('Repeat')->click();
        $this->waitForElementDisplayedByElement('Repeat payment?');
        $this->byElement('Yes, with changes')->click();
        sleep(3);
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(9);
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Repeat');
        // Check Transaction in List
        sleep(10);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function cardPayServices()
    {
        sleep(2);
        $this->waitForElementDisplayedByElement('Games_networks');
        $this->byElement('Games_networks')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->byElement('Steam')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->value('11111');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Select_Card');
        $this->byElement('Select_Card')->click();
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        if (APP_PLATFORM == 'ios') {
            // Check 3DS Window
            $this->waitForElementDisplayedByElement('3DS_Window');
            $this->waitForElementDisplayedByElement('CVV_fielD');
            $this->byElement('CVV_fielD')->click();
            $this->byElement('CVV_fielD')->value('989');
            // Confirm
            $this->waitForElementDisplayedByElement('Done_Button');
            $this->byElement('Done_Button')->click();
            $this->waitForElementDisplayedByElement('Submit');
            $this->byElement('Submit')->click();
        }
        // Check Transaction in List
        sleep(10);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function walletPayServiceMultibank()
    {
        // Select Service
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Money2Card');
        $this->byElement('Money2Card')->click();
        // Submit Multibank service
        $this->waitForElementDisplayedByElement('Multibank');
        $this->byElement('Multibank')->click();
        // Pay1
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->click();
        $this->byElement('Pay_Field')->value('0931254212');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('044583151');
        $this->byElement('Pay_field3')->click();
        $this->byElement('Pay_field3')->value('1');
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        // Pay2
        if (APP_PLATFORM == 'web') {
            $this->waitForElementDisplayedByElement('Pay_buttoN');
            $this->byElement('Pay_buttoN')->click();
        }
        if (APP_PLATFORM == 'ios') {
            $this->waitForElementDisplayedByElement('Pay_buTTON');
            $this->byElement('Pay_buTTON')->click();
        }
        // Pay Confirm
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(9);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(10);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function retryPayCard()
    {
        sleep(2);
        $this->byElement('Repeat')->click();
        $this->waitForElementDisplayedByElement('Repeat payment?');
        $this->waitForElementDisplayedByElement('YES_Button');
        $this->byElement('YES_Button')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        if (APP_PLATFORM == 'web') {
            $this->tap(1, 59, 461, 10); // Select card
        }
        if (APP_PLATFORM == 'ios') {
            $this->waitForElementDisplayedByElement('Select_Card');
            $this->byElement('Select_Card')->click();
        }
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(2);
        $this->byElement('Pay_buttoN')->click();
        if (APP_PLATFORM == 'ios') {
            // Check 3DS Window
            $this->waitForElementDisplayedByElement('3DS_Window');
            $this->waitForElementDisplayedByElement('CVV_fielD');
            $this->byElement('CVV_fielD')->click();
            $this->byElement('CVV_fielD')->value('989');
            // Confirm
            $this->waitForElementDisplayedByElement('Done_Button');
            $this->byElement('Done_Button')->click();
            $this->waitForElementDisplayedByElement('Submit');
            $this->byElement('Submit')->click();
        }
        // Check Transaction in List
        sleep(10);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function repeatPayWithoutChanges()
    {
        $this->waitForElementDisplayedByElement('Repeat');
        sleep(2);
        $this->byElement('Repeat')->click();
        $this->waitForElementDisplayedByElement('Repeat payment?');
        $this->byElement('Yes, with changes')->click();
        sleep(3);
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(10);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->backToDashBoard();
    }
}
