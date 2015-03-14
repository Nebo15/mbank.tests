<?php
namespace MBank\Tests\iOS;

// TODO move everything to Payments*Test

class PaymentsTest extends \MBank\Tests\MBankiOSTestCase
{
    public function testTransfer()
    {
        $this->testSkipPin();
        $this->byName('Transfer')->click();

        $this->AttentionAssert();

        $this->byName('Cancel')->click();
        sleep(1);
        $this->byName('Transfer')->click();

        $this->AttentionAssert();

        $this->byName('Next')->click();
        $Citizen = $this->byName('I am a citizen of the RF');
        $this->assertTrue($Citizen->displayed());

    }

    public function testTransferInvalid()
    {
        $this->testSkipPin();
        $this->byName('Transfer')->click();

        $this->AttentionAssert();

        $this->byName('Next')->click();
        sleep(1);

        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]')->value('lol');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]')->value('name');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[3]')->value('test');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[4]')->value('furman');
//TODO set data
//        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]')->value("44/444");
//        $this->byName('Next')->click();


    }

    public function testConversations()
    {
        $this->testSkipPin();

        //check conversations link
        $this->byName('Support')->click();
        $this->byName('retry button')->click();

        //assert conversations display
        $Support = $this->byName('error label');
        $this->assertTrue($Support->displayed());

        //back to profile
        $this->byName('intercom close button')->click();

        sleep(1);
        $balance = $this->byName('Your balance');
        $this->assertTrue($balance->displayed());

    }

    /**
     * @return string
     */
    public function AttentionAssert()
    {
        $Warning = $this->byName('Attention!');
        $this->assertTrue($Warning->displayed());
        return $Warning;
    }
}
