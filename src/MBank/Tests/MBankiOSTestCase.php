<?php
namespace MBank\Tests;

abstract class MBankiOSTestCase extends \PHPUnit_Extensions_AppiumTestCase
{
    protected function getConfig()
    {
        return (new \MBank\Config())->getConfig();
    }

    public static $browsers = array(
        array(
            'local' => true,
            'port' => 4723,
            'seleniumServerRequestsTimeout' => 120,
            'browserName' => '',
            'desiredCapabilities' => array(
                'deviceName' => 'iPhone 6',
                'platformVersion' => '8.4',
                'platformName' => 'iOS',
                'app' => APP_PATH,
                'newCommandTimeout' => 999999,
                'sendKeyStrategy' => 'setValue',
                'launchTimeout' => 999999,
            )
        )
    );

    public function setUp()
    {
        if (APP_ENV == 'ios') {
            $this->setDesiredCapabilities(
                array(
                    'deviceName' => 'iPhone 6',
                    'platformVersion' => '8.4',
                    'platformName' => 'iOS',
                    'app' => APP_PATH,
                    'newCommandTimeout' => 999999,
                    'sendKeyStrategy' => 'setValue',
                    'autoAcceptAlerts' => true,
                    'waitForAppScript' => true,
                    'launchTimeout' => 999999,
                )
            );
        } elseif (APP_ENV == 'web') {
            $this->setDesiredCapabilities(
                array(
                    'deviceName' => 'iPhone 6',
                    'platformVersion' => '8.4',
                    'platformName' => 'iOS',
                    'app' => APP_PATH,
                    'newCommandTimeout' => 999999,
                    'autoAcceptAlerts' => true,
                    'waitForAppScript' => true,
                    'launchTimeout' => 999999,
                )
            );
        }
    }

    protected function assertWalletCreated($response, $message = "Failed to create wallet")
    {
        $this->assertTrue($response['meta']['code'] == 200, $message, $response);
    }

    protected function waitForElementDisplayedByName($name, $timeout = 20000)
    {
        $this->waitUntil(
            function () use ($name) {
                $el = $this->byName($name);
                return $el && $el->displayed();
            }, $timeout
        );
    }

    public function byElement($elementName)
    {
        $element = $this->getConfig()[$elementName];
        return $this->by($element['type'], $element['selector']);
    }

    protected function waitForElementDisplayedByXPath($xpath, $timeout = 20000)
    {
        $this->waitUntil(
            function () use ($xpath) {
                $el = $this->byXPath($xpath);
                return $el && $el->displayed();
            }, $timeout
        );
    }

    protected function waitForElementDisplayedById($id, $timeout = 20000)
    {
        $this->waitUntil(
            function () use ($id) {
                $el = $this->byXPath($id);
                return $el && $el->displayed();
            }, $timeout
        );
    }

    protected function waitForElementDisplayedByElement($elementName, $timeout = 20000)
    {
        $self = $this;
        $this->waitUntil(
            function () use ($elementName, $self) {
               $el = $self->byElement($elementName);
               return $el && $el->displayed();
            }, $timeout
         );
    }

    protected function fillPhoneNumberField($phone_number)
    {
        // Remove + sign in the beginning of phone number
        if ($phone_number[0] == "+") {
            $phone_number = substr($phone_number, 1);
        }
        if (APP_ENV == 'web') {
            $this->waitForElementDisplayedByElement('GO_Button');
            $this->byElement('GO_Button')->click();
            $this->waitForElementDisplayedByElement('Phone_Field_Button');
        }
        $phone_number_field = $this->byElement('Phone_Field_Button');
        $phone_number_field->click();
        $phone_number_field->clear();
        $phone_number_field->value($phone_number);
        if (APP_ENV == 'web') {
            $this->byElement('GO_Button')->click();
        }
    }

    protected function fillPasswordField($password)
    {
        if (APP_ENV == 'web') {
            $this->waitForElementDisplayedByElement('GO_Button');
            $this->byElement('GO_Button')->click();
            $this->waitForElementDisplayedByElement('Password_Field_Button');
        }
        $password_field = $this->byElement('Password_Field_Button');
        $password_field->click();
        $password_field->clear();
        $password_field->value($password);
    }

    protected function fillCardForm($card, $mm, $yy, $cvv, $cardHolder)
    {
        if (APP_ENV == 'ios') {
            // Add card number
            $this->waitForElementDisplayedByElement('Add_card_number_Button');
            $this->byElement('Add_card_number_Button')->value($card);
            // Add MM
            $this->byElement('Add_MM_Button')->value($mm);
            // Add YY
            $this->byElement('Add_YY_Button')->value($yy);
            // Add CVV code
            $this->byElement('CVV_Button')->value($cvv);
            // Add CardHolder
            $this->byElement('Done_Button')->click();
            $this->byElement('Cardholder_Button')->value($cardHolder);
            $this->byElement('Add_Card_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(2);
            $this->waitForElementDisplayedByElement('Add_card_number_Button');
            // Add card
            $cardNumber = $this->byElement('Add_card_number_Button');
            $cardNumber->click();
            $cardNumber->value($card);
            // Add YY
            $this->byElement('Add_YY_Button')->click();
            sleep(1);
            $this->tap(1, 194, 616, 10); // add year 17
            $this->byElement('Done_Button')->click();
            // Add CVV code
            $cvvv = $this->byElement('CVV_Button');
            $cvvv->click();
            $cvvv->value($cvv);
            $this->byElement('Done_Button')->click();
            // Add CardHolder
            $cardHolderr = $this->byElement('Cardholder_Button');
            $cardHolderr->click();
            $cardHolderr->value($cardHolder);
            $this->byElement('Done_Button')->click();
            $this->byElement('Add_card_button_start')->click();
        }
    }

    protected function fillCredentialsForm($login, $password)
    {
        $this->fillPhoneNumberField($login);
        $this->fillPasswordField($password);
    }

    protected function fillSignUpForm($login, $password)
    {
        $this->fillCredentialsForm($login, $password);
    }

    protected function fillPinCode($code)
    {
        $this->assertEquals(strlen($code), 4, "PIN code should be 4 number long");

        for ($i = 0; $i < strlen($code); $i++) {
            $this->byName($code[$i])->click();
        }
    }

    protected function fillRegistrationCode($code)
    {
        $this->assertEquals(strlen($code), 6, "PIN code should be 6 number long");

        for ($i = 0; $i < strlen($code); $i++) {
            $this->byName($code[$i])->click();
        }
    }

    protected function skipPinCode()
    {
        $this->waitForElementDisplayedByElement('Skip_Button');
        $this->byElement('Skip_Button')->click();
    }

    protected function signIn($phone, $password)
    {
        $this->waitForElementDisplayedByElement('Sign_in_Button');
        $this->byElement('Sign_in_Button')->click();
        $this->fillCredentialsForm($phone, $password);
        $this->byElement('LoginIN')->click();
    }

    protected function loadDashboard($phone, $password)
    {
        if (APP_ENV == 'web')
        {
            $this->signIn($phone, $password);
        } elseif (APP_ENV == 'ios')
        {
            $this->signIn($phone, $password);
            $this->skipPinCode();
        }
    }

    protected function createWalletAndLoadDashboard()
    {
        if (ENVIRONMENT == 'DEV') {
            $wallet = $this->generateWalletData();

            // Create wallet over API
            $this->getAPIService()->createActiveWallet($wallet->phone, $wallet->password);

            // SignIn and skip to Dashboard
            $this->loadDashboard($wallet->phone, $wallet->password);

            return $wallet;

        } elseif (ENVIRONMENT == 'STG') {
            $wallet = $this->generateWalletData();

            // SignIn and skip to Dashboard
            $this->loadDashboard($wallet->phone, $wallet->password);

            return $wallet;
        }
    }

    protected function backToLogin()
    {
        if (APP_ENV == 'ios') {
            $this->waitForElementDisplayedByElement('BackToLogin');
            $this->byElement('BackToLogin')->click();
        } elseif (APP_ENV == 'web') {
            sleep(3);
            $this->tap(1, 50, 62, 10); // Back To DashBoard
        }
    }

    protected function backToDashBoard()
    {
        if (APP_ENV == 'ios') {
            $this->byElement('Menu_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(3);
            $this->tap(1, 50, 62, 10); // Back To DashBoard
        }
    }

    protected function submitProfileButton()
    {
        if (APP_ENV == 'ios') {
            $this->waitForElementDisplayedByElement('Profile_Button');
            $this->byElement('Profile_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(2);
            $this->tap(1, 214, 218, 10); // Web Profile Button
        }
    }

    protected function submitPhotoButton()
    {
        if (APP_ENV == 'ios') {
            $this->waitForElementDisplayedByElement('Add_Photo_Button');
            $this->byElement('Add_Photo_Button')->click();
        } elseif (APP_ENV == 'web') {
            sleep(1);
            $this->tap(1, 190, 165, 10); // Web Profile Button
        }
    }

    protected function createWalletAndLoadDashboardWithPIN()
    {
        if (ENVIRONMENT == 'DEV') {
            $wallet = $this->generateWalletData();

            // Create wallet over API
            $this->getAPIService()->createActiveWallet($wallet->phone, $wallet->password);

            $this->signIn($wallet->phone, $wallet->password);

            return $wallet;

        } elseif (ENVIRONMENT == 'STG') {
            $wallet = $this->generateWalletData();

            $this->signIn($wallet->phone, $wallet->password);

            return $wallet;
        }
    }

    protected function generateWalletData()
    {
        $generator = new \MBank\Services\WalletGenerationService();
        return $generator->getWallet();
    }

    protected function getAPIService()
    {
        return new \MBank\Services\MBankAPIService();
    }
}
