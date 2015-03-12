<?php

namespace MBank\Tests\iOS;


use MBank\Tests\BaseIOSTest;

class TransferTest extends BaseIOSTest
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
