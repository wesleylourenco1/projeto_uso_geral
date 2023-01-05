<?php

namespace Controller;

class Cliente
{
    function __construct()
    {
    }
    public function test(){
        echo "teste";
    }
    public function salvaCliente()
    {
       if (!isset($_POST['token'])) throw new \Exception('Ausência de token', 403);
        \Services\auth::retornaValidadeTokenRequest($_POST['token']);
     


        //se o cliente existir exception, cliente existente
        // throw new \Exception('Cliente já está cadastrado!', 422);
        
        
        //se o cliente não existir verificar se todos os campos origatorios estao preenchidos
        $validaCampos = $this->dadosObrigatorios();
        if($validaCampos!=[]){
            \Services\response::response($validaCampos, 409, "Dados obrigatórios ausentes.");
            return;
        }
        
        //se todos os requisitos acima foram atendidos salva o cliente e retorna o id do cliente salvo,
           \Services\response::response($_POST, 200, "Cliente salvo com sucesso!!!.");
        
        //se ocorreu algum erro na hora de salvar retornar exception

    }
    public function verificaSeClienteExiste()
    {
    
    }
    protected function dadosObrigatorios(){
        $dadosObrigatorios = [
            
        ];
        $erro = [];
        foreach($dadosObrigatorios as $key=>$value){
            if(!isset($_POST[$key])||$_POST[$key]==""){
                array_push($erro, $value);
            }
        }
        return $erro;

    }
}
