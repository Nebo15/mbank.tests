<?php
namespace MBank\Tests\iOS;

class PINCodeTest extends \MBank\Tests\MBankiOSTestCase
{

    public function testSetPinCode()
    {
        $this->createWalletAndLoadDashboard();

        $this->byName('Profile')->click();
        $this->byName('Settings')->click();

        $this->byName('Turn on the PIN')->click();

        $this->fillPin();
        $this->waitForElementDisplayedByName('Enter the PIN once again');
        $this->fillPin();
        $this->waitForElementDisplayedByName('PIN created');

    }


    // public function testCanSkipOnSecondStep()
    // {

    // }

    // public function testPin()
    // {

    // }

    // public function testPinReset()
    // {

    // }

    // public function testPinWithWrongCode()
    // {

    // }

    // public function testPinTimeout()
    // {

    // }

    protected function fillPin()
    {
        $this->byName('1')->click();
        $this->byName('2')->click();
        $this->byName('3')->click();
        $this->byName('4')->click();
    }
}
