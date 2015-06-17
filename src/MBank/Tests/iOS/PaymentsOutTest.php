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

    public function testOutFromCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Profile_Button')->click();
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
        $this->byElement('Back_to_Profile_Button')->click();
        $this->byElement('Back_dashboard')->click();
        // Pay from Card
        $this->cardPayServices();
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        } elseif (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
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

    public function testPayService()
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

    public function testPayCardToCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Profile_Button')->click();
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
        // Back to Dashboard
        $this->byElement('Back_to_Profile_Button')->click();
        $this->byElement('Back_dashboard')->click();
        $this->waitForElementDisplayedByElement('Profile_Button');
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
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        // Pay Card to Card
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Card2Card');
        $this->byElement('Card2Card')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Pay_button')->click();
        $this->byElement('Pay_Field')->value('1111111111111111');
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(2);
        $this->byElement('Select_Card')->click();
        $this->byElement('Pay_button')->click();
        // Assert Transactions List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        } elseif (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

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

    public function testServicesLoad()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped();
        }
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check services views
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        $this->gamesDirectory();
        $this->telephonyDirectory();
        $this->securitySystemsDirectory();
        $this->internetProviders();
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
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
        $this->byElement('Pay_Field2')->value('1');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        if (APP_ENV == 'ios') {
            $this->byElement('Menu_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(2);
            $this->tap(1, 50, 62, 10);
        }
    }

    public function cardPayServices()
    {
        $this->byElement('Pay_button')->click();
        // Select Service
        $this->waitForElementDisplayedByElement('Games_networks');
        $this->byElement('Games_networks')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->byElement('Steam')->click();
        // Pay
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Pay_button')->click();
        $this->byElement('Pay_Field')->value('11111');
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Select_Card');
        $this->byElement('Select_Card')->click();
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
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
        $this->byElement('Cable_networks')->click();
        $this->waitForElementDisplayedByElement('НТВ_Плюс');
        $this->byElement('НТВ_Плюс')->click();
        // Pay
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->value('1111111111');
        $this->byElement('Pay_Field2')->value('1');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        if (APP_ENV == 'ios') {
            $this->byElement('Menu_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(2);
            $this->tap(1, 50, 62, 10);
        }
    }
    /**
     * @param $wallet //TODO выпилить после правок метода в файлике APIService
     */
    protected function fillVerificationForm($wallet)
    {
        if (APP_ENV == 'web') {
            $this->waitForElementDisplayedByElement('Family_name');
            $this->waitForElementDisplayedByElement('Given_name');
            $this->byElement('Family_name')->value($wallet->person->family_name);
            $this->byElement('Family_name')->click();
            $this->byName('q')->click();
            $this->byName('Delete')->click();
            $this->byElement('Given_name')->value($wallet->person->given_name);
            $this->byElement('Given_name')->click();
            $this->byName('q')->click();
            $this->byName('Delete')->click();
            $this->byElement('Patronymic_name')->click();
            $this->byElement('Patronymic_name')->value($wallet->person->patronymic_name);
            $this->byElement('Patronymic_name')->click();
            $this->byName('q')->click();
            $this->byName('Delete')->click();
            $this->byElement('Passport_series_number')->click();
            $this->byElement('Passport_series_number')->value($wallet->person->passport_series_number);
            $this->byElement('Itn')->click();
            $this->byElement('Passport_issued_at')->click();
            $this->byElement('Passport_issued_at')->value($wallet->person->passport_issued_at);
            $this->byElement('Itn')->click();
            $this->byElement('Itn')->value($wallet->person->itn);
            $this->byName('Go')->click();
            sleep(1);
        } elseif (APP_ENV == 'ios') {
            $this->byElement('Family_name')->value($wallet->person->family_name);
            $this->byElement('Given_name')->value($wallet->person->given_name);
            $this->byElement('Patronymic_name')->value($wallet->person->patronymic_name);
            $this->byElement('Passport_series_number')->value($wallet->person->passport_series_number);
            $this->byElement('Itn')->click();
            $this->byElement('Itn')->value($wallet->person->itn);
            $this->byElement('Passport_issued_at')->value($wallet->person->passport_issued_at);
            $this->byElement('Done_Button')->click();
            $this->byElement('Next_Button')->click();
            $this->waitForElementDisplayedByElement('Done_Button');
            $this->byElement('Done_Button')->click();
        }
    }

    public function gamesDirectory()
    {
        $this->waitForElementDisplayedByElement('Games_networks');
        $this->byElement('Games_networks')->click();
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

    public function securitySystemsDirectory()
    {
        $this->byElement('Security systems')->click();
        $this->waitForElementDisplayedByElement('Эшелон Охранная Система');
        $this->byElement('Эшелон Охранная Система')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('Эшелон Охранная Система');
        $this->byElement('Цезарь Сателлит')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
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
        $this->byElement('Pay_Field2')->value('1');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        if (APP_ENV == 'ios') {
            $this->byElement('Menu_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(2);
            $this->tap(1, 50, 62, 10);
        }
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
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_buttoN')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(1);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        if (APP_ENV == 'ios') {
            $this->byElement('Menu_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(2);
            $this->tap(1, 50, 62, 10);
        }
    }
}
