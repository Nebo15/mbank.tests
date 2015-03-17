<?php

namespace MBank\Tests\iOS;


class ConversationsTest extends \MBank\Tests\MBankiOSTestCase
{
    public function testConversations()
    {
        $this->createWalletAndLoadDashboard();

        // Check conversations link
        $this->waitForElementDisplayedByName('Your balance');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[7]')
             ->click();
        $this->byName('retry button')->click();

        // Assert conversations display
        $Support = $this->byName('error label');
        $this->assertTrue($Support->displayed());

        // Back to Dashboard
        $this->byName('intercom close button')->click();
        $this->waitForElementDisplayedByName('Your balance');

    }
}
