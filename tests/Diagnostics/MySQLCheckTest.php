<?php

namespace Diagnostics\Tests;

use PHPUnit_Framework_TestCase;
use Diagnostics\Check\MySQLCheck;

class MySQLCheckTest extends PHPUnit_Framework_TestCase
{

    public function testConfig()
    {

    }

    public function configProvider()
    {
        return array(
            array(
                "hostname" => "127.0.0.1"
            ),
            array(
                "hostname" => "127.0.0.1",
                "username" => "root",
                "password" => "root",
                "database" => "db",
            ),
            array(
                "hostname" => "127.0.0.1",
                "username" => "root",
                "password" => "root",
                "database" => "db",
                "port" => "3307"
            ),
        );
    }

    public function getMockAdapterMysql()
    {
    }

}
