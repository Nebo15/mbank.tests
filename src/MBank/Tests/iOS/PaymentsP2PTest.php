<?php
namespace MBank\Tests\iOS;

class PaymentsP2PTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group P2P
     */
    public function testP2PFromWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification_Button1');
        $this->byElement('Verification_Button1')->click();
        // Set Valid Data
        $this->fillVerificationForm($wallet);
        $this->waitForElementDisplayedByElement('Back_Button_Rus');
        $this->byElement('Back_Button_Rus')->click();
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Pay into friend wallet
        $this->byElement('Phone')->click();
        $this->byElement('Phone')->value('380931254212');
        // Fill pay form
        $this->byElement('Summ')->click();
        $this->byElement('Summ')->value('10');
        $this->waitForElementDisplayedByElement('Done_Button');
        $this->byElement('Done_Button')->click();
        $this->byElement('PayP2P')->click();
        // Assert pay screen
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(2);
        // Pay
        $this->byElement('Pay_button_P2P')->click();
        // Assert Transactions List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
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
     * @group P2P
     */
    public function testP2PPayToNonVerifiedWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification_Button1');
        $this->byElement('Verification_Button1')->click();
        // Set Valid Data
        $this->fillVerificationForm($wallet);
        $this->waitForElementDisplayedByElement('Back_Button_Rus');
        $this->byElement('Back_Button_Rus')->click();
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Pay into friend wallet
        $this->byElement('Phone')->click();
        $this->byElement('Phone')->value('15662868526');
        // Fill pay form
        $this->byElement('Summ')->click();
        $this->byElement('Summ')->value('10');
        $this->waitForElementDisplayedByElement('Done_Button');
        $this->byElement('Done_Button')->click();
        $this->byElement('PayP2P')->click();
        // Assert Wallet Not Indent
        $this->waitForElementDisplayedByElement('Wallet_Not_Ident');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group P2P
     */
    public function testP2PPayToYourself()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification_Button1');
        $this->byElement('Verification_Button1')->click();
        // Set Valid Data
        $this->fillVerificationForm($wallet);
        $this->waitForElementDisplayedByElement('Back_Button_Rus');
        $this->byElement('Back_Button_Rus')->click();
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Pay into friend wallet
        $this->byElement('Phone')->click();
        $this->byElement('Phone')->value(preg_replace('/\+/','',$wallet->phone));
        // Fill pay form
        $this->byElement('Summ')->click();
        $this->byElement('Summ')->value('10');
        $this->waitForElementDisplayedByElement('Done_Button');
        $this->byElement('Done_Button')->click();
        $this->byElement('PayP2P')->click();
        // Assert Yourself Payment Impossible
        $this->waitForElementDisplayedByElement('Assert_Yourself');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group P2P
     */
    public function testP2PContacts()
    {
        if (APP_PLATFORM == 'web') {
        $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification_Button1');
        $this->byElement('Verification_Button1')->click();
        // Set Valid Data
        $this->fillVerificationForm($wallet);
        $this->waitForElementDisplayedByElement('Back_Button_Rus');
        $this->byElement('Back_Button_Rus')->click();
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Assert contacts screen
        $this->tap(1, 275, 244, 10);
        $this->waitForElementDisplayedByElement('Contact_screen');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
