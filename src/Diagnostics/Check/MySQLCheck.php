<?php

namespace Diagnostics\Check;

use ZendDiagnostics\Check\CheckInterface;
use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Warning;
use \Exception;

class CheckDbAdapterMySQL implements CheckInterface
{

    protected $config;

    public function check()
    {
        try{

            if(!$this->config){
                throw new Exception("No existe el Service config");
            }

            $link = mysql_connect($this->config['hostname'],
                                    $this->config['username'],
                                    $this->config['password']
                                );

            if(!$link){
                throw new Exception("No hay conexion a la BD");
            }

            $database = mysql_select_db($this->config["database"], $link);

            if(!$database){
                throw new Exception("No Error al conectar a la BD");
            }

            return new Success("Success");

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
