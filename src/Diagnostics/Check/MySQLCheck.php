<?php

namespace Diagnostics\Check;

use ZendDiagnostics\Check\CheckInterface;
use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Warning;
use Diagnostics\Db\Adapter;
use \Exception;

class MySQLCheck implements CheckInterface
{

    protected $config;
    protected $adapter;

    const SUCCESS = "ok";
    const FAILURE_HOST = "error";
    const FAILURE_DATABASE = "error";

    public function __construct(array $config = null )
    {
        $this->config = $config;
    }

    public function setAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function check()
    {
        try{
            $this->adapter->setConfig($this->config);

            if($this->adapter->Connect()){
                return new Success(self::SUCCESS);
            }


            $error = $this->adapter->getError();

            return new Failure($error["message"]);

        }catch(Exception $exc){
            return new Failure($exc->getMessage());
        }

    }

    public function getLabel()
    {
        return "Check Conexion MySQL";
    }

    public function setConfig(array $value)
    {
        $this->config = $value;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
