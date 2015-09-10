<?php
namespace MBank\Tests\iOS;


class MessageCounterTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Message
     */
    public function testMessageCounterUnread()
    {
        // Login to wallet
        $this->loadDashboard('+380931254212', 'qwerty');
        // Assert Dashboard Elements
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->waitForElementDisplayedByElement('Transfer_Button');
        // Assert Unread Messages
        $this->waitForElementDisplayedByElement('MessageCounter');
    }
}
