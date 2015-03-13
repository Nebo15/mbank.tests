<?php

namespace MBank\Tests\iOS;


use MBank\Tests\BaseIOSTest;

class LoginFormTest extends BaseIOSTest
{


    public function testLoginPositive()
    {
        //accept alert
        sleep(2);
        $this->byName('OK')->click();

        sleep(1);
        $this->byName('Sign in')->click();

        //check forgot password window displayed
        $this->byName('Forgot password?')->click();

        $passRecovery = $this->byName('Request code');
        $this->assertTrue($passRecovery->displayed());

        $this->byName('btn back')->click();

        $this->fillPhoneNumber();
        $this->fillPassword();
        sleep(1);
        $this->byName('Sign in')->click();
        sleep(3);
        //enter pin code
        $this->pinCode();

        $secondPIN = $this->byName('Enter the PIN once again');
        $this->assertTrue($secondPIN->displayed());

        $this->pinCode();

        $PIN = $this->byName('Pin created')->text();
        $this->assertEquals('Pin created', $PIN);
        sleep(3);

        $balance = $this->byName('Your balance');
        $this->assertTrue($balance->displayed());

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
        //skip pin code
        $this->byName('Skip')->click();
        sleep(1);

        $balance = $this->byName('Your balance');
        $this->assertTrue($balance->displayed());
    }

    public function testLoginNegative()
    {
        //accept alert
        sleep(1);
        $this->byName('OK')->click();
        sleep(1);
        //submit Sign form
        $this->byName('Sign in')->click();


        $this->fillPhoneNumber();
        $this->fillIncorrectPassword();
        sleep(1);
        $this->byName('Sign in')->click();
        sleep(2);

        $incorrectPass = $this->byName('Please, enter your login and password again');
        $this->assertTrue($incorrectPass->displayed());

        $this->byName('Ok')->click();

    }

    public function testLoginInvalid()
    {
        sleep(2);
        $this->byName('OK')->click();
        sleep(1);
        //submit Sign form
        $this->byName('Sign in')->click();
        $this->fillPassword();
        sleep(1);
        $this->byName('Sign in')->click();

        $AlertMessage = $this->byName('Phone number invalid');
        $this->assertTrue($AlertMessage->displayed());

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

    public function fillIncorrectPassword()
    {
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIASecureTextField[1]')
            ->value('wasted');

    }

    public function pinCode()
    {
        $this->byName('0')->click();
        $this->byName('0')->click();
        $this->byName('0')->click();
        $this->byName('7')->click();
    }
}