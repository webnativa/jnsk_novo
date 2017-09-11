<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Objeto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Produto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Pedido.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Cliente.class.php");

    // Inicializa a session
    session_start();
    session_name('gabinete-cliente');
    
    
    $codigo = $_GET['codigo'];
    $mensagem = $_GET['mensagem'];
    $numpedido = $_GET['pedido'];
    
    
    $pedido = Pedido::inicializaPedidoComId($numpedido);

    $titulo_pagina = "";
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/topo.php"); ?>

<div class="tarja_top_a_identificacao"></div>

<div class="tarja_top_b_identificacao">
	<!-- titulos -->
    <div class="padrao">
    <div class="tit_esquerdo ident">Pagamento</div>
    <div class="tit_direito ident"></div>
    <div class="lmp"></div>
     </div>
</div>

<!--  conteudo -->
<div class="conteudo_b">
<div class="padrao">

<!--  conteudo maior -->
<div class="conteudo_principal_maior">
    
<?php if ($codigo == 0){ ?>

    <div class="titulo_maior">Obrigado!</div>

    <div class="box_txt">
        O pagamento do seu pedido foi aprovado pela administradora do seu cartão. Em breve você receberá um e-mail confirmando seu pedido.
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

<?php } else{ ?>

    <br>
    <div class="titulo_maior">Ocorreu um erro durante seu pagamento!</div>

    <div class="box_txt">

        
        O erro ocorrido foi: <strong><?=utf8_encode($mensagem)?></strong>
        <br>
        <br>Caso queira prosseguir com o pagamento, acesse este link para que uma nova cobrança seja gerada:
        <br><a href="/pedido-confirmacao.php?pedido=<?=sha1($pedido->id_pedido)?>">Gerar nova cobraça.</a>
        <br>Ou entre em contato conosco para maiores informações.

    </div>

<?php } ?>
</div>
<!-- conteudo maior fim -->

</div>
</div>
<!--  conteudo fim-->

<?php include($_SERVER['DOCUMENT_ROOT']."/includes/rodape.php"); ?>