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
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->value('0931254212');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('044583151');
        $this->byElement('Pay_field3')->click();
        $this->byElement('Pay_field3')->value('1');
        $this->byElement('Done_Button')->click();
        // Assert Commission displayed
        $this->waitForElementDisplayedByElement('Commission_assert');
        $this->waitForElementDisplayedByElement('Commission');
        $this->byElement('Pay_buttoN')->click();
        // Assert Commission
        $commission = $this->byElement('Commission')->text();
        // Assert API Commission
        sleep(5);
        $commissionAPI = $this->getAPIService()->getServiceCommission($wallet->phone, $wallet->password);
        //TODO Assert
//        $this->assertEquals($commission, $commissionAPI);
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
