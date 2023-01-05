<?php

namespace Services;

use DateTime;
use Exception;

class auth
{

    protected function verificaUser($user, $passwd)
    {
        $result = (new \Model\DAO\sql)->listOneToParam("usuarios", "usuario", $user, "senha", $passwd);
        
        return $result > 0;
    }

    protected function consultaValidadeToken($token = false)
    {
        if(isset($_POST['token']))$token = $_POST['token'];

        if ($token === false) {
            return false;
        }
        $atualdata = (new DateTime('now'))->getTimestamp();
        $queryToken = (new \Model\DAO\sql)->listOne('token', 'token', $token);
        // var_dump("token", $_POST);
        return $queryToken && $queryToken['expire_at'] > $atualdata;
    }
    protected function geraNovoTken($user)
    {
        $creat_at = (new DateTime('now'))->getTimestamp();
        $expire_at = (new DateTime('now'))->getTimestamp() + 7200;
        $header = base64_encode(json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]));
        $payload = base64_encode(json_encode([
            'exp' => $creat_at,
            'email' => $user,
            'creat_at' => $expire_at,
        ]));
        $key = CHAVETOKENJWT;
        $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
        $sign = base64_encode($sign);

        $token =  $header . '.' . $payload . "." . $sign;


        $salvatoken = (new \Model\DAO\sql)->inserir("token", ['creat_at' => $creat_at, 'expire_at' => $expire_at, 'token' => $token]);

        if ($salvatoken) {
            return [true, ['creat_at' => $creat_at, 'expire_at' => $expire_at, 'token' => $token]];
        } else {
            throw new \Exception("Erro ao salvar Token", 500);
        }
    }

    protected function validaEntrada($token = false, $user = false, $passwd = false)
    {

        if ($this->consultaValidadeToken($token)) {

            return true;
        }
        if ($this->verificaUser($user, $passwd)) {

            $token = $this->geraNovoTken($user);
            if (is_array($token) && $token[0] === true) {
                return $token[1];
            } else {
                throw new \Exception('Erro ao receber token', 500);
            }
        }

        return false;
    }
    public function post()
    {
        $token = isset($_POST['token']) ? $_POST['token'] : false;
        $user = isset($_POST['user']) ? $_POST['user'] : false;
        $passwd = isset($_POST['passwd']) ? $_POST['passwd'] : false;
        
        $valida = $this->validaEntrada($token, $user, $passwd);


        if ($valida != false) {
            if(is_array($valida)){
                \Services\response::response($valida, 200, "Token gerado com sucesso.");
            }else{
                \Services\response::response([], 200, "Token dentro do período de Validade");
            }
            
        } else {
            throw new \Exception("Token / Usuário / Senha inválido", 403);
        }
    }
    public function get()
    {
        $token = isset($_GET['token']) ? $_GET['token'] : false;
        $user = isset($_GET['user']) ? $_GET['user'] : false;
        $passwd = isset($_GET['passwd']) ? $_GET['passwd'] : false;

        $valida = $this->validaEntrada($token, $user, $passwd);

      
        if ($valida === true) {
            return true;
        } else {
            throw new \Exception("Token / Usuário / Senha inválido", 403);
        }
    }
    public static function retornaValidadeTokenRequest($token = false)
    {

        
        if(self::consultaValidadeToken($token)){
            return true;
            
        }else{
            throw new \Exception("Token Inválido, o usuário deverá realizar novo login", 403);
        }
    }

}
