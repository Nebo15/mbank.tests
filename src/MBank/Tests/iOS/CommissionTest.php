<?php

namespace MBank\Tests\iOS;


class CommissionTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testServicesCommission()
    {
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

    public function testCheckCommissionAfterRepeatPay()
    {
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
        $pay_value = 9700; // amount
        $this->waitForElementDisplayedByElement('Pay_Field');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        $this->byElement('Pay_Field')->click();
        $this->byElement('Pay_Field')->value('0931254212');
        $this->byElement('Pay_Field2')->click();
        $this->byElement('Pay_Field2')->value('044583151');
        $this->byElement('Pay_field3')->click();
        $this->byElement('Pay_field3')->value($pay_value);
        if (APP_ENV == 'ios') {
            $this->byName('0')->click();
            $this->byName('0')->click();
            $this->byName('Delete')->click();
        }
        $this->byElement('Done_Button')->click();
        $this->CommissionCheck($wallet, $pay_value);
        // Pay1
        $this->byElement('Pay_buttoN')->click();
        // Pay2
        $this->waitForElementDisplayedByElement('Pay_field4');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        $this->byElement('Pay_buttoN')->click();
        // Pay Confirm
        $this->waitForElementDisplayedByElement('Payment_method');
        $this->waitForElementDisplayedByElement('Pay_buttoN');
        sleep(9);
        $this->byElement('Pay_buttoN')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByElement('Transactions_Assert');
        // Retry Payment
        $this->retryPayWallet();
        // Commission Check
        // TODO
//        $this->CommissionCheck($wallet, $pay_value);
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
}
