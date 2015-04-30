<?php

namespace MBank;

class Config
{
    private $config = [
        "ios" => [
            "Profile_Button" => ["type" => "name", "selector" => "Profile"],
            "Cards_Button" => ["type" => "name", "selector" => "My cards"],
            "Empty_list_Button" => ["type" => "name", "selector" => "Empty list"],
            "Add_New_card_Button" => ["type" => "name", "selector" => "Add new card"],
            "Back_to_Profile_Button" => ["type" => "name", "selector" => "Back to Profile icon"],
            "Add_card_number_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]"],
            "Add_MM_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[2]"],
            "Add_YY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[3]"],
            "CVV_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[4]"],
            "Cardholder_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[5]"],
            "Done_Button" => ["type" => "name", "selector" => "Done"],
            "Remove_Card_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAButton[1]"],
            "DA_Button" => ["type" => "name", "selector" => "Да"],
            "Delete_Card_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]"],
            "Password_Field_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIASecureTextField[1]"],
            "Phone_Field_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]"],
            "Skip_Button" => ["type" => "name", "selector" => "Skip"],
            "Sign_in_Button" => ["type" => "name", "selector" => "Sign in"],
            "Add_funds_Button" => ["type" => "name", "selector" => "Add funds"],
            "Cash_Button" => ["type" => "name", "selector" => "Cash"],
            "Map_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAMapView[1]/UIAElement[1]"],
            "Your_balance_Button" => ["type" => "name", "selector" => "Your balance"],
            "Conversations_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[7]"],
            "Conversations_Displayed" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[4]/UIAStaticText[1]"],
            "Intercom_Button" => ["type" => "name", "selector" => "intercom close button"],
            "Add_Card_Button" => ["type" => "name", "selector" => "Add card"],
            "GO_Button" => ["type" => "name", "selector" => "Sign in"],
        ],


        "web" => [
            "Profile_Button" => ["type" => "name", "selector" => "Profile"],
            "Cards_Button" => ["type" => "name", "selector" => "My cards"],
            "Empty_list_Button" => ["type" => "name", "selector" => "Empty list"],
            "Add_New_card_Button" => ["type" => "name", "selector" => "Add new card"],
            "Back_to_Profile_Button" => ["type" => "name", "selector" => "Back to Profile icon"],
            "Add_card_number_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]"],
            "Add_MM_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[2]"],
            "Add_YY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[3]"],
            "CVV_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[4]"],
            "Cardholder_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[5]"],
            "Done_Button" => ["type" => "name", "selector" => "Done"],
            "Remove_Card_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAButton[1]"],
            "DA_Button" => ["type" => "name", "selector" => "Да"],
            "Delete_Card_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]"],
            "Password_Field_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIASecureTextField[1]"],
            "Phone_Field_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Skip_Button" => ["type" => "name", "selector" => "Skip"],
            "Sign_in_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Add_funds_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[3]"],
            "Cash_Button" => ["type" => "name", "selector" => "Cash"],
            "Map_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAMapView[1]/UIAElement[1]"],
            "Your_balance_Button" => ["type" => "name", "selector" => "Your balance"],
            "Conversations_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[7]"],
            "Conversations_Displayed" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[4]/UIAStaticText[1]"],
            "Intercom_Button" => ["type" => "name", "selector" => "intercom close button"],
            "Add_Card_Button" => ["type" => "name", "selector" => "Add card"],
            "GO_Button" => ["type" => "name", "selector" => "Go"],
        ]
    ];

    public function getConfig()
    {
        return $this->config[APP_ENV];
    }
}

