<?php
namespace MBank\Services;

class MBankAPIService
{
    protected $client;
    protected $api_url = 'http://api.mbank.nebo15.me/';
    protected $admin_login = 'reaper';
    protected $admin_password = 'AefGYU7343';

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->client->setDefaultOption('headers/Content-type', 'application/json');
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

    public function createActiveWallet($phone, $password)
    {
        $wallet = $this->createWallet($phone, $password);
        $activation_code = $this->getActivationCodeFromJSON($wallet);
        if (!$this->activateWalletWithCode($phone, $activation_code)) {
            exit("Can't activate wallet '{$phone}' with code '{$activation_code}'");
        }
        return $wallet;
    }

    public function getWallet($phone, $password)
    {
        $request_url = $this->api_url . 'v1/wallet';
        return $this->client->get($request_url, ['auth' => [$phone, $password]])->json();
    }

    public function deleteWallet($phone)
    {
        // TODO this is not working, fixme
        $request_url = $this->api_url . 'adm/wallet/' . $phone;
        return $this->client->delete($request_url, ['auth' => [$this->admin_login, $this->admin_password], 'debug' => true])->json();
    }
}
