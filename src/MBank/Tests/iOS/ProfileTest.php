<?php
namespace MBank\Tests\iOS;

class ProfileTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Profile
     */
    public function testUploadPhoto()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        // Add photo in profile
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        // Load photo
        $this->submitPhotoButton();
        $this->waitForElementDisplayedByElement('Gallery_Button');
        $this->byElement('Gallery_Button')->click();
        $this->waitForElementDisplayedByElement('Moments_Button');
        $this->byElement('Moments_Button')->click();
        if (APP_PLATFORM == 'ios') {
            // Check photo directory
            $this->waitForElementDisplayedByElement('Photo_Assert');
            $this->byElement('Photo_Assert')->click();
            $this->waitForElementDisplayedByElement('OK_Button');
            $this->byElement('OK_Button')->click();
            // Check photo was actually uploaded in app
            $this->waitForElementDisplayedByElement('Photo_Load');
        }
        // Check that photo was actually uploaded
        sleep(5);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertTrue(array_key_exists('picture_url', $wallet_data['data']), "Can't find profile image");
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Profile
     */
    public function testDeletePhoto()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        // Add photo in profile
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->submitProfileButton();
        // Load photo
        $this->submitPhotoButton();
        $this->waitForElementDisplayedByElement('Gallery_Button');
        $this->byElement('Gallery_Button')->click();
        $this->waitForElementDisplayedByElement('Moments_Button');
        $this->byElement('Moments_Button')->click();
        if (APP_PLATFORM == 'ios') {
            // Check photo directory
            $this->waitForElementDisplayedByElement('Photo_Assert');
            $this->byElement('Photo_Assert')->click();
            $this->waitForElementDisplayedByElement('OK_Button');
            $this->byElement('OK_Button')->click();
            // Check photo was actually uploaded in app
            $this->waitForElementDisplayedByElement('Photo_Load');
        }
        // Check that photo was actually uploaded
        sleep(5);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertTrue(array_key_exists('picture_url', $wallet_data['data']), "Can't find profile image");
        // Delete photo in profile
        if (APP_PLATFORM == 'web') {
            $this->submitPhotoButton();
        } elseif (APP_PLATFORM == 'ios') {
            $this->waitForElementDisplayedByElement('Photo_delete_button');
            $this->byElement('Photo_delete_button')->click();
        }
        $this->waitForElementDisplayedByElement('Delete_photo');
        $this->byElement('Delete_photo')->click();
        // Check that photo was actually deleted
        sleep(5);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertFalse(array_key_exists('picture_url', $wallet_data['data']), "Profile image present");
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Profile
     */
    public function testVerify()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        if (APP_PLATFORM == 'web') {
            $this->waitForElementDisplayedByElement('P2P');
            $this->byElement('P2P')->click();
        }
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
        sleep(2);
        $this->byElement('Your_balance_Button')->click();
        $this->waitForElementDisplayedByElement('Pay_button');
        $this->byElement('Pay_button')->click();
        // Back To DashBoard
        $this->backToDashBoard();
        $this->byElement('Your_balance_Button')->click();
        sleep(2);
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        if (APP_PLATFORM == 'web') {
            $this->waitForElementDisplayedByElement('P2P');
            $this->byElement('P2P')->click();
        }
        $this->waitForElementDisplayedByElement('Assert_Element');
        // Assert Verification Data
        if (APP_PLATFORM == 'ios') {
            $this->tap(1, 50, 62, 10); // Back To DashBoard
            $this->submitProfileButton();
            sleep(1);
            $this->tap(1, 188, 429, 10); // Your wallet is verified
        } elseif (APP_PLATFORM == 'web') {
            sleep(1);
            $this->tap(1, 50, 62, 10); // Back to P2P screen
            sleep(1);
            $this->tap(1, 50, 62, 10); // Back to dashboard
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->submitProfileButton();
            sleep(1);
            $this->tap(1, 180, 435, 10); // Identification_confirmed
        }
        // Assert User Data in Profile
        $this->waitForElementDisplayedByElement('Ident_name1');
        $this->assertEquals(trim($this->byElement('Ident_name1')->text(), '\! '), $wallet->person->family_name);
        $this->assertEquals(trim($this->byElement('Ident_name2')->text(), '\! '), $wallet->person->given_name);
        if (APP_PLATFORM == 'ios') {
            $this->assertEquals(trim($this->byElement('Ident_name3')->text(), '\! '), "Verified");
        }
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }

    /**
     * @group Profile
     */
    public function testVerifyWithIncorrectData()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        $this->byElement('Transfer_Button')->click();
        if (APP_PLATFORM == 'web') {
            $this->waitForElementDisplayedByElement('P2P');
            $this->byElement('P2P')->click();
        }
        $this->waitForElementDisplayedByElement('Verification_Button1');
        $this->byElement('Verification_Button1')->click();
        // Set Invalid Data
        $this->waitForElementDisplayedByElement('Family_name');
        $this->waitForElementDisplayedByElement('Given_name');
        sleep(1);
        $this->byElement('Family_name')->click();
        $this->byElement('Family_name')->value('lol');
        $this->byElement('Given_name')->click();
        $this->byElement('Given_name')->value('name');
        $this->byElement('Patronymic_name')->click();
        $this->byElement('Patronymic_name')->value('test');
        $this->byElement('Birthday')->click();
        sleep(1);
        $this->byElement('Birthday')->value('01011975');
        $this->waitForElementDisplayedByElement('Done_Button');
        $this->byElement('Done_Button')->click();
        $this->byElement('Passport_series_number')->click();
        $this->byElement('Passport_series_number')->value('furman');
        $this->byElement('Itn')->click();
        $this->byElement('Itn')->value('202701490562');
        $this->byElement('Passport_issued_at')->click();
        sleep(1);
        $this->byElement('Passport_issued_at')->value('1970.01.01');
        $this->waitForElementDisplayedByElement('Done_Button');
        $this->byElement('Done_Button')->click();
        if (APP_PLATFORM == 'ios') {
            $this->byElement('Next_Button')->click();
        } elseif (APP_PLATFORM == 'web') {
            $this->byElement('Go')->click();
        }
        $this->byElement('Itn')->click();
        // Assert Alert
        $this->waitForElementDisplayedByElement('Invalid_Personal_Number_Alert');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
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
        $this->submitProfileButton();
        // Check the limits is displayed
        $this->waitForElementDisplayedByElement('View_limits');
        $this->byElement('View_limits')->click();
        $this->waitForElementDisplayedByElement('Limits_table');
        // Delete wallet
        if (APP_ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}