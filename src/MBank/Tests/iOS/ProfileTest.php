<?php
namespace MBank\Tests\iOS;


use MBank\Tests\BaseIOSTest;

class ProfileTest extends BaseIOSTest
{

    public function testProfile()
    {
        //login in to cabinet
        $this->testLoginPositive();

        //check profile settings UI
        $this->byName('Profile')->click();
//        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIAButton[2]')
//             ->click();
        $this->byName('Settings')->click();
        sleep(2);
        $this->byName('Turn off the PIN')->click();

        $this->checkCodeScreen();

        $this->byName('btn back')->click();
        $this->byName('Change the PIN')->click();

        $this->checkCodeScreen();

        $this->byName('btn back')->click();
        $this->byName('Request password')->click();
        $this->byName('btn back')->click();
        $this->byName('Delete temporary data')->click();
        $this->byName('Yes')->click();
        sleep(2);
        $this->byName('Public Offer')->click();
        sleep(1);
        $this->byName('Back to Settings icon')->click();
        sleep(1);
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIAButton[2]')
            ->click();

        $checkSingScreen = $this->byName('Sign in');
        $this->assertTrue($checkSingScreen->displayed());

    }

    public function testProfilePhoto()
    {
        $this->testSkipPin();

        //check photo in profile
        $this->byName('Profile')->click();
//        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[2]/UIAButton[2]')
//            ->click();
        $this->byName('Add photo')->click();
        $this->byName('New photo')->click();

        //assert camera ready
        $cameraIcon = $this->byName('grid icon')->text();
        $this->assertEquals('grid icon', $cameraIcon);
        // close camera
        $this->byName('X')->click();

    }

//    public function testAddCards()
//    {
//        $this->testSkipPin();
//        $this->byName('Profile')->click();
//        $this->byName('My cards')->click();
//        sleep(1);
//        $this->byName('Add new card')->click();
//        sleep(3);
//        $this->fillCardVisaForm();
//
//    }


    public function checkCodeScreen()
    {
        $changeCode = $this->byName('Enter code');
        $this->assertTrue($changeCode->displayed());
    }

    public function fillCardVisaForm()
    {
        //add card number
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]')
            ->value('4652060724922339');

        //add MM
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[2]')
            ->value('01');

        //add YY
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[3]')
            ->value('17');

        //add CVV code
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[4]')
            ->value('989');

        //add cardHolder
        $this->byXPath('//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[5]')
            ->value('testtest');

        //add Card
        $this->byName('Add new card')->click();
        $this->byName('Add card')->click();
        sleep(3);

    }
}
