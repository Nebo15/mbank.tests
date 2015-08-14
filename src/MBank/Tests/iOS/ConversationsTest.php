<?php
namespace MBank\Tests\iOS;

class ConversationsTest extends \MBank\Tests\MBankiOSTestCase
{

    /**
     * @group Conversations
     */
    public function testConversations()
    {
        if (APP_PLATFORM == 'ios') {
            $wallet = $this->createWalletAndLoadDashboard();
            // Check conversations link
            $this->waitForElementDisplayedByElement('Your_balance_Button');
            $this->waitForElementDisplayedByElement('Conversations_Button');
            $this->byElement('Conversations_Button')->click();
            // Assert Сonversations display
            $this->waitForElementDisplayedByElement('Conversations_Displayed');
            // Delete wallet
            if (APP_ENVIRONMENT == 'DEV') {
                $this->getAPIService()->deleteWallet($wallet->phone);
            }
        }
    }
}
