<?php
namespace MBank\Services;

class WalletGenerationService
{
    public function getPassword($strong = false)
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $password_chars = $alpha.$alpha_upper;
        if ($strong === true) {
            $password_chars .= "`-/:;()$&@\".,?!'[]{}#%^*+=_|~<>1234567890";
        }
        $password_length = rand(6, 12);
        $password = "";
        for ($i=0; $i < $password_length; $i++) {
            $password .= substr($password_chars, rand(0, strlen($password_chars)-1), 1);
        }
        return $password;
    }

    public function getSSN()
    {
        $fake_ssns = [05624286562, 12943643682, 02928055571];
        return $fake_ssns[rand(0, count($fake_ssns)-1)];
    }

    public function getITN()
    {
        $fake_itns = [772807592836, 500100732259, 745105884167, 526317984688];
        return $fake_itns[rand(0, count($fake_itns)-1)];
    }

    public function getPassportSeriesNumber()
    {
        $fake_passports = [515302956, 700795731, 514221125];
        return $fake_passports[rand(0, count($fake_passports)-1)];
    }

    public function getCellularPhoneNumber()
    {
        return "+15662" . mt_rand(100000, 999999);
    }

    public function getPinCode()
    {
        return mt_rand(1000, 9999);
    }

    public function getWallet()
    {
        $faker = \Faker\Factory::create("ru_RU");

        $wallet = new \stdClass();
        $wallet->phone = $this->getCellularPhoneNumber();
        $wallet->password = $this->getPassword();
        $wallet->email = $faker->email;
        $wallet->pin_code = $this->getPinCode();

        $wallet->person = new \stdClass();
        $wallet->person->family_name = $faker->lastName('male');
        $wallet->person->given_name = $faker->firstName('male');
        $wallet->person->patronymic_name = $faker->middleName('male');
        $wallet->person->passport_series_number = $this->getPassportSeriesNumber();
        $wallet->person->passport_issued_at = $faker->date('d.m.Y');
        $wallet->person->itn = $this->getITN();
        $wallet->person->ssn = $this->getSSN();

        return $wallet;
    }
}
