<?php
namespace MBank\Services;

class MBankAPIService
{
    protected $client;
    protected $api_url = 'https://www.synq.ru/mserver2-dev/';
    protected $admin_login = 'reaper';
    protected $admin_password = 'AefGYU7343';

    public function __construct()
{
    $this->client = new \GuzzleHttp\Client();
    $this->client->setDefaultOption('headers/Content-type', 'application/json');
    $this->client->setDefaultOption('headers/X-Project-ID', 'mbank');
}

    public function createWallet($phone, $password)
    {
        $request_url = $this->api_url . 'v1/wallet';

        $request_body = [
            'phone' => $phone,
            'password' => $password,
        ];

        $request = $this->client->post($request_url, [
            'body' => json_encode($request_body),
        ]);

        return $request->json();
    }

    public function getWalletActivationCode($phone)
    {
        $request_url = $this->api_url . 'v1/wallet/resend_code';

        $request_body = [
            'phone' => $phone,
        ];

        $request = $this->client->post($request_url, [
            'body' => json_encode($request_body),
        ]);

        return $this->getActivationCodeFromJSON($request->json());
    }

    private function getActivationCodeFromJSON($json)
    {
        if (!array_key_exists('dev', $json) || !array_key_exists('security_code', $json['dev'])) {
            exit("Can't get activation code from response, is it not DEV server or API has changed?");
        }
        return $json['dev']['security_code'];
    }

    public function activateWalletWithCode($phone, $activation_code)
    {
        $request_url = $this->api_url . 'v1/wallet/activate';

        $request_body = [
            'phone' => $phone,
            'code' => $activation_code,
        ];

        $request = $this->client->post($request_url, [
            'body' => json_encode($request_body),
        ]);

        return $request->json()['meta']['code'] == 200;
    }

    public function getNewPassword($phone)
    {
        $request_url = $this->api_url . 'v1/wallet/send_password_reset_code';

        $request_body = [
            'phone' => $phone,
        ];

        $request = $this->client->post($request_url, [
            'body' => json_encode($request_body),
        ]);

        return $this->getResetCode($request->json());

    }

    private function getResetCode($json)
    {
        if (!array_key_exists('dev', $json) || !array_key_exists('security_code', $json['dev'])) {
            exit("Can't get reset code from response");
        }
        return $json['dev']['security_code'];
    }

    public function verifyWallet($phone)
    {
        $phone = urlencode($phone);
        $request_url = "https://www.synq.ru/mserver2-dev/admin/persons/".$phone."/update_status";

        $request_body = [
            'status' => 'data_verified',
            'level' => 'identified',
        ];

        $response = $this->client->post($request_url, [
            'body' => json_encode($request_body),
            'auth' => ['admin', 'admin'],
        ]);

        return $response->json()['meta']['code'] == 200;
    }

    public function createActiveWallet($phone, $password)
    {
        $wallet = $this->createWallet($phone, $password);
        $activation_code = $this->getActivationCodeFromJSON($wallet);
        if (!$this->activateWalletWithCode($phone, $activation_code)) {
            exit("Can't activate wallet '{$phone}' with code '{$activation_code}'");
        }
        return $wallet;
    }

    public function createNonActiveWallet($phone, $password)
    {
        $wallet = $this->createWallet($phone, $password);

        return $wallet;
    }

    public function getWallet($phone, $password)
    {
            $request_url = 'http://sandbox.wallet.best/v1/wallet';

            return $this->client->get($request_url, ['auth' => [$phone, $password]])->json();
    }

    public function getServiceCommission($phone, $password, $service)
    {
        $request_url = $this->api_url . 'v1/services/'. $service;

        return $this->client->get($request_url, ['auth' => [$phone, $password]])->json();
    }

    public function deleteWallet($phone)
    {
        $request_url = $this->api_url . 'admin/wallets/' . $phone;
        return $this->client->delete($request_url, ['auth' => [$this->admin_login, $this->admin_password], 'debug' => true])->json();
    }

    //TODO Доделать метод загрузки данных клиента и верификации
    public function setLoadUserData($wallet)
    {
        $request_url = $this->api_url . 'v1/wallet/person';

        $request =
               ['family_name' => $wallet->person->family_name,
                'given_name' => $wallet->person->given_name,
                'patronymic_name' => $wallet->person->patronymic_name,
                'passport_series_number' => $wallet->person->passport_series_number,
                'passport_issued_at' => $wallet->person->passport_issued_at,
                'itn' => $wallet->person->itn,
                'ssn' => $wallet->person->ssn,
                ];

        $response = $this->client->post($request_url, [
            'body' => json_encode($request),
            'auth' => [$wallet->phone, $wallet->password],

        ]);

        return $response->json()['meta']['code'] == 200;
    }

    //TODO
    public function setWalletStatus()
    {
        $request_url = $this->api_url . 'v1/wallet/status?webhook_client_id=mserver&webhook_client_token=KbHmgYWND.jy5-a5R~3x48dU';

        $request_body = [
            'personified' => true,
        ];

        $response = $this->client->post($request_url, [
            'body' => json_encode($request_body),
            'auth' => [$this->admin_login, $this->admin_password],
        ]);

        return $response->json()['meta']['code'] == 200;
    }
}
