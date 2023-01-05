<?php

namespace Services;

class response
{
    public static function response($data, int $code, $responseText){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Max-Age: 86400");
        header('Content-Type: application/json');
        header($responseText, true, $code);
        header("responseText:",$responseText);
        echo json_encode([
            "data"=>$data,
            "responseText"=>$responseText,
            "code"=>$code,
        ], true);
    }
}
