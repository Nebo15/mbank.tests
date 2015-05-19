<?php
namespace MBank\Tests\iOS;

class PaymentsOutTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testOutFromWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->walletPayServices();
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
            //TODO for WEB_APP
//          $this->tap(1, 214, 218, 10); // Web Profile Button
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function testPayOutTricolorWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->walletPayServiceTricolor();
        // Check Balance
        $Balance = $this->byElement('Wallet_Balance')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'].'.00a');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPayService()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification');
        $this->byElement('Next_Button')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Profile_Button')->click();
        $this->byElement('Menu_Button')->click();
        // Pay Into service
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Utility_bills');
        $this->byElement('Payment_systems')->click();
        $this->byElement('Яндекс.Деньги')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Pay_button')->click();
        $this->byElement('Pay_Field')->value('1111111111');
        $this->byElement('Pay_Field2')->value('1');
        // Pay
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(2);
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->byElement('Menu_Button')->click();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance In Wallet
        $Balance = $this->byElement('Wallet_Balance')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'].'.00a');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
//          $this->tap(1, 214, 218, 10); // Web Profile Button
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function testServicesLoad()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check services views
        $this->gamesDirectory();
        $this->telephonyDirectory();
        $this->securitySystemsDirectory();
        $this->paymentSystems();
        $this->internetProviders();
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
        $this->waitForElementDisplayedByElement('Verification_Button');
        $this->byElement('Next_Button')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Profile_Button')->click();
        $this->byElement('Menu_Button')->click();
        // Pay Card to Card
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Utility_bills');
        $this->byElement('Card2Card')->click();
        $this->byElement('ПополнениеVisa/MasterCard')->click();
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
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
//          $this->tap(1, 214, 218, 10); // Web Profile Button
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function testPayWalletToCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification_Button');
        $this->byElement('Next_Button')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Profile_Button')->click();
        $this->byElement('Menu_Button')->click();
        // Pay Card to Card
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Utility_bills');
        $this->byElement('Card2Card')->click();
        $this->byElement('ПополнениеVisa/MasterCard')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Pay_button')->click();
        $this->byElement('Pay_Field')->value('1111111111111111');
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(2);
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->byElement('Menu_Button')->click();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance In Wallet
        $Balance = $this->byElement('Wallet_Balance')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'].'.00a');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
//          $this->tap(1, 214, 218, 10); // Web Profile Button
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function walletPayServices()
    {
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Select Service
        $this->waitForElementDisplayedByElement('Utility_bills');
        sleep(1);
        $this->byElement('Games_networks')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->byElement('Steam')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        if (APP_ENV == 'ios') {
            $this->byElement('Pay_button')->click();
            $this->byElement('Pay_Field')->value('11111');
            $this->byElement('Pay_Field2')->value('1');
            // Pay
            $this->byElement('Pay_button')->click();
            $this->waitForElementDisplayedByElement('Payment_method');
            $this->waitForElementDisplayedByElement('Пополнение');
            $this->byElement('Pay_button')->click();
            // Check Transaction in List
            $this->waitForElementDisplayedByElement('OK_Button');
            $this->acceptAlert();
            $this->waitForElementDisplayedByElement('Steam');
            $this->waitForElementDisplayedByElement('Transactions_List');
            // Back To DashBoard
            $this->byElement('Menu_Button')->click();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
        } elseif (APP_ENV == 'web') {
            $this->waitForElementDisplayedByElement('Pay');
            $this->byElement('Pay_Field')->value('11111');
            $this->byElement('Pay_Field2')->click();
            $this->byElement('Pay_Field2')->value('1');
            // Pay
            $this->byElement('Pay')->click();
            $this->waitForElementDisplayedByElement('Payment_method');
            $this->waitForElementDisplayedByElement('Пополнение');
            $this->waitForElementDisplayedByElement('Pay');
            $this->byElement('Pay')->click();
            // Check Transaction in List
            $this->waitForElementDisplayedByElement('View_limits');
            // Back To DashBoard
            //TODO Back menu icon
//        $this->tap(1, 43.3, 58.4, 10); // Menu_Button
            $this->waitForElementDisplayedByElement('Your_balance_Button');
        }
    }

    public function cardPayServices()
    {
        $this->byElement('Pay_button')->click();
        // Select Service
        $this->waitForElementDisplayedByElement('Utility_bills');
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
        $this->waitForElementDisplayedByElement('Пополнение');
        $this->byElement('Select_Card')->click();
        $this->byElement('Pay_button')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function walletPayServiceTricolor()
    {
        $this->byElement('Pay_button')->click();
        // Select Service
        $this->waitForElementDisplayedByElement('Utility_bills');
        $this->byElement('Cable_networks')->click();
        $this->byElement('НТВ_Плюс')->click();
        // Pay
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Pay_button')->click();
        $this->byElement('Pay_Field')->value('1111111111');
        $this->byElement('Pay_Field2')->value('10');
        // Pay
        $this->byElement('Pay_button')->click();
        // Confirm Pay
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Пополнение');
        $this->waitForElementDisplayedByElement('Wallet');
        $this->byElement('Pay_button')->click();
        // Check Transaction Log
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Back To DashBoard
        $this->byElement('Menu_Button')->click();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
    }

    /**
     * @param $wallet //TODO выпилить после правок метода в файлике APIService
     */
    public function fillIndentForm($wallet)
    {
        $this->waitForElementDisplayedByElement('Family_name');
        $this->byElement('Family_name')->value($wallet->person->family_name);
        $this->byElement('Given_name')->value($wallet->person->given_name);
        $this->byElement('Patronymic_name')->value($wallet->person->patronymic_name);
        $this->byElement('Passport_series_number')->value($wallet->person->passport_series_number);
        $this->byElement('Itn')->click();
        $this->byElement('Passport_issued_at')->value($wallet->person->passport_issued_at);
        $this->byElement('Itn')->value($wallet->person->itn);
        $this->byElement('Next_Button')->click();
        // Check alert messages before personalisation of user data
        $this->waitForElementDisplayedByElement('Alert_Message_RF');
        $this->byElement('Back_Button')->click();
        $this->waitForElementDisplayedByElement('Verification');
        $this->byElement('Back_Button_Rus')->click();
        $this->waitForElementDisplayedByElement('Profile_Button');
    }

    public function gamesDirectory()
    {
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
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
        $this->byElement('icon_gallery')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->waitForElementDisplayedByElement('Back_To_Services');
        $this->byElement('Back_dashboard')->click();
    }

    public function telephonyDirectory()
    {
        $this->byElement('Telephony')->click();
        $this->byElement('МГТС')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('МГТС');
        $this->byElement('Back from Provider Select')->click();
    }

    public function securitySystemsDirectory()
    {
        $this->byElement('Security systems')->click();
        $this->byElement('Эшелон Охранная Система')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('Эшелон Охранная Система');
        $this->byElement('Цезарь Сателлит')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->byElement('Back from Provider Select')->click();
    }

    public function paymentSystems()
    {
        $this->byElement('Payment_systems')->click();
        $this->byElement('MГТС с возвратом задолженности')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('MГТС с возвратом задолженности');
        $this->byElement('FarPost (Владивосток)')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->byElement('Back from Provider Select')->click();
    }

    public function internetProviders()
    {
        $this->waitForElementDisplayedByElement('Internet providers');
        $this->byElement('Internet providers')->click();
        $this->byElement('Rline Махачкала')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->byElement('Ru-center')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('Ru-center');
        $this->byElement('Subnet Махачкала')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('Subnet Махачкала');
        $this->byElement('LovePlanet')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('LovePlanet');
        $this->byElement('АВК Оператор Связи (Люберцы)')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('АВК Оператор Связи (Люберцы)');
        $this->byElement('KaspNet (Каспийск)')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByElement('KaspNet (Каспийск)');
        $this->byElement('Back from Provider Select')->click();
    }
}
