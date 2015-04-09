<?php
namespace MBank\Tests\iOS;

class PaymentsOutTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testOutFromWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServices();
        // Check Balance
        $Balance = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[2]')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'].'.00a');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testOutFromCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        $this->fillCardForm('4652060724922338','01','17','989','testtest');
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
        // Back to DashBoard
        $this->byName('Back to Profile icon')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
        // Pay from Card
        $this->cardPayServices();
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayOutTricolorWallet()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->walletPayServiceTricolor();
        // Check Balance
        $Balance = $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[2]')->text();
        // Check Balance in Wallet (API)
        sleep(1);
        $wallet_data = $this->getAPIService()->getWallet($wallet->phone, $wallet->password);
        $this->assertEquals($Balance, $wallet_data['data']['amount'].'.00a');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayService()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        // Pay Into service
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Payment systems')->click();
        $this->byName('Яндекс.Деньги')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Pay')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
            ->value('1111111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
            ->value('10');
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

    public function testServicesLoad()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        // Check services views
        $this->gamesDirectory();
        $this->telephonyDirectory();
        $this->securitySystemsDirectory();
        $this->paymentSystems();
        $this->internetProviders();
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }

    public function testPayCardToCard()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        $this->byName('Profile')->click();
        $this->byName('My cards')->click();
        $this->waitForElementDisplayedByName('My cards');
        $this->waitForElementDisplayedByName('Empty list');
        $this->waitForElementDisplayedByName('Add new card');
        $this->waitForElementDisplayedByName('Back to Profile icon');
        // Add Card
        $this->byName('Add new card')->click();
        $this->fillCardForm('4652060724922338','01','17','989','testtest');
        // Assert Card Is Added
        $this->waitForElementDisplayedByName('4652 06** **** 2338');
        // Back to Dashboard
        $this->byName('Back to Profile icon')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAButton[1]')->click();
        $this->waitForElementDisplayedByName('Profile');
        $this->byName('Transfer')->click();
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        // Pay Card to Card
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Card2Card')->click();
        $this->byName('Пополнение Visa/MasterCard')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Pay')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('1111111111111111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('10');
        // Pay
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
        $this->waitForElementDisplayedByName('Verification');
        $this->byName('Next')->click();
        // Set Valid Data
        $this->fillIndentForm($wallet);
        // Personified User
        $this->getAPIService()->verifyWallet($wallet->phone);
        // Check P2P Button
        $this->byName('Your balance')->click();
        $this->byName('Profile')->click();
        $this->byName('Menu icon')->click();
        // Pay Card to Card
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Card2Card')->click();
        $this->byName('Пополнение Visa/MasterCard')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Pay')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('1111111111111111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
             ->value('10');
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

    public function walletPayServices()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Games and social networks')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->byName('Steam')->click();
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Pay')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
             ->value('11111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
            ->value('10');
        // Pay
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByName('Steam');
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAStaticText[4]');
        // Back To DashBoard
        $this->byName('Menu icon')->click();
        $this->waitForElementDisplayedByName('Your balance');
    }

    public function cardPayServices()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Games and social networks')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->byName('Steam')->click();
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Pay')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
            ->value('1111111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
            ->value('10');
        $this->byName('Pay')->click();
        $this->waitForElementDisplayedByName('Payment method');
        $this->waitForElementDisplayedByName('Пополнение');
        $this->byName('ui radiobutton off')->click();
        $this->byName('Pay')->click();
        // Check Transaction in List
        $this->waitForElementDisplayedByName('OK');
        $this->acceptAlert();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]');
    }

    public function walletPayServiceTricolor()
    {
        $this->byName('Pay')->click();
        // Select Service
        $this->waitForElementDisplayedByName('Utility bills');
        $this->byName('Cable networks')->click();
        $this->byName('НТВ Плюс')->click();
        // Pay
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Pay')->click();
        $this->byName('Pay')->click();
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]')
            ->value('1111111111');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]')
            ->value('10');
        // Pay
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
        // Back To DashBoard
        $this->byName('Menu icon')->click();
        $this->waitForElementDisplayedByName('Your balance');
    }

    /**
     * @param $wallet //TODO выпилить после правок метода в файлике APIService
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
        $this->waitForElementDisplayedByName('Verification');
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
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Steam');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[2]')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('ВКонтакте');
        $this->byName('ВКонтакте')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
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
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('МГТС');
        $this->byName('Back from Provider Select')->click();
    }

    public function securitySystemsDirectory()
    {
        $this->byName('Security systems')->click();
        $this->byName('Эшелон Охранная Система')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Эшелон Охранная Система');
        $this->byName('Цезарь Сателлит')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->byName('Back from Provider Select')->click();
    }

    public function paymentSystems()
    {
        $this->byName('Payment systems')->click();
        $this->byName('MГТС с возвратом задолженности')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('MГТС с возвратом задолженности');
        $this->byName('FarPost (Владивосток)')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->byName('Back from Provider Select')->click();
    }

    public function internetProviders()
    {
        $this->waitForElementDisplayedByName('Internet providers');
        $this->byName('Internet providers')->click();
        $this->byName('Rline Махачкала')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->byName('Ru-center')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Ru-center');
        $this->byName('Subnet Махачкала')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('Subnet Махачкала');
        $this->byName('LovePlanet')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('LovePlanet');
        $this->byName('АВК Оператор Связи (Люберцы)')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('АВК Оператор Связи (Люберцы)');
        $this->byName('KaspNet (Каспийск)')->click();
        $this->waitForElementDisplayedByXPath('//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]');
        $this->byName('Back from Pay Mobile')->click();
        $this->waitForElementDisplayedByName('KaspNet (Каспийск)');
        $this->byName('Back from Provider Select')->click();
    }
}
