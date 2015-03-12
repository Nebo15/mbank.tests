<?php

namespace MBank\Tests;

define("APP_PATH", realpath(dirname(__FILE__) . '/../../../MBankProd.zip'));

if (!APP_PATH) {
    die("App did not exist!");
}

abstract class BaseIOSTest extends \PHPUnit_Extensions_AppiumTestCase
{
    public static $browsers = array(
        array(
            'local' => true,
            'port' => 4723,
            'seleniumServerRequestsTimeout' => 120,
            'browserName' => '',
            'desiredCapabilities' => array(
                'deviceName' => 'iPhone 6',
                'platformVersion' => '8.2',
                'platformName' => 'iOS',
                'app' => APP_PATH,
                'newCommandTimeout' => 160
            )
        )
    );

    protected function waitForElementDisplayed(\PHPUnit_Extensions_Selenium2TestCase_Element $element)
    {
        $this->waitUntil(function () use ($element) {
            return $element->displayed();
        }, 10);
    }

    public function testLoginPositive()
    {
        //accept alert
        sleep(2);
        $this->byName('OK')->click();
        sleep(1);
        //submit Sign form
        $this->byName('Sign in')->click();

        $this->fillPhoneNumber();
        $this->fillPassword();
        sleep(1);
        $this->byName('Sign in')->click();
        sleep(3);
        $this->pinCode();

        $secondPIN = $this->byName('Enter the PIN once again');
        $this->assertTrue($secondPIN->displayed());

        $this->pinCode();
        sleep(3);

        $balance = $this->byName('Your balance');
        $this->assertTrue($balance->displayed());

    }

    public function fillPhoneNumber()
    {
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]')
            ->click();
        $this->byName('Delete')->click();
        $this->byName('3')->click();
        $this->byName('8')->click();
        $this->byName('0')->click();
        $this->byName('9')->click();
        $this->byName('3')->click();
        $this->byName('1')->click();
        $this->byName('2')->click();
        $this->byName('5')->click();
        $this->byName('4')->click();
        $this->byName('2')->click();
        $this->byName('1')->click();
        $this->byName('2')->click();
    }

    public function fillPassword()
    {
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIASecureTextField[1]')
            ->click();

        $this->byName('q')->click();
        $this->byName('w')->click();
        $this->byName('e')->click();
        $this->byName('r')->click();
        $this->byName('t')->click();
        $this->byName('y')->click();
    }

    protected function pinCode()
    {
        $this->byName('0')->click();
        $this->byName('0')->click();
        $this->byName('0')->click();
        $this->byName('7')->click();
    }

    public function testSkipPin()
    {
        //accept alert
        sleep(2);
        $this->byName('OK')->click();
        sleep(1);
        //submit Sign form
        $this->byName('Sign in')->click();

        $this->fillPhoneNumber();
        $this->fillPassword();
        sleep(1);
        $this->byName('Sign in')->click();
        sleep(3);
        $this->byName('Skip')->click();
        sleep(1);

        $balance = $this->byName('Your balance');
        $this->assertTrue($balance->displayed());
    }
}
