<?php
namespace MBank\Services;

class WalletGenerationService
{
    public function getPassword($strong = false)
    {
        if (APP_ENVIRONMENT == 'DEV') {
            $alpha = "abcdefghijklmnopqrstuvwxyz";
            $alpha_upper = strtoupper($alpha);
            $password_chars = $alpha . $alpha_upper;
            if ($strong === true) {
                $password_chars .= "`-/:;()$&@\".,?!'[]{}#%^*+=_|~<>1234567890";
            }
            $password_length = rand(6, 12);
            $password = "";
            for ($i = 0; $i < $password_length; $i++) {
                $password .= substr($password_chars, rand(0, strlen($password_chars) - 1), 1);
            }
            return $password;

        } elseif (APP_ENVIRONMENT == 'STG') {

            return $password = "testtedt";
        }
    }

    public function getSSN()
    {
        $fake_ssns = ['11625484952', '12706363948', '14601471834'];
        return $fake_ssns[rand(0, count($fake_ssns)-1)];
    }

    public function getITN()
    {
        $fake_itns = ['602701490561', '071002233173'];
        return $fake_itns[rand(0, count($fake_itns)-1)];
    }

    public function getPassportSeriesNumber()
    {
        $fake_passports = ['4506081'. mt_rand(000, 999), '4512770'. mt_rand(000, 999), '6908279'. mt_rand(000, 999)];
        return $fake_passports[rand(0, count($fake_passports)-1)];
    }

    public function getCellularPhoneNumber()
    {
        if (APP_ENVIRONMENT == 'DEV') {
        return "+15662" . mt_rand(100000, 999999);

    } elseif (APP_ENVIRONMENT == 'STG')
        {
            return "+380631345678";
        }
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
        $wallet->person->patronymic_name = $faker->lastName('male');
        $wallet->person->passport_series_number = $this->getPassportSeriesNumber();
        $wallet->person->passport_issued_at = $faker->date('Y.m.d');
        $wallet->person->itn = $this->getITN();
        $wallet->person->ssn = $this->getSSN();

        return $wallet;
    }
}
