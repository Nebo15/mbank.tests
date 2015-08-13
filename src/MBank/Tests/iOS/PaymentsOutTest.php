<?php
namespace MBank\Tests\iOS;

class PaymentsOutTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group PayOut
     */
    public function testOutFromWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->walletPayServices();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance
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
    }

    /**
     * @group PayOut
     */
    public function testOutFromCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
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
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group PayOut
     */
    public function testPayOutHTBWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->walletPayServiceHTB();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance
        $Balance = $this->byElement('Wallet_Balance')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        if (APP_ENV == 'ios') {
            $this->assertEquals($Balance, $wallet_data['data']['amount'] . '.00a');
        } elseif (APP_ENV == 'web') {
            $this->assertEquals($Balance, $wallet_data['data']['amount']);
        }
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group PayOut
     */
    public function testPayServiceYandex()
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
        $this->byElement('Your_balance_Button')->click();
        // YandexMoney
        $this->yandexMoneyService();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance In Wallet
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
    }

    /**
     * @group PayOut
     */
    public function testPayCardToCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
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
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        // Pay To Card
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        $this->payCardToCard();
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group PayOut
     */
    public function testPayWalletToCard()
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
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Pay visaCard
        $this->visaCardPay();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance In Wallet
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
    }

    /**
     * @group PayOut
     */
    public function testServicesLoad()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboard();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            // Check services views
            $this->waitForElementDisplayedByElement('Pay_button');
            $this->byElement('Pay_button')->click();
            $this->gamesDirectory();
            $this->telephonyDirectory();
            $this->internetProviders();
            // Delete wallet
            if (ENVIRONMENT == 'DEV') {
                $this->getAPIService()->deleteWallet($wallet->phone);
            }
        }
    }

    /**
     * @group PayOut
     */
    public function testSendStatementAfterPay()
    {
        if (APP_ENV == 'ios') {
            $this->loadDashboard('+380931254212', 'qwerty');
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->submitProfileButton();
            sleep(2);
            $this->tap(1, 247 ,233, 10); // Settings Button
            $this->waitForElementDisplayedByElement('Send statement');
            $this->byElement('Send statement')->click();
            $this->waitForElementDisplayedByElement('After payment');
            $this->byElement('After payment')->click();
            $this->waitForElementDisplayedByElement('Mail_field');
            $this->byElement('Mail_field')->click();
            $this->byElement('Mail_field')->value('paul@nebo15.com');
            $this->byElement('Back_dashboard')->click();
            $this->waitForElementDisplayedByElement('Back_dashboard');
            $this->byElement('Back_dashboard')->click();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->walletPayServices();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
        }
    }

    /**
     * @group PayOut
     */
    public function testSendStatementWeek()
    {
        if (APP_ENV == 'ios') {
            $this->loadDashboard('+380931254212', 'qwerty');
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->submitProfileButton();
            sleep(2);
            $this->tap(1, 247 ,233, 10); // Settings Button
            $this->waitForElementDisplayedByElement('Send statement');
            $this->byElement('Send statement')->click();
            $this->waitForElementDisplayedByElement('Once a week');
            $this->byElement('Once a week')->click();
            $this->waitForElementDisplayedByElement('Mail_field');
            $this->byElement('Mail_field')->click();
            $this->byElement('Mail_field')->value('paul@nebo15.com');
            $this->byElement('Back_dashboard')->click();
            $this->waitForElementDisplayedByElement('Back_dashboard');
            $this->byElement('Back_dashboard')->click();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->walletPayServices();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
        }
    }

    /**
     * @group PayOut
     */
    public function testSendStatementMonth()
    {
        if (APP_ENV == 'ios') {
            $this->loadDashboard('+380931254212', 'qwerty');
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->submitProfileButton();
            sleep(2);
            $this->tap(1, 247 ,233, 10); // Settings Button
            $this->waitForElementDisplayedByElement('Send statement');
            $this->byElement('Send statement')->click();
            $this->waitForElementDisplayedByElement('Once a month');
            $this->byElement('Once a month')->click();
            $this->waitForElementDisplayedByElement('Mail_field');
            $this->byElement('Mail_field')->click();
            $this->byElement('Mail_field')->value('paul@nebo15.com');
            $this->byElement('Back_dashboard')->click();
            $this->waitForElementDisplayedByElement('Back_dashboard');
            $this->byElement('Back_dashboard')->click();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->walletPayServices();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
        }
    }

    public function walletPayServices()
    {
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Select Service
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
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(1);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->backToDashBoard();
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
        // Check Transaction in List
        sleep(1);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function walletPayServiceHTB()
    {
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Select Service
        sleep(2);
        $this->waitForElementDisplayedByElement('Cable_networks');
        $this->byElement('Cable_networks')->click();
        $this->waitForElementDisplayedByElement('НТВ_Плюс');
        $this->byElement('НТВ_Плюс')->click();
        // Pay
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->value('1111111111');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(2);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(1);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->backToDashBoard();
    }


    public function gamesDirectory()
    {
        $this->waitForElementDisplayedByElement('Games_networks');
        $this->byElement('Games_networks')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->byElement('Steam')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->byElement('Odnoklassniki_Button')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('ВКонтакте');
        $this->byElement('ВКонтакте')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->byElement('Back from Provider Select')->click();
    }

    public function telephonyDirectory()
    {
        $this->byElement('Telephony')->click();
        $this->waitForElementDisplayedByElement('МГТС');
        $this->byElement('МГТС')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('МГТС');
        $this->byElement('Back from Provider Select')->click();
    }

    public function internetProviders()
    {
        $this->waitForElementDisplayedByElement('Internet providers');
        $this->byElement('Internet providers')->click();
        $this->waitForElementDisplayedByElement('OnLime, Ростелеком');
        $this->byElement('OnLime, Ростелеком')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->byElement('АСВТ (Москва)')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('АСВТ (Москва)');
        $this->byElement('Цифра Один')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('Цифра Один');
        $this->byElement('WestCall (СПб)')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('WestCall (СПб)');
        $this->byElement('Back from Provider Select')->click();
    }

    public function yandexMoneyService()
    {
        $this->byElement('Your_balance_Button')->click();
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Select Service
        sleep(2);
        $this->waitForElementDisplayedByElement('Payment_systems');
        $this->byElement('Payment_systems')->click();
        $this->waitForElementDisplayedByElement('Яндекс.Деньги');
        $this->byElement('Яндекс.Деньги')->click();
        // Fill Fields
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->value('1111');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('1');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(2);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(1);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->backToDashBoard();
    }

    public function visaCardPay()
    {
        sleep(2);
        // Select Service
        $this->waitForElementDisplayedByElement('Payment_systems');
        $this->byElement('Card2Card')->click();
        // Fill Fields
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->value('1111111111111111');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(1);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->backToDashBoard();
    }

    public function payCardToCard()
    {
        sleep(2);
        // Select Service
        $this->waitForElementDisplayedByElement('Payment_systems');
        $this->byElement('Card2Card')->click();
        // Fill Fields
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->value('1111111111111111');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        if (APP_ENV == 'web') {
            $this->tap(1, 59, 461, 10); // Select card
        }
        if (APP_ENV == 'ios') {
            $this->waitForElementDisplayedByElement('Select_Card');
            $this->byElement('Select_Card')->click();
        }
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        sleep(1);
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }
}
