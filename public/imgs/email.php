<?php

    // Includes de arquivos de sistema
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Objeto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Carrinho.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Produto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Pedido.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/StatusPedido.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Cliente.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/GiftCard.class.php");


    $id_pedido = intval("2432");
    $pedido = Pedido::inicializaPedidoComId($id_pedido);
    
    
    $cliente = Cliente::inicializaClienteComId($pedido->cd_cliente);
    
    $pedido->enviaEmailConfirmacaoPedidoParaCliente($cliente);


?>