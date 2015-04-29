<?php

namespace MBank;

class Config
{
    private $config = [
        "ios" => [
            "Profile_Button" => ["type" => "name", "selector" => "Profile"],
        ],


        "web" => [
            "Profile_Button" => ["type" => "name", "selector" => "Profile"],
        ]
    ];

    public function getConfig()
    {
        return $this->config[APP_ENV];
    }
}

