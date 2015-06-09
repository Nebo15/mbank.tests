<?php
namespace MBank\Tests\iOS;

class ProfileTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testUploadPhoto()
    {
        if (APP_ENV == 'ios') {
            $wallet = $this->createWalletAndLoadDashboard();
//          $this->getAPIService()->setLoadUserData($wallet);
            // Add photo in profile
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->byElement('Profile_Button')->click();
            $this->byElement('Add_Photo_Button')->click();
            $this->byElement('Gallery_Button')->click();
            $this->waitForElementDisplayedByElement('OK_Button');
            $this->byElement('OK_Button')->click();
            // Load photo
            $this->waitForElementDisplayedByElement('Moments_Button');
            $this->byElement('Moments_Button')->click();
            // Check photo directory
            $this->waitForElementDisplayedByElement('Photo_Assert');
            $this->byElement('Photo_Assert')->click();
            $this->waitForElementDisplayedByElement('OK_Button');
            $this->byElement('OK_Button')->click();
            // Check photo was actually uploaded in app
            $this->waitForElementDisplayedByElement('Photo_Load');
            // Check that photo was actually uploaded
            sleep(5);
            $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
            $this->assertTrue(array_key_exists('picture_url', $wallet_data['data']), "Can't find profile image");
            // Delete wallet
            if (ENVIRONMENT == 'DEV') {
                $this->getAPIService()->deleteWallet($wallet->phone);
            }
        } elseif (APP_ENV == 'web') {
            $this->markTestSkipped("Issue not resolved for WEB_APP");
        }
    }

    public function testVerify()
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
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Your_balance_Button')->click();
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Assert Verification Data
        if (APP_ENV == 'ios') {
            $this->byElement('Back_dashboard')->click();
            $this->waitForElementDisplayedByElement('Profile_Button');
            $this->byElement('Profile_Button')->click();
            $this->waitForElementDisplayedByElement('Identification_confirmed');
            $this->byElement('Identification_confirmed')->click();
            // Assert User Data in Profile
            $this->waitForElementDisplayedByElement('Ident_name1');
            $this->assertEquals(trim($this->byElement('Ident_name1')->text(),'\̆! '), $wallet->person->family_name);
            $this->assertEquals(trim($this->byElement('Ident_name2')->text(),'\̆! '), $wallet->person->patronymic_name);
            $this->assertEquals($this->byElement('Ident_name3')->text(), $wallet->person->passport_series_number);
            $this->assertEquals($this->byElement('Ident_name4')->text(), $wallet->person->itn);
            $this->assertEquals($this->byElement('Ident_name5')->text(), $wallet->phone);
        }
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    public function testVerifyWithIncorrectData()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        $this->waitForElementDisplayedByElement('Verification_Button1');
        $this->byElement('Verification_Button1')->click();
        // Set Invalid Data
        $this->byElement('Family_name')->value('lol');
        $this->byElement('Given_name')->value('name');
        $this->byElement('Patronymic_name')->value('test');
        $this->byElement('Passport_series_number')->value('furman');
        $this->byElement('Itn')->click();
        $this->byElement('Itn')->value('202701490562');
        $this->byElement('Passport_issued_at')->value('1970.01.01');
        $this->byElement('Done_Button')->click();
        $this->byElement('Next_Button')->click();
        $this->byElement('Itn')->click();
        // Assert Alert
        $this->waitForElementDisplayedByElement('Invalid_Personal_Number_Alert');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Profile
     */
    public function testLimits()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        if (APP_ENV == 'ios') {
            $this->byElement('Profile_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(1);
            $this->tap(1, 214, 218, 10); //Profile Button
        }
        // Check the limits is displayed
        $this->waitForElementDisplayedByElement('View_limits');
        $this->byElement('View_limits')->click();
        $this->waitForElementDisplayedByElement('Limits_table');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
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