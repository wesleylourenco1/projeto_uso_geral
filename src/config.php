<?php
session_start();

/**
 * Autoload Composer
 */
require __DIR__ . "../../vendor/autoload.php";



/**
 * Define as rotas armazenadas em arrays, 
 * indice  0 é a rota, indice 1 é a classe@método,
 * ou armazene a função direto no índice 1
 */
$rotasget = [
    ['/', "\Controller\Controller@view"],
    // ['/agenda', "\Controller\Agenda@view"],
    // ['/cliente', "\Controller\Cliente@view"],
    // ['/pedido', "\Controller\Pedido@view"],
    // ['/usuario', "\Controller\Usuario@view"],
    // ['/pedidosperiodo', "\Controller\Agenda@viewRelatorioByPeriodo"],
    // ['/login', "\Controller\Login@index"],
    // ['/logout',"\Controller\Login@desLogin"]
];

$rotaspost = [
//     ['/searchpedidosid', "\Controller\Pedido@searchPedidosbyId"],
//     ['/searchpedidos', "\Controller\Pedido@searchPedidos"],
//     ['/searchpedidosbyyear', "\Controller\Agenda@getEvetsByYear"],
//     ['/searchpedidosbyperiodo', "\Controller\Agenda@getEvetsByTimeCourse"],
//     ['/updatePedido', "\Controller\Pedido@updatePedido"],

//     ['/newpedido', "\Controller\Pedido@create"],
//     ['/delpedido', "\Controller\Pedido@delPedidos"],
//     ['/searchcliente', "\Controller\Cliente@listLikeByName"],
//     ['/newcliente', "\Controller\Cliente@create"],
//     ['/updatecliente', "\Controller\Cliente@updateCliente"],
//     ['/retornaUser','\Controller\Usuario@getUser'],
//     ['/updateUser','\Controller\Usuario@updateUser']
];

