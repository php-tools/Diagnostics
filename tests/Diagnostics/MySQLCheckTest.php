<?php

namespace Diagnostics\Tests;

use PHPUnit_Framework_TestCase;
use Diagnostics\Check\MySQLCheck;
use \Mockery as m;

class MySQLCheckTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider configProvider
     */
    public function testCheck($config, $response)
    {
        $checkMysql = new MySQlCheck($config);
        $checkMysql->setAdapter($this->getMockAdapterMysql($response));
        $this->assertInstanceOf(
                    "ZendDiagnostics\Result\Success",
                    $checkMysql->check());
    }

    /**
     * @dataProvider configFailureProvider
     */
    public function testFailure($config, $response)
    {
        $checkMysql = new MySQlCheck($config);
        $checkMysql->setAdapter($this->getMockAdapterMysql($response));
        $this->assertInstanceOf(
            "ZendDiagnostics\Result\Failure",
            $checkMysql->check());
    }

    public function configProvider()
    {
        return array(
            array(
                array(
                    "hostname" => "127.0.0.1",
                    "username" => "root",
                    "password" => "root",
                    "database" => "db",
                ),
                array(
                    "status" => 200,
                    "message" => MySQLCheck::SUCCESS
                )
            ),
            array(
                array(
                    "hostname" => "127.0.0.1",
                    "username" => "root",
                    "password" => "root",
                    "database" => "db",
                    "port" => "3307"
                ),
                array(
                    "status" => 200,
                    "message" => MySQLCheck::SUCCESS
                )
            ),
        );
    }

    public function configFailureProvider()
    {
        return array(
            array(
                array(
                    "hostname" => "127.0.0.1",
                    "username" => "root",
                    "password" => "root",
                    "database" => "db",
                ),
                array(
                    "status" => 400,
                    "message" => MySQLCheck::FAILURE_HOST
                )
            ),
            array(
                array(
                    "hostname" => "127.0.0.1",
                    "username" => "root",
                    "password" => "root",
                    "database" => "db",
                    "port" => "3307"
                ),
                array(
                    "status" => 400,
                    "message" => MySQLCheck::FAILURE_DATABASE
                )
            ),
        );
    }

    public function getMockAdapterMysql($response)
    {
        $status = True;
        $adapter = m::mock('\Diagnostics\Db\Adapter');

        if($response["status"] == 400){
            $status = False;
        }

        $adapter->shouldReceive("setConfig")->andReturn(null);
        $adapter->shouldReceive("Connect")->andReturn($status);
        $adapter->shouldReceive("getError")->andReturn($response);
        return $adapter;
    }

}
