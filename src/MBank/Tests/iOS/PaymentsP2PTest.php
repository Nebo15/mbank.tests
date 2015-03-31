<?php
namespace MBank\Tests\iOS;

class PaymentsP2PTest extends \MBank\Tests\MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    public function testWalletToWalletPay()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Attention!');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->personifiedUserData($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]');
        // Pay into friend wallet
        $phone_number = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('+380931254212');
        // Fill pay form
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('10');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextView[1]')->value('BatmanPay');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        // Pay
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Repeat Pay
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testWalletToWalletPayNegative()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Attention!');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->personifiedUserData($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]');
        // Pay into friend wallet not indent
        $phone_number = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('+380988112249');
        // Fill pay form
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('10');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        // Assert Wallet Not Indent
        $this->waitForElementDisplayedByName('адресат перевода не существует');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testCardToWalletPay()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        // Add card
        $this->fillCardForm();
        // Back to Dashboard
        $this->byName('Back to Profile icon')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
        $this->waitForElementDisplayedByName('Profile');
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Attention!');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->personifiedUserData($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]');
        // Pay into friend wallet
        $phone_number = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $phone_number->click();
        $phone_number->clear();
        $phone_number->value('+380931254212');
        // Fill pay form
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('10');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextView[1]')->value('BatmanPay');
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        // Card Pay
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Repeat Pay With Changes
        $this->repeatPay();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayCardToCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        // Add card
        $this->fillCardForm();
        // Back to Dashboard
        $this->byName('Back to Profile icon')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
        $this->waitForElementDisplayedByName('Profile');
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Attention!');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->personifiedUserData($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        // Pay Card to Card
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Card2Card')->click();
        $this->byName('Пополнение Visa/MasterCard')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('1111111111111111');
        $this->byXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('10');
        $this->byName('Done')->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayWalletToCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Attention!');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->personifiedUserData($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        // Pay Card to Card
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Card2Card')->click();
        $this->byName('Пополнение Visa/MasterCard')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('1111111111111111');
        $this->byXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('10');
        $this->byName('Done')->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        // Assert Transactions List
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);

    }

    /**
     * @param $wallet
     */
    public function fillIndentForm($wallet)
    {
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]')
            ->value($wallet->person->family_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')
            ->value($wallet->person->given_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[3]')
            ->value($wallet->person->patronymic_name);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[4]')
            ->value($wallet->person->passport_series_number);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]')
            ->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[5]')
            ->value('1970.11.01');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]')
            ->value($wallet->person->itn);
        $this->byName('Next')->click();
        // Check alert messages before personalisation of user data
        $this->waitForElementDisplayedByName('Thank you! Your information will be reviewed as soon as possible. You will receive a notification after the process will be complete');
        $this->byName('Back')->click();
        $this->waitForElementDisplayedByName('Attention!');
        $this->byName('Вернуться')->click();
        $this->waitForElementDisplayedByName('Profile');
    }

    protected function fillCardForm()
    {
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        // Add card number
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')->value('4652060724922338');
        // Add MM
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[2]')->value('01');
        // Add YY
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[3]')->value('17');
        // Add CVV code
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[4]')->value('989');
        // Add CardHolder
        $this->byName('Done')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[5]')->value('testtest');
        $this->byName('Add card')->click();
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
    }

    public function repeatPay()
    {
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes, with changes')->click();
        $this->waitForElementDisplayedByName('Transfer');
        sleep(1);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]')->click();
        $this->waitForElementDisplayedByName('Payment method');
        sleep(2);
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
    }
}
