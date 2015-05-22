<?php
namespace MBank\Tests\iOS;

class PaymentsP2PTest extends \MBank\Tests\MBankiOSTestCase
{

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
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Pay into friend wallet
        $this->byElement('Family_name')->click();
        $this->byElement('Family_name')->value('380931254212');
        // Fill pay form
        $this->byElement('Summ')->click();
        $this->byElement('Summ')->value('10');
        $this->byElement('PayP2P')->click();
        if (APP_ENV == 'ios') {
            $this->byElement('Assert_Element')->click();
        }
        $this->waitForElementDisplayedByElement('Payment_method');
        sleep(2);
        // Pay
        $this->byElement('Pay_button_P2P')->click();
        if (APP_ENV == 'ios') {
            $this->waitForElementDisplayedByElement('OK_Button');
            $this->acceptAlert();
            // Assert Transactions List
            $this->waitForElementDisplayedByElement('Transactions_Assert');
            // Back To DashBoard
            $this->byElement('Menu_Button')->click();
        } elseif (APP_ENV == 'web') {
            // Assert Transactions List
            $this->waitForElementDisplayedByElement('View_limits');
            // Back To DashBoard
            //TODO back menu button WEB
            $this->markTestSkipped();
//        $this->byElement('Menu_Button')->click();
        }
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

    public function testP2PPayToNotVerifiedWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification');
        $this->byElement('Next_Button')->click();
        // Set Valid Data
        $this->fillVerificationForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Profile_Button')->click();
        $this->byElement('Menu_Button')->click();
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Pay into friend wallet
        $phone_number = $this->byElement('Family_name');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('+15662868526');
        // Fill pay form
        $this->byElement('Given_name')->value('10');
        $this->byElement('PayField')->value('BatmanPay');
        $this->byElement('Done_Button')->click();
        $this->byElement('Assert_Element')->click();
        // Assert Wallet Not Indent
        $this->waitForElementDisplayedByElement('Wallet_Not_Ident');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function testP2PPayToYourself()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification');
        $this->byElement('Next_Button')->click();
        // Set Valid Data
        $this->fillVerificationForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Profile_Button')->click();
        $this->byElement('Menu_Button')->click();
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Pay into friend wallet
        $phone_number = $this->byElement('Family_name');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('+15662868526');
        // Fill pay form
        $this->byElement('Given_name')->value('10');
        $this->byElement('PayField')->value('BatmanPay');
        $this->byElement('Done_Button')->click();
        $this->byElement('Assert_Element')->click();
        $this->waitForElementDisplayedByElement('Wallet_Not_Ident');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        } elseif (APP_ENV == 'web') {
            //TODO for WEB_APP
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    /**
     * TODO: верицифировать в платежах нужно через API (выпилить после правок метода в APIService)
     * @param $wallet
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
            $this->byElement('Passport_issued_at')->value($wallet->person->passport_issued_at);
            $this->byElement('Itn')->value($wallet->person->itn);
            $this->byElement('Next_Button')->click();
            $this->waitForElementDisplayedByElement('Alert_Message_RF');
            $this->byElement('Back_Button')->click();
            $this->waitForElementDisplayedByElement('Verification');
        }
    }
}
