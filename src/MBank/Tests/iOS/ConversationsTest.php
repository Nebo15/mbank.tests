<?php

namespace MBank\Tests\iOS;


class ConversationsTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Conversations
     */
    public function testConversations()
    {
        $wallet = $this->createWalletAndLoadDashboard();
        // Check conversations link
        $this->waitForElementDisplayedByName('Your balance');
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[7]')
             ->click();
        // Assert conversations display
        $Support = $this->byXPath('//UIAApplication[1]/UIAWindow[4]/UIAStaticText[1]');
        $this->assertTrue($Support->displayed());
        // Back to Dashboard
        $this->byName('intercom close button')->click();
        $this->waitForElementDisplayedByName('Your balance');
        // Delete wallet
        $this->getAPIService()->deleteWallet($wallet->phone);
    }
}
