<?php
namespace Controller;


class envconfig{
    function __construct()
    {
       
    if(!file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'.env')){
        throw new \Exception('Não foi localizado arquivo .env');
    }
    
    $lines = file($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'.env');
        foreach($lines as $line){
            putenv($line);
        }
    }
}