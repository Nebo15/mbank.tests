<?php

namespace MBank;
use AppiumTests;

class Config
{
    private $config = [
        "ios" => [
            "Summ" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]"],
            "Assert_Nonactive_wallet" => ["type" => "name", "selector" => "You have entered an invalid phone number or password. Please, try again."],
            "Pay_field4" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[12]/UIATextField[1]"],
            "Pay_field5" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[11]/UIATextField[1]"],
            "Repeat payment?" => ["type" => "name", "selector" => "Repeat payment?"],
            "Repeat" => ["type" => "name", "selector" => "Repeat"],
            "Yes, with changes" => ["type" => "name", "selector" => "Yes, with changes"],
            "Multibank" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[6]"],
            "Pay_field3" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[10]/UIATextField[1]"],
            "Эшелон Охранная Система" => ["type" => "name", "selector" => "Эшелон Охранная Система"],
            "Цезарь Сателлит" => ["type" => "name", "selector" => "Цезарь Сателлит"],
            "MГТС с возвратом задолженности" => ["type" => "name", "selector" => "MГТС с возвратом задолженности"],
            "FarPost (Владивосток)" => ["type" => "name", "selector" => "FarPost (Владивосток)"],
            "Internet providers" => ["type" => "name", "selector" => "Internet providers"],
            "Rline Махачкала" => ["type" => "name", "selector" => "Rline Махачкала"],
            "Ru-center" => ["type" => "name", "selector" => "Ru-center"],
            "Subnet Махачкала" => ["type" => "name", "selector" => "Subnet Махачкала"],
            "LovePlanet" => ["type" => "name", "selector" => "LovePlanet"],
            "АВК Оператор Связи (Люберцы)" => ["type" => "name", "selector" => "АВК Оператор Связи (Люберцы)"],
            "KaspNet (Каспийск)" => ["type" => "name", "selector" => "KaspNet (Каспийск)"],
            "Odnoklassniki_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[2]"],
            "ВКонтакте" => ["type" => "name", "selector" => "ВКонтакте"],
            "icon_gallery" => ["type" => "name", "selector" => "icon gallery"],
            "Back_To_Services" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[4]"],
            "Telephony" => ["type" => "name", "selector" => "Telephony"],
            "МГТС" => ["type" => "name", "selector" => "МГТС"],
            "Back from Provider Select" => ["type" => "name", "selector" => "Back from Provider Select"],
            "Security systems" => ["type" => "name", "selector" => "Security systems"],
            "НТВ_Плюс" => ["type" => "name", "selector" => "НТВ Плюс"],
            "Wallet" => ["type" => "name", "selector" => "Wallet"],
            "Payment_systems" => ["type" => "name", "selector" => "Payment systems"],
            "Яндекс.Деньги" => ["type" => "name", "selector" => "Яндекс.Деньги"],
            "Card2Card" => ["type" => "name", "selector" => "Card2Card"],
            "ПополнениеVisa/MasterCard" => ["type" => "name", "selector" => "Пополнение Visa/MasterCard"],
            "Wallet_Selector" => ["type" => "name", "selector" => "ui radiobutton on"],
            "Back from Pay Mobile" => ["type" => "name", "selector" => "Back from Pay Mobile"],
            "Games_networks" => ["type" => "name", "selector" => "Games and social networks"],
            "Steam" => ["type" => "name", "selector" => "Steam"],
            "Pay_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[8]/UIATextField[1]"],
            "Pay_Field2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[9]/UIATextField[1]"],
            "Payment_method" => ["type" => "name", "selector" => "Payment method"],
            "Пополнение" => ["type" => "name", "selector" => "Пополнение"],
            "Transactions_List" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAStaticText[4]"],
            "Select_Card" => ["type" => "name", "selector" => "ui radiobutton off"],
            "Back_dashboard" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAButton[1]"],
            "Cable_networks" => ["type" => "name", "selector" => "Cable networks"],
            "Utility_bills" => ["type" => "name", "selector" => "Utility bills"],
            "PayField" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextView[1]"],
            "Assert_Screen" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]"],
            "Error_Message_text" => ["type" => "name", "selector" => "You have entered an invalid phone number or password. Please, try again."],
            "Error_Message" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATextView[2]"],
            "Strength_text" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIAStaticText[1]"],
            "Password_len" => ["type" => "name", "selector" => "invalid_password"],
            "Secure_Field_1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIASecureTextField[1]"],
            "Secure_Field_2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]"],
            "Change_password_Button" => ["type" => "name", "selector" => "Change password"],
            "Profile_Button" => ["type" => "name", "selector" => "Profile"],
            "Wallet_Not_Ident" => ["type" => "name", "selector" => "destination_wallet_not_identified"],
            "Login_Screen" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]"],
            "Error_Password" => ["type" => "name", "selector" => "invalid_code"],
            "Limit_message" => ["type" => "name", "selector" => "failure_limit_exceeded"],
            "Exist_phone" => ["type" => "name", "selector" => "phone_already_exists"],
            "Request_Password" => ["type" => "name", "selector" => "Request password"],
            "Change_Password_Alert" => ["type" => "name", "selector" => "Password changed"],
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
            "Add_Card_Button" => ["type" => "name", "selector" => "Add card"],
            "GO_Button" => ["type" => "name", "selector" => "Sign in"],
            "First_Card_Assert" => ["type" => "name", "selector" => "4652 06** **** 2338"],
            "Second_Card_Assert" => ["type" => "name", "selector" => "5417 15** **** 6825"],
            "Registration_Button" => ["type" => "name", "selector" => "Registration"],
            "Menu_Button" => ["type" => "name", "selector" => "Menu icon"],
            "OK_Button" => ["type" => "name", "selector" => "OK"],
            "Wallet_Balance" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[2]"],
            "Transactions_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]"],
            "Wallet_Balance_View" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[3]"],
            "Amount_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]"],
            "PAY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]"],
            "Alert_Pay_Message" => ["type" => "name", "selector" => "Enter the amount"],
            "Alert_Message" => ["type" => "name", "selector" => "превышен лимит на остаток на счете кошелька"],
            "Settings_Button" => ["type" => "name", "selector" => "Settings"],
            "Delete_temporary_data" => ["type" => "name", "selector" => "Delete temporary data"],
            "YES_Button" => ["type" => "name", "selector" => "Yes"],
            "Assert_Delete_TEMP" => ["type" => "name", "selector" => "Temporary data deleted"],
            "View_limits" => ["type" => "name", "selector" => "View limits"],
            "Limits_table" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableGroup[1]"],
            "Transfer_Button" => ["type" => "name", "selector" => "Transfer"],
            "Verification_Button1" => ["type" => "name", "selector" => "Next"],
            "Family_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[1]"],
            "Given_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[2]"],
            "Patronymic_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[3]"],
            "Passport_series_number" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[4]"],
            "Passport_issued_at" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[5]"],
            "Itn" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextField[6]"],
            "Next_Button" => ["type" => "name", "selector" => "Next"],
            "Invalid_Personal_Number_Alert" => ["type" => "name", "selector" => "Invalid personal number"],
            "Add_Photo_Button" => ["type" => "name", "selector" => "Add photo"],
            "Gallery_Button" => ["type" => "name", "selector" => "From gallery"],
            "Moments_Button" => ["type" => "name", "selector" => "Moments"],
            "Photo_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIACollectionView[1]/UIACollectionCell[1]"],
            "Photo_Load" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAButton[2]"],
            "Alert_Message_RF" => ["type" => "name", "selector" => "Thank you! Your information will be reviewed as soon as possible. You will receive a notification after the process will be complete"],
            "Verification" => ["type" => "name", "selector" => "Verification"],
            "Back_Button" => ["type" => "name", "selector" => "Back"],
            "Back_Button_Rus" => ["type" => "name", "selector" => "Вернуться"],
            "Assert_Element" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIAButton[2]"],
            "Assert_PIN_field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATextField[1]"],
            "Confirm_Button" => ["type" => "name", "selector" => "Confirm"],
            "Pay_button" => ["type" => "name", "selector" => "Pay"],
            "Alert_message" => ["type" => "name", "selector" => "пользователь с таким номером телефона уже зарегистрирован"],
            "Start_button" => ["type" => "name", "selector" => "Next"],
            "PayP2P" => ["type" => "name", "selector" => "Transfer"],
            "Pay_button_P2P" => ["type" => "name", "selector" => "Pay"],
        ],

        "web" => [
            "Pay_button_P2P" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "PayP2P" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Summ" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[2]"],
            "Start_button" => ["type" => "name", "selector" => "Go"],
            "Invalid_Personal_Number_Alert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Verification_Button1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Back_Button_Rus" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Assert_Element" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Cable_networks" => ["type" => "xpath", "selector" => " //UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[16]"],
            "НТВ_Плюс" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
            "Repeat" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Pay_button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[2]"],
            "Utility_bills" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]"],
            "Games_networks" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "Steam" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "Pay_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Pay_Field2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[2]"],
            "Pay" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Payment_method" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[7]"],
            "Пополнение" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "Menu_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
            "Strength_text" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
            "Password_len" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
            "Error_Password" => ["type" => "name", "selector" => "код безопасности не совпадает с отправленным в смс"],
            "Change_Password_Alert" => ["type" => "name", "selector" => "Password changed"],
            "Confirm_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Secure_Field_1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIASecureTextField[1]"],
            "Secure_Field_2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Change_password_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[5]"],
            "Profile_Button" => ["type" => "name", "selector" => "Profile"],
            "Cards_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[1]"],
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
            "Cash_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Map_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]"],
            "Your_balance_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "Conversations_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[6]"],
            "Conversations_Displayed" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
            "Add_Card_Button" => ["type" => "name", "selector" => "Add card"],
            "GO_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Registration_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Wallet_Balance" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[3]"],
            "OK_Button" => ["type" => "name", "selector" => "OK"],
            "Transactions_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]"],
            "Wallet_Balance_View" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAStaticText[3]"],
            "Amount_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIATextField[1]"],
            "PAY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]"],
            "Alert_Pay_Message" => ["type" => "name", "selector" => "Enter the amount"],
            "Alert_Message" => ["type" => "name", "selector" => "превышен лимит на остаток на счете кошелька"],
            "Settings_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[2]"],
            "Delete_temporary_data" => ["type" => "name", "selector" => "Delete temporary data"],
            "YES_Button" => ["type" => "name", "selector" => "Yes"],
            "Assert_Delete_TEMP" => ["type" => "name", "selector" => "Temporary data deleted"],
            "View_limits" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Limits_table" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]"],
            "Transfer_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[4]"],
            "Verification_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Family_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Given_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[2]"],
            "Patronymic_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[3]"],
            "Passport_series_number" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[4]"],
            "Passport_issued_at" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[5]"],
            "Itn" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[6]"],
            "Next_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[4]"],
            "Assert_PIN_field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "Alert_message" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
        ],
    ];

    public function getConfig()
    {
        return $this->config[APP_ENV];
    }
}

