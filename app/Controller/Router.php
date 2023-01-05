<?php

namespace Controller;

use Exception;

class Router
{

    private $routersGET =  [];
    private $routersPOST =  [];
    private $routersPUT =  [];
    private $routersDEL =  [];
    private $uri_parse = "";
    public function __construct()
    {
        $this->uri_parse = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    public function get($rota = false, $function = false)
    {
        $this->addListRouter("GET", $rota, $function);
    }
    public function addListRouter($list, $rota, $function)
    {
        $class =  $this->returnClassMethod($function);

        if (method_exists($class[0], $class[1]) || is_callable($function)) {
            if (!$rota || !is_string($rota)) {
                throw new Exception("Rota inválida ou inexistente. Verifique a rota $rota.", 401);
            } else {
                $rotaComposta = "routers$list";
                $this->$rotaComposta[$rota] = $function;
            }
        } else {
            throw new Exception("Função inválida ou Classe/Método inexistente. Verifique a rota $rota.", 401);
        }
    }
    public function returnClassMethod($function)
    {
        return is_string($function) ? explode("@", $function) : [null, null];
    }
    public function post($rota, $function)
    {
        $this->addListRouter("POST", $rota, $function);
    }
    public function put($rota, $function)
    {
        $this->addListRouter("PUT", $rota, $function);
    }
    public function delete($rota, $function)
    {
        $this->addListRouter("DEL", $rota, $function);
    }
    public function dispatch()
    {
        $rotaComposta = "routers" . $this->verifyMethod();
        if (array_key_exists($this->uri_parse, $this->$rotaComposta)) {
            $class = $this->returnClassMethod($this->$rotaComposta[$this->uri_parse]);
            if (is_callable($this->$rotaComposta[$this->uri_parse])) {
                call_user_func($this->$rotaComposta[$this->uri_parse]);
            } elseif (method_exists($class[0], $class[1])) {
                $classe = new $class[0];
                $metodo  = $class[1];
                print_r($classe->$metodo());
                return;
                //call_user_func(array($class[0], $class[1]));
            } else {
                throw new Exception("Função inválida ou Classe/Método inexistente. Verifique a rota.", 401);
            }
        } else {
            throw new Exception("Página não encontrada " . $this->uri_parse, 404);
        }
    }
    protected function verifyMethod()
    {
        return $_SERVER['REQUEST_METHOD'];

    }
}
