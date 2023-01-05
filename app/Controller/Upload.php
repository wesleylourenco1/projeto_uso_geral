<?php

namespace Controller;

class Upload extends Controller
{
    public function __contruct()
    {
    }
    protected function saveNameDb($dados){
       
       return (new \Model\DAO\sql)->inserir('img_pedidos', $dados);
      
    }
    public function uploadImgPedidos()
    {
        header('Content-Type: application/json');

        echo json_encode(
            [
                'header' => [
                    "responseText" => "Salvo com sucesso.",
                    "code" => 200,
                ],
                'body' => $this->saveImg()
            ]
        );
    }

    protected function saveImg()
    {
      

        $file = $_FILES['file'];

        if (!$this->verifyTypeIsImg($file['type'])) {
            return  $this->errorSaveImg($file);;
        } 

        $file['ext'] =  explode("/", $file['type']);
        $aleatorio = PATHIMGPEDIDOS .sha1(rand(0, 99999) . time()) .'.'. $file['ext'][1];
        
        $dados = [
            "urlfoto"=>$aleatorio,
            "idpedido"=>2
        ];

        return move_uploaded_file($file['tmp_name'], $aleatorio)&&$this->saveNameDb($dados) ?
            [
                "status" => "success",
                "name" => $aleatorio,

            ] :
            $this->errorSaveImg($file);
    }

    public function errorSaveImg($file)
    {
        $ret["status"] = "error";
        $ret["name"] = $file['name'];
        return $ret;
    }
    public function verifyTypeIsImg($type)
    {
        $formatosAceitos = ['gif', 'bmp', 'png', 'jpg', 'jpeg', "image/png"];
        return in_array($type, $formatosAceitos);
    }
}
