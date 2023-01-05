<?php

namespace Controller;

class Users
{
    public function getAllUsers()
    {
        $valida = (new \Services\auth)->post();
        if (!$valida) return;

        $tokens = (new \Model\DAO\sql)->listAll('token');
        \Services\response::response($tokens, 200, "Resposta com sucesso");
    }
}
