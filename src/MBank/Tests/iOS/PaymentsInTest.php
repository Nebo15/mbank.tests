<?php
namespace MBank\Tests\iOS;

class PaymentsInTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testPayInCard()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboard();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->submitProfileButton();
            $this->waitForElementDisplayedByElement('Cards_Button');
            $this->byElement('Cards_Button')->click();
            $this->waitForElementDisplayedByElement('Cards_Button');
            $this->waitForElementDisplayedByElement('Empty_list_Button');
            $this->waitForElementDisplayedByElement('Add_New_card_Button');
            $this->waitForElementDisplayedByElement('Back_to_Profile_Button');
            // Add Card
            $this->byElement('Add_New_card_Button')->click();
            $this->fillCardForm('4652060724922338', '01', '17', '989', 'testtest');
            // Assert Card Is Added
            $this->waitForElementDisplayedByElement('First_Card_Assert');
            // Back to DashBoard
            $this->waitForElementDisplayedByElement('Back_to_Profile_Button');
            $this->byElement('Back_to_Profile_Button')->click();
            $this->waitForElementDisplayedByElement('Menu_Button');
            $this->byElement('Menu_Button')->click();
            $this->waitForElementDisplayedByElement('Add_funds_Button');
            $this->byElement('Add_funds_Button')->click();
            // Pay
            $this->walletPayForm('10');
            // Check Transactions List
            $this->waitForElementDisplayedByElement('Transactions_Assert');
            // Back to DashBoard
            $this->byElement('Menu_Button')->click();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            // Check Balance in Wallet
            $Balance = $this->byElement('Wallet_Balance')->text();
            // Check Balance in Wallet (API)
            sleep(1);
            $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
            if (APP_ENV == 'ios') {
                $this->assertEquals($Balance, $wallet_data['data']['amount'] . '.00a');
            } elseif (APP_ENV == 'web') {
                $this->assertEquals($Balance, $wallet_data['data']['amount']);
            }
            // Delete wallet
            if (ENVIRONMENT == 'DEV') {
                $this->getAPIService()->deleteWallet($wallet->phone);
            }
        } elseif (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function testPayInCardNegativeSum()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboard();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->submitProfileButton();
            $this->waitForElementDisplayedByElement('Cards_Button');
            $this->byElement('Cards_Button')->click();
            $this->waitForElementDisplayedByElement('Cards_Button');
            $this->waitForElementDisplayedByElement('Empty_list_Button');
            $this->waitForElementDisplayedByElement('Add_New_card_Button');
            $this->waitForElementDisplayedByElement('Back_to_Profile_Button');
            // Add Card
            $this->byElement('Add_New_card_Button')->click();
            $this->fillCardForm('4652060724922338', '01', '17', '989', 'testtest');
            // Assert Card Is Added
            $this->waitForElementDisplayedByElement('First_Card_Assert');
            // Back to DashBoard
            $this->waitForElementDisplayedByElement('Back_to_Profile_Button');
            $this->byElement('Back_to_Profile_Button')->click();
            $this->waitForElementDisplayedByElement('Menu_Button');
            $this->byElement('Menu_Button')->click();
            $this->waitForElementDisplayedByElement('Add_funds_Button');
            $this->byElement('Add_funds_Button')->click();
            // Pay Zero Sum
            $this->walletPayForm('0');
            // Assert Alert Message
            $this->waitForElementDisplayedByElement('Alert_Pay_Message');
            // Pay Incorrect Sum
            $this->byElement('OK_Button')->click();
            $this->walletPayForm('100000');
            // Assert Alert Message
            $this->waitForElementDisplayedByElement('Alert_Message');
            // Delete wallet
            if (ENVIRONMENT == 'DEV') {
                $this->getAPIService()->deleteWallet($wallet->phone);
            }
        } elseif (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function walletPayForm($sum)
    {
        $this->waitForElementDisplayedByElement('Wallet_Balance_View');
        $this->waitForElementDisplayedByElement('Amount_Field');
        $this->byElement('Amount_Field')->value($sum);
        $this->byElement('PayIN')->click();
    }
}

