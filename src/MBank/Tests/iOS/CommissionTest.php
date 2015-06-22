<?php

namespace MBank\Tests\iOS;


class CommissionTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testServicesCommission()
    {
        if (APP_ENV == 'ios') {
            $this->markTestSkipped("Issue not resolved for iOS");
        }
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
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
        $this->byElement('Done_Button')->click();
        // Assert Commission displayed
        $this->waitForElementDisplayedByElement('Commission_assert');
        $this->waitForElementDisplayedByElement('Commission');
        // Get from APP Commission
        $commission = $this->byElement('Commission')->text();
        // Assert Service Commission API
        $get_commission_values = $this->getAPIService()->getServiceCommission($wallet->phone, $wallet->password, '1691'); // 1691 MultibankService
        $get_percent_value = $get_commission_values['data']['rate']['percent'];
        $commissionAPI = $pay_value*$get_percent_value/"100";
        // Assert Equals Commission
        $this->assertEquals($commission, $commissionAPI . '.00 руб.');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
