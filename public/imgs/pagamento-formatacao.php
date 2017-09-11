<?php
    // Includes de arquivos de sistema
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Objeto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Carrinho.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Produto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Pedido.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/GiftCard.class.php");

    // Include do arquivo de validacao de cliente
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Cliente.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/includes/valida_cliente_restrito.php");
    
    
    // Recebe o codigo do pedido codificado
    $codigo_seguro = limpaString($_POST['codigo_seguro']);
    $pedido = Pedido::inicializaPedidoComCodigoSeguro($codigo_seguro);
    $pedido->insereDadosPagamento($_POST['BANDEIRA'],intval($_POST['PARCELAS']));
    
    if($_POST['PARCELAS'] != '00')
    {
        $transacao = '08';
    }else
    {
        $transacao = '04';
    }
    
    
    // Confere se o cliente já não efetuou o pagamento
    if ($pedido->cd_status_pedido == '6') //Capturado
    die("O pagamento já foi efetuado.");
    
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/topo.php"); ?>
<html>
<head>
<title> NUWASpa - Redirecionamento para REDE </title>
<script type="text/javascript">
    
    function send()
{document.voteVote.submit()};
    
</script>

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
    <div class="titulo_maior"></div>

    <div class="box_txt">
        Você será redirecionado para o site da REDE, para continuar sua compra de uma forma segura e eficiente!
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
    <!--formulario para enviar os dados para a rede-->
    <form name="voteVote" id="voteVote" action="https://ecommerce.userede.com.br/pos_virtual/form_card.asp" method="post">
    <input type="hidden" name="BANDEIRA" value="<?=$_POST['BANDEIRA']?>" />
    <input type="hidden" name="PARCELAS" value="<?=$_POST['PARCELAS']?>" />
    <input type="hidden" name="NUMPEDIDO" value="<?=$_POST['NUMPEDIDO']?>" />
    <input type="hidden" name="TOTAL" value="<?=$_POST['TOTAL']?>" />
    <input type="hidden" name="TRANSACAO" value="<?=$transacao?>" /> 
    <input type="hidden" name="FILIACAO" value="<?=$_POST['FILIACAO']?>" />
    <input type="hidden" name="DISTRIBUIDOR" value="<?=$_POST['DISTRIBUIDOR']?>" />
    <input type="hidden" name="LANGUAGE" value="<?=$_POST['LANGUAGE']?>" />
    <input type="hidden" name="CODVER" value="<?=$_POST['CODVER']?>" />
    <input type="hidden" name="URLBACK" value="<?=$_POST['URLBACK']?>" />
    <input type="hidden" name="URLCIMA" value="<?=$_POST['URLCIMA']?>" />

    <input type="hidden" name="note5" value="" /> 

    </form>

    <body onload="send()">
    </body>

    <!--/////////////////////////////////////////////////-->


</div>
<!-- conteudo maior fim -->

</div>
</div>
<!--  conteudo fim-->

<?php include($_SERVER['DOCUMENT_ROOT']."/includes/rodape.php"); ?>


</head>
</html>