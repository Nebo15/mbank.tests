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
        }, 20000);
    }

    public function testLoginPositive()
    {
        //accept alert
        sleep(2);
//        TODO Wait for elements
//        $this->waitForElementDisplayed($this->byName('OK'));
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
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]')
            ->value('380931254212');
    }

    public function fillPassword()
    {
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIASecureTextField[1]')
            ->value('qwerty');
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
