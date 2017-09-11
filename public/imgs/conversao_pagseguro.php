<?php

    // Includes de arquivos de sistema
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");

    
    $banco = Database::singleton();

    $sql = "select * from tb_pedido";
    $rs = $banco->databaseQuery($sql);

    while($obj = $banco->databaseFetchObject($rs)) {

        if ($obj->cd_status_pedido == "2"){
            $novo_status = "12";
        } else if ($obj->cd_status_pedido == "3"){
            $novo_status = "13";
        } else if ($obj->cd_status_pedido == "4"){
            $novo_status = "14";
        } else if ($obj->cd_status_pedido == "5"){
            $novo_status = "15";
        } else if ($obj->cd_status_pedido == "6"){
            $novo_status = "16";
        } else {
            $novo_status = false;
        }
        
        
        if ($novo_status){
            $sql = "update tb_pedido set cd_status_pedido = $novo_status where id_pedido = $obj->id_pedido";
            $rs_1 = $banco->databaseQuery($sql);
            if ($rs_1) echo "Pedido $obj->id_pedido teve seu status alterado<br>";
            else echo "Erro alterando status do pedido $obj->id_pedido<br>";
        }
        
    }
    
    unset($rs);
    
        
    for ($i = 2; $i <= 6; $i++){
        $novo_status = $i+10;
        $status_velho = $i;
        $sql = "update tb_historico_pedido set cd_status_pedido = $novo_status where cd_status_pedido = $status_velho";
        $rs = $banco->databaseQuery($sql);
        if ($rs) echo "Historicos com status $status_velho foram alterados para $novo_status<br>";
        else echo "Erro alterando historico de $status_velho para $novo_status<br>";
    }
    
    
?>