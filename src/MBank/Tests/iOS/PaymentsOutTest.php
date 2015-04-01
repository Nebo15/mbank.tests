<?php
namespace MBank\Tests\iOS;

class PaymentsOutTest extends \MBank\Tests\MBankiOSTestCase
{
    protected $wallet;

    public function setUp()
    {
        $this->wallet = $this->generateWalletData();
    }

    public function testPayOutWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServices();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals('9990', $wallet_data['data']['amount']);
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayOutCard()
    {
        $this->createWalletAndLoadDashboard();
        // Add Card
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        $this->fillCardVisaForm();
        // Back to DashBoard
        $this->byName('Back to Profile icon')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
        // Pay from Card
        $this->cardPayServices();
        // Assert Transactions Log
        $this->waitForElementDisplayedByName('Repeat');
        // Pay from card retry
        $this->retryPayCard();
        // Delete wallet
        $this->getAPIService()->deleteWallet($this->wallet->phone);
    }

    public function testPayOutMultibankWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServiceMultibank();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals('9939', $wallet_data['data']['amount']);
        // Retry Pay Wallet With Changes
        $this->retryPayWallet();
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayOutTricolorWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServiceTricolor();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals('9999', $wallet_data['data']['amount']);
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayService()
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
        // Pay Into service
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Payment systems')->click();
        $this->byName('Яндекс.Деньги')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
            ->value('1234567');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
            ->value('1');
        // Pay
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

    public function testServicesViews()
    {
        $this->createWalletAndLoadDashboard();
        // Check services views
        $this->gamesDirectory();
        $this->telephonyDirectory();
        $this->securitySystemsDirectory();
        $this->paymentSystems();
        $this->internetProviders();
        // Delete wallet
        $this->getAPIService()->deleteWallet($this->wallet->phone);
    }

    public function walletPayServices()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Games and social networks')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->byName('Steam')->click();
        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue->click();
        $setValue->value('633336');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('10');
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByName('Steam');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAStaticText[4]');
    }

    public function walletPayServiceMultibank()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Card2Card')->click();
        // Submit Multibank service
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[6]')->click();
        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay1
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('0931254212');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('044583151');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[10]/UIATextField[1]')
             ->value('1');
        $this->byName('Pay')->click();
        // Pay2
        $this->waitPayDisplay();
        $setValue2 = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue2->click();
        $setValue2->value('testlol');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('random');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[10]/UIATextField[1]')
             ->value('11111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[11]/UIATextField[1]')
             ->value('test');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]')
             ->value('tested');
        $this->byName('Pay')->click();
        // Confirm Pay
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(2);
        $this->byName('Pay')->click();
        // Check Transaction Log
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function cardPayServices()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Games and social networks')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->byName('Steam')->click();
        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue1 = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $setValue1->click();
        $setValue1->value('50444');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('11');
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function walletPayServiceTricolor()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Cable networks')->click();
        $this->byName('НТВ Плюс')->click();
        // Wait pay screen
        $this->waitForElementDisplayedByName('hex transparent');
        // Pay1
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('1234567890');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('1');
        $this->byName('Pay')->click();
        // Confirm Pay
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(4);
        $this->byName('Pay')->click();
        // Check Transaction Log
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    protected function fillCardVisaForm()
    {
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

    public function retryPayCard()
    {
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function retryPayWallet()
    {
        $this->byName('Repeat')->click();
        $this->waitForElementDisplayedByName('Repeat payment?');
        $this->byName('Yes, with changes')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Pay')->click();
        $this->waitPayDisplay();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]')
             ->click();
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Wallet');
        sleep(2);
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByXPath(' //UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function waitPayDisplay()
    {
        sleep(12);
        $this->waitForElementDisplayedByName('hex transparent');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        sleep(1);
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

    public function gamesDirectory()
    {
        $this->waitForElementDisplayedByName('Pay');
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Games and social networks');
        $this->byName('Games and social networks')->click();
        $this->byName('Steam')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[2]')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('ВКонтакте');
        $this->byName('ВКонтакте')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->byName('icon gallery')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[4]');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
    }

    public function telephonyDirectory()
    {
        $this->byName('Telephony')->click();
        $this->byName('МГТС')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('МГТС');
        $this->byName('Back from Provider Select')->click();
    }

    public function securitySystemsDirectory()
    {
        $this->byName('Security systems')->click();
        $this->byName('Эшелон Охранная Система')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Эшелон Охранная Система');
        $this->byName('Цезарь Сателлит')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->byName('Back from Provider Select')->click();
    }

    public function paymentSystems()
    {
        $this->byName('Payment systems')->click();
        $this->byName('MГТС с возвратом задолженности')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('MГТС с возвратом задолженности');
        $this->byName('FarPost (Владивосток)')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->byName('Back from Provider Select')->click();
    }

    public function internetProviders()
    {
        $this->waitForElementDisplayedByName('Internet providers');
        $this->byName('Internet providers')->click();
        $this->byName('Rline Махачкала')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Rline Махачкала');
        $this->byName('Ru-center')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Ru-center');
        $this->byName('Subnet Махачкала')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Subnet Махачкала');
        $this->byName('LovePlanet')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('LovePlanet');
        $this->byName('АВК Оператор Связи (Люберцы)')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('АВК Оператор Связи (Люберцы)');
        $this->byName('KaspNet (Каспийск)')->click();
        $this->waitForElementDisplayedByName('hex transparent');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('KaspNet (Каспийск)');
        $this->byName('Back from Provider Select')->click();
    }
}
