<?php

namespace MBank\Tests\iOS;


class CommissionTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Commission
     */
    public function testServicesCommission()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
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
        // Select Service
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        $this->waitForElementDisplayedByElement('Money2Card');
        $this->byElement('Money2Card')->click();
        $this->waitForElementDisplayedByElement('Multibank');
        $this->byElement('Multibank')->click();
        // Pay step
        $pay_value = 10000; // amount
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_field3')->click();
        $this->byElement('Pay_field3')->value($pay_value);
        if (APP_ENV == 'ios') {
            $this->byName('0')->click();
            $this->byName('0')->click();
            $this->byName('Delete')->click();
        }
        $this->byElement('Done_Button')->click();
        // Assert Commission displayed
        $this->CommissionCheck($wallet, $pay_value);
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @param $wallet
     * @param $pay_value
     */
    public function CommissionCheck($wallet, $pay_value)
    {
        $this->waitForElementDisplayedByElement('Commission_assert');
        $this->waitForElementDisplayedByElement('Commission');
        // Get from APP Commission
        $commissionAPP = $this->byElement('Commission')->text();
        // Assert Service Commission API
        $get_commission_values = $this->getAPIService()
                                      ->getServiceCommission($wallet->phone, $wallet->password, '1691'); // 1691 Multibank
        $percent_value = $get_commission_values['data']['rate']['percent'];
        $fix_value = $get_commission_values['data']['rate']['fix'];
        $commissionAPI = $pay_value * $percent_value / "100" + $fix_value;
        // Assert Equals Commission
        if (APP_ENV == 'web') {
            $this->assertEquals($commissionAPP, $commissionAPI . '.00 руб.');
        } elseif (APP_ENV == 'ios') {
            $this->assertEquals($commissionAPP, $commissionAPI);
        }
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
    }

    /**
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
