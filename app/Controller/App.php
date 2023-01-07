<?php

namespace Controller;

use \Controller\Router;

class App extends Controller
{
    protected $router;
    function __construct($rotas = [[], []])
    {
        try {
            new envconfig();
            $this->index($rotas);
        } catch (\Exception $e) {
            \Services\response::response("Data", $e->getCode(), $e->getMessage());
        }
    }

    
    public function index($rotas)
    {

        $this->router = new Router();
        $this->addRoutersGet($rotas[0]);
        $this->addRoutersPost($rotas[1]);
        $this->router->dispatch();
    }

    protected function addRoutersGet($rotas)
    {

        foreach ($rotas as $rota) {
            $this->router->get($rota[0], $rota[1]);
        }
    }
    protected function addRoutersPost($rotas)
    {
        foreach ($rotas as $rota) {
            $this->router->post($rota[0], $rota[1]);
        }
    }
}
