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
        if (APP_PLATFORM == 'ios') {
            $this->byName('0')->click();
            $this->byName('0')->click();
            $this->byName('Delete')->click();
        }
        $this->byElement('Done_Button')->click();
        // Assert Commission displayed
        $this->CommissionCheck($wallet, $pay_value);
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
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
        if (APP_PLATFORM == 'web') {
            $this->assertEquals($commissionAPP, $commissionAPI . '.00 руб.');
        } elseif (APP_PLATFORM == 'ios') {
            $this->assertEquals($commissionAPP, $commissionAPI);
        }
    }
}
