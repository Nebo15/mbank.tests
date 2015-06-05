<?php

namespace MBank\Tests\iOS;


class TransactionsTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testRepeatPayCard()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
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
        $this->cardPayServices();
        $this->waitForElementDisplayedByElement('Repeat');
        // Pay from card retry
        $this->retryPayCard();
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testRepeatPayCardWithChanges()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
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
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification_Button1');
        $this->byElement('Verification_Button1')->click();
        // Set Valid Data
        $this->fillVerificationForm($wallet); //TODO заменить методом с APIService.php
        $this->waitForElementDisplayedByElement('Back_Button_Rus');
        $this->byElement('Back_Button_Rus')->click();
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Pay into friend wallet
        $phone_number = $this->byElement('Phone');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('380931254212');
        // Fill pay form
        $this->byElement('Summ')->value('10');
        $this->byElement('PayP2P')->click();
        $this->byElement('Assert_Element')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(2);
        // Card Pay
        $this->byElement('Select_Card')->click();
        $this->byElement('Pay_button')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Repeat Pay With Changes
        $this->repeatPay();
        // Assert Transactions in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testPayOutMultibankWallet()
    {
        if (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->walletPayServiceMultibank($wallet);
        // Retry Pay Wallet With Changes
        $this->retryPayWallet();
        // Back To DashBoard
        $this->byElement('Menu_Button')->click();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        // Check Balance In Wallet
        $Balance = $this->byElement('Wallet_Balance')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'] . '.00a');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testOutFromWalletRepeat()
    {
        if (APP_ENV == 'web') {
            $wallet = $this->createWalletAndLoadDashboard();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->walletPayServices();
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->waitForElementDisplayedByElement('Add_funds_Button');
            $this->waitForElementDisplayedByElement('Conversations_Button');
            $this->waitForElementDisplayedByElement('Pay_button');
            // Check Balance
            $Balance = $this->byElement('Wallet_Balance')->text();
            // Check Balance in Wallet (API)
            sleep(1);
            $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
            $this->assertEquals($Balance, $wallet_data['data']['amount']);
            // Delete wallet
            if (ENVIRONMENT == 'DEV') {
                $this->getAPIService()->deleteWallet($wallet->phone);
            }
        }
    }

    public function walletPayServices()
    {
        $this->waitForElementDisplayedByElement('Add_funds_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Select Service
        $this->waitForElementDisplayedByElement('Games_networks');
        sleep(1);
        $this->byElement('Games_networks')->click();
        $this->waitForElementDisplayedByElement('Steam');
        $this->byElement('Steam')->click();
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay');
        $this->byElement('Pay_Field')->click();
        $this->byElement('Pay_Field')->value('11111');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('1');
        // Pay
        $this->byElement('Pay')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Пополнение');
        $this->waitForElementDisplayedByElement('Pay');
        sleep(1);
        $this->byElement('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('View_limits');
        // Repeat pay
        $this->waitForElementDisplayedByElement('Repeat');
        sleep(1);
        $this->byElement('Repeat')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Пополнение');
        $this->waitForElementDisplayedByElement('Pay');
        sleep(1);
        $this->byElement('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('View_limits');
        // Back To DashBoard
        sleep(2);
        $this->tap(1, 50, 62, 10);
    }

    public function retryPayWallet()
    {
        $this->byElement('Repeat')->click();
        $this->waitForElementDisplayedByElement('Repeat payment?');
        $this->byElement('Yes, with changes')->click();
        sleep(3);
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Pay_field4');
        $this->byElement('Pay_field4')->click();
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Wallet');
        sleep(2);
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Repeat');
    }

    public function cardPayServices()
    {
        $this->waitForElementDisplayedByElement('Pay_button');
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
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->waitForElementDisplayedByElement('Select_Card');
        sleep(2);
        $this->byElement('Select_Card')->click();
        $this->byElement('Pay_button')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function walletPayServiceMultibank($wallet)
    {
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
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        // Pay Into service
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Security systems');
        $this->byElement('Security systems')->click();
        // Submit Multibank service
        $this->waitForElementDisplayedByElement('Multibank');
        $this->byElement('Multibank')->click();
        // Pay1
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->byElement('Pay_button')->click();
        $this->byElement('Pay_Field')->value('0931254212');
        $this->byElement('Pay_Field2')->value('044583151');
        $this->byElement('Pay_field3')->value('1');
        $this->byElement('Pay_button')->click();
        // Pay2
        $this->waitForElementDisplayedByElement('Pay_field4');
        $this->byElement('Pay_Field')->value('testlol');
        $this->byElement('Pay_Field2')->value('random');
        $this->byElement('Pay_field3')->value('11111');
        $this->byElement('Pay_field5')->value('test');
        $this->byElement('Pay_field4')->value('tested');
        $this->byElement('Done_Button')->click();
        $this->byElement('Pay_field4')->click();
        $this->byElement('Pay_button')->click();
        // Confirm Pay
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Wallet');
        sleep(2);
        $this->byElement('Pay_button')->click();
        // Check Transaction Log
        $this->waitForElementDisplayedByElement('OK_Button');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function retryPayCard()
    {
        $this->byElement('Repeat')->click();
        $this->waitForElementDisplayedByElement('Repeat payment?');
        $this->byElement('YES_Button')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_button');
        sleep(2);
        $this->byElement('Select_Card')->click();
        $this->byElement('Pay_button')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
    }

    public function repeatPay()
    {
        $this->byElement('Repeat')->click();
        $this->waitForElementDisplayedByElement('Repeat payment?');
        $this->byElement('Yes, with changes')->click();
        $this->waitForElementDisplayedByElement('Transfer_Button');
        sleep(1);
        $this->byElement('Assert_Element')->click();
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(2);
        $this->byElement('Select_Card')->click();
        $this->byElement('Pay_button')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
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
}
