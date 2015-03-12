<?php

namespace MBank\Tests;


use RemoteWebDriver;


abstract class BaseWEBTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RemoteWebDriver
     */
    protected $webDriver;

    protected function setUp()
    {
        $this->webDriver = $this->createWebDriverInstance();
    }

    public function tearDown()
    {
        $this->webDriver->close();

    }

    protected function createWebDriverInstance()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'chrome');
        $webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);

        return $webDriver;

    }
} 