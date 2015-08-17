<?php
namespace MBank;

use AppiumTests;

class Config
{
    private $config = [
        "ios" => [
            "WalletNotActiveMessage" => ["type" => "name", "selector" => "You need to activate your wallet to start using it."],
            "Request code" => ["type" => "name", "selector" => "Request code"],
            "BackToLogin" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[1]"],
            "HaveAnAccount" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAButton[2]"],
            "ForgotPassword" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAButton[3]"],
            "Once a week" => ["type" => "name", "selector" => "Once a week"],
            "Once a month" => ["type" => "name", "selector" => "Once a month"],
            "SearchButton" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAKeyboard[1]/UIAButton[4]"],
            "SteamSearch" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]/UIAStaticText[1]"],
            "SearchField" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATextField[1]"],
            "Commission_assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[12]/UIAStaticText[1]"],
            "Commission" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[12]/UIAStaticText[2]"],
            "Photo_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[4]"],
            "Delete_photo" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[4]/UIAActionSheet[1]/UIACollectionView[1]/UIACollectionCell[4]/UIAButton[1]"],
            "Ident_name1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[2]/UIAStaticText[2]"],
            "Ident_name2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[4]/UIAStaticText[2]"],
            "Ident_name3" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[5]/UIAStaticText[2]"],
            "Ident_name4" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[7]/UIAStaticText[2]"],
            "Contact_screen" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAImage[3]"],
            "Contact" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIATextField[1]/UIAButton[1]"],
            "Phone" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[3]/UIATextField[1]"],
            "PayIN" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[5]"],
            "Sign" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAButton[1]"],
            "Pass_field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIASecureTextField[1]"],
            "Summ" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[3]/UIATextField[2]"],
            "Assert_Nonactive_wallet" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATextField[1]"],
            "Pay_field4" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[11]/UIATextField[1]"],
            "Pay_field5" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[12]/UIATextField[1]"],
            "Repeat payment?" => ["type" => "name", "selector" => "Repeat payment?"],
            "Repeat" => ["type" => "name", "selector" => "Repeat"],
            "Money2Card" => ["type" => "name", "selector" => "Money to card"],
            "Yes, with changes" => ["type" => "name", "selector" => "Yes, with changes"],
            "Multibank" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]/UIAStaticText[1]"],
            "Pay_field3" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[10]/UIATextField[1]"],
            "Эшелон Охранная Система" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[2]"],
            "Цезарь Сателлит" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]"],
            "MГТС с возвратом задолженности" => ["type" => "name", "selector" => "MГТС с возвратом задолженности"],
            "FarPost (Владивосток)" => ["type" => "name", "selector" => "FarPost (Владивосток)"],
            "Internet providers" => ["type" => "name", "selector" => "Internet providers"],
            "OnLime, Ростелеком" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]"],
            "АСВТ (Москва)" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[2]"],
            "Yota Интернет" => ["type" => "name", "selector" => "Yota Интернет"],
            "Mamba" => ["type" => "name", "selector" => "Mamba"],
            "Send statement" => ["type" => "name", "selector" => "Send statement"],
            "After payment" => ["type" => "name", "selector" => "After payment"],
            "Mail_field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[6]/UIATextField[1]"],
            "Цифра Один" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[4]"],
            "WestCall (СПб)" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[6]"],
            "Odnoklassniki_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]"],
            "ВКонтакте" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[4]"],
            "icon_gallery" => ["type" => "name", "selector" => "icon gallery"],
            "Back_To_Services" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAElement[1]"],
            "Telephony" => ["type" => "name", "selector" => "Telephony"],
            "МГТС" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]"],
            "Back from Provider Select" => ["type" => "name", "selector" => "Back from Provider Select"],
            "Security systems" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[12]"],
            "НТВ_Плюс" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]"],
            "Wallet" => ["type" => "name", "selector" => "Wallet"],
            "Payment_systems" => ["type" => "name", "selector" => "Payment systems"],
            "Яндекс.Деньги" => ["type" => "name", "selector" => "Yandex.Money"],
            "Card2Card" => ["type" => "name", "selector" => "Visa/MasterCard transfers"],
            "ПополнениеVisa/MasterCard" => ["type" => "name", "selector" => "Пополнение Visa/MasterCard"],
            "Wallet_Selector" => ["type" => "name", "selector" => "ui radiobutton on"],
            "Back from Pay Mobile" => ["type" => "name", "selector" => "Back from Pay Mobile"],
            "Games_networks" => ["type" => "name", "selector" => "Games and social networks"],
            "Steam" => ["type" => "name", "selector" => "Steam"],
            "Pay_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[8]/UIATextField[1]"],
            "Pay_Field2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[9]/UIATextField[1]"],
            "Payment_method" => ["type" => "name", "selector" => "Payment method"],
            "Пополнение" => ["type" => "name", "selector" => "Пополнение"],
            "Transactions_List" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAStaticText[4]"],
            "Select_Card" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAButton[4]"],
            "Back_dashboard" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[4]"],
            "Cable_networks" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[11]"],
            "Utility_bills" => ["type" => "name", "selector" => "Utility bills"],
            "PayField" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[4]/UIATextView[1]"],
            "Assert_Screen" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]"],
            "Error_Message_text" => ["type" => "name", "selector" => "You have entered an invalid phone number or password. Please, try again."],
            "Error_Message" => ["type" => "name", "selector" => "You entered wrong phone number or password"],
            "Strength_text" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAStaticText[1]"],
            "Password_len" => ["type" => "name", "selector" => "You entered wrong password. It should be minimum 6 letters long."],
            "Secure_Field_1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIASecureTextField[1]"],
            "Secure_Field_2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIATextField[1]"],
            "Change_password_Button" => ["type" => "name", "selector" => "Change password"],
            "Profile_Button" => ["type" => "name", "selector" => "Profile"],
            "Wallet_Not_Ident" => ["type" => "name", "selector" => "destination_wallet_not_identified"],
            "Login_Screen" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[1]/UIATextField[1]"],
            "Error_Password" => ["type" => "name", "selector" => "You entered wrong SMS-code. Check it and try again."],
            "Limit_message" => ["type" => "name", "selector" => "You exceeded retry limit for wallet activation. Contact support: support@wallet.best"],
            "Exist_phone" => ["type" => "name", "selector" => "Wallet with this phone number already exists."],
            "Request_Password" => ["type" => "name", "selector" => "Request password"],
            "Change_Password_Alert" => ["type" => "name", "selector" => "Password changed"],
            "Cards_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[6]"],
            "Empty_list_Button" => ["type" => "name", "selector" => "Empty list"],
            "Add_New_card_Button" => ["type" => "name", "selector" => "Add new card"],
            "Back_to_Profile_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[4]"],
            "Add_card_number_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIATextField[1]"],
            "Add_MM_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIATextField[2]"],
            "Add_YY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIATextField[3]"],
            "CVV_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIATextField[4]"],
            "Cardholder_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIATextField[5]"],
            "Done_Button" => ["type" => "name", "selector" => "Done"],
            "Cancel_Button" => ["type" => "name", "selector" => "Cancel"],
            "Remove_Card_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[2]/UIAButton[1]"],
            "DA_Button" => ["type" => "name", "selector" => "Да"],
            "Delete_Card_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]"],
            "Password_Field_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIASecureTextField[1]"],
            "Phone_Field_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIATextField[1]"],
            "Skip_Button" => ["type" => "name", "selector" => "Skip"],
            "Sign_in_Button" => ["type" => "name", "selector" => "Sign in"],
            "Add_funds_Button" => ["type" => "name", "selector" => "Add funds"],
            "Cash_Button" => ["type" => "name", "selector" => "Cash"],
            "Map_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAMapView[1]"],
            "Your_balance_Button" => ["type" => "name", "selector" => "Your balance"],
            "Conversations_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAButton[7]"],
            "Conversations_Displayed" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[3]/UIAStaticText[1]"],
            "Add_Card_Button" => ["type" => "name", "selector" => "Add card"],
            "GO_Button" => ["type" => "name", "selector" => "Sign in"],
            "First_Card_Assert" => ["type" => "name", "selector" => "4652 06** **** 2338"],
            "Second_Card_Assert" => ["type" => "name", "selector" => "5417 15** **** 6825"],
            "Registration_Button" => ["type" => "name", "selector" => "Registration"],
            "Menu_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[4]"],
            "OK_Button" => ["type" => "name", "selector" => "OK"],
            "Change the PIN" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[2]N"],
            "OK_Button_Sign" => ["type" => "name", "selector" => "OK"],
            "Log out" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[5]"],
            "Wallet_Balance" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAStaticText[2]"],
            "Transactions_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]"],
            "Wallet_Balance_View" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAStaticText[5]"],
            "Amount_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATextField[1]"],
            "PAY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]"],
            "Alert_Pay_Message" => ["type" => "name", "selector" => "Enter the amount"],
            "Alert_Message" => ["type" => "name", "selector" => "You exceeded maximum refill amout"],
            "Settings_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[7]"],
            "Delete_temporary_data" => ["type" => "name", "selector" => "Delete temporary data"],
            "YES_Button" => ["type" => "name", "selector" => "Yes"],
            "Assert_Delete_TEMP" => ["type" => "name", "selector" => "Temporary data deleted"],
            "View_limits" => ["type" => "name", "selector" => "View limits"],
            "Limits_table" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]"],
            "Transfer_Button" => ["type" => "name", "selector" => "Transfer"],
            "Verification_Button1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[5]"],
            "Family_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[2]/UIATextField[1]"],
            "Given_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[3]/UIATextField[1]"],
            "Patronymic_name" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[4]/UIATextField[1]"],
            "Passport_series_number" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[5]/UIATextField[1]"],
            "Passport_issued_at" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[6]/UIATextField[1]"],
            "Itn" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[7]/UIATextField[1]"],
            "Next_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[9]/UIAButton[1]"],
            "Invalid_Personal_Number_Alert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAStaticText[1]"],
            "Add_Photo_Button" => ["type" => "name", "selector" => "Add photo"],
            "Gallery_Button" => ["type" => "name", "selector" => "From gallery"],
            "Moments_Button" => ["type" => "name", "selector" => "Moments"],
            "Photo_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIACollectionView[1]/UIACollectionCell[1]"],
            "Photo_Load" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[5]"],
            "Alert_Message_RF" => ["type" => "name", "selector" => "Thank you! Your information will be reviewed as soon as possible. You will receive a notification after the process will be complete"],
            "Verification" => ["type" => "name", "selector" => "Verification"],
            "Back_Button" => ["type" => "name", "selector" => "Back"],
            "Back_Button_Rus" => ["type" => "name", "selector" => "Cancel"],
            "Assert_Element" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[3]/UIAButton[2]"],
            "Assert_PIN_field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATextField[1]"],
            "Confirm_Button" => ["type" => "name", "selector" => "Confirm"],
            "Pay_button" => ["type" => "name", "selector" => "Pay"],
            "Alert_message" => ["type" => "name", "selector" => "пользователь с таким номером телефона уже зарегистрирован"],
            "Start_button" => ["type" => "name", "selector" => "Next"],
            "Identification_confirmed" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[9]"],
            "PayP2P" => ["type" => 'xpath', "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[3]/UIAButton[2]"],
            "Pay_button_P2P" => ["type" => "name", "selector" => "Pay"],
            "Assert_Yourself" => ["type" => "name", "selector" => "Can't transfer money to yourself"],
            "LoginIN" => ["type" => "name", "selector" => "Sign in"],
            "Pay_buttoN" => ["type" => "name", "selector" => "Pay"],
            "Photo_delete_button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[5]"],
            "Transactions_Assert_PayIN" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[2]/UIATableCell[1]"],
        ],
        "web" => [
            "Go" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Select_Card" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[14]"],
            "Transactions_Assert_PayIN" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[7]"],
            "PayIN" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[3]"],
            "Privacy Policy" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[3]/UIAStaticText[1]"],
            "Privacy_Policy_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[5]"],
            "Public_Offer_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[3]"],
            "Public Offer" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[2]/UIAStaticText[1]"],
            "PasswordField" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "WalletNotActiveMessage" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "Request code" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "BackToLogin" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[1]"],
            "HaveAnAccount" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[1]/UIAStaticText[1]"],
            "ForgotPassword" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[2]/UIAStaticText[1]"],
            "First_Card_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
            "Second_Card_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
            "SearchButton" => ["type" => "name", "selector" => "Done"],
            "SteamSearch" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "SearchField" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Commission_assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[12]"],
            "Commission" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[15]"],
            "Moments_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIACollectionView[1]/UIACollectionCell[1]"],
            "Delete_photo" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Gallery_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIATableView[1]/UIATableCell[1]/UIAStaticText[1]"],
            "Ident_name1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Ident_name2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[3]"],
            "Ident_name3" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[4]"],
            "Ident_name4" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[6]"],
            "1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "3" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[3]"],
            "4" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[4]"],
            "5" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[5]"],
            "6" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[6]"],
            "7" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[7]"],
            "8" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[8]"],
            "9" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[9]"],
            "0" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[10]"],
            "Exist_phone" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
            "Multibank" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[12]"],
            "Money2Card" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[19]"],
            "Pay_buttoN" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Limit_message" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "OK_Button_Sign" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Error_Message" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "Assert_Nonactive_wallet" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "LoginIN" => ["type" => "name", "selector" => "Go"],
            "YES_Without" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Yes, with changes" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Repeat payment?" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
            "Repeat" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Identification_confirmed" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[8]"],
            "Phone" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Card2Card" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[10]"],
            "ПополнениеVisa/MasterCard" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[10]"],
            "Payment_systems" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[17]"],
            "Яндекс.Деньги" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
            "Assert_Yourself" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "Wallet_Not_Ident" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "Pay_button_P2P" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "PayP2P" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Summ" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[2]"],
            "Start_button" => ["type" => "name", "selector" => "Go"],
            "Add_card_button_start" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAWebView[1]/UIAButton[1]"],
            "Invalid_Personal_Number_Alert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Verification_Button1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Back_Button_Rus" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[2]"],
            "Assert_Element" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Cable_networks" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[23]"],
            "НТВ_Плюс" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "Pay_button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[2]"],
            "Utility_bills" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]"],
            "Games_networks" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[14]"],
            "Steam" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[8]"],
            "Pay_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Pay_Field2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[2]"],
            "Pay_field3" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[3]"],
            "Pay_field4" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[4]"],
            "Pay_field5" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[5]"],
            "Pay" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Payment_method" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[7]"],
            "Пополнение" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "Menu_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
            "Strength_text" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
            "Password_len" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
            "Error_Password" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[2]"],
            "Change_Password_Alert" => ["type" => "name", "selector" => "Password changed"],
            "Confirm_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Secure_Field_1" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIASecureTextField[1]"],
            "Secure_Field_2" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "Change_password_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "Profile_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[1]"],
            "Cards_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[1]"],
            "Empty_list_Button" => ["type" => "name", "selector" => "Empty list"],
            "Add_New_card_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Back_to_Profile_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAButton[4]"],
            "Add_card_number_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAWebView[1]/UIATextField[1]"],
            "Add_MM_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAWebView[1]/UIAElement[1]"],
            "Add_YY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAWebView[1]/UIAElement[2]"],
            "CVV_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAWebView[1]/UIATextField[2]"],
            "Cardholder_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[1]/UIAWebView[1]/UIATextField[3]"],
            "Done_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAToolbar[1]/UIAButton[3]"],
            "Remove_Card_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIATableView[1]/UIATableCell[1]/UIAButton[1]"],
            "DA_Button" => ["type" => "name", "selector" => "Да"],
            "Delete_Card_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[6]"],
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
            "Add_Card_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "GO_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Registration_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Wallet_Balance" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[3]"],
            "OK_Button" => ["type" => "name", "selector" => "OK"],
            "Transactions_Assert" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[1]"],
            "Wallet_Balance_View" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[4]"],
            "Amount_Field" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIATextField[1]"],
            "PAY_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[2]/UIAScrollView[3]/UIAButton[1]"],
            "Alert_Pay_Message" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[1]"],
            "Settings_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIALink[2]"],
            "Delete_temporary_data" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAStaticText[5]"],
            "YES_Button" => ["type" => "xpath", "selector" => "//UIAApplication[1]/UIAWindow[1]/UIAScrollView[2]/UIAWebView[1]/UIAButton[3]"],
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
        return $this->config[APP_PLATFORM];
    }
}
