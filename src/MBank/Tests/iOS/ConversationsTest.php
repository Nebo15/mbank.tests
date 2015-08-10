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
        $this->waitForElementDisplayedByElement('Your_balance_Button');
        $this->waitForElementDisplayedByElement('Conversations_Button');
        $this->byElement('Conversations_Button')->click();
        // Assert Сonversations display
        $this->waitForElementDisplayedByElement('Conversations_Displayed');
        // Delete wallet
        if (ENVIRONMENT == 'DEV') {
            $this->getAPIService()->deleteWallet($wallet->phone);
        }
    }
}
