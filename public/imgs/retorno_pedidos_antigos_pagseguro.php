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

    // Aqui vai seu Token
    define('TOKEN','97A7C1E37E82421D8ADC69473ED86C82');

    // Incluindo o arquivo da biblioteca
    include($_SERVER['DOCUMENT_ROOT']."/sys/loja/Pgs/retorno.php");
 
    // Função que captura os dados do retorno
    function retorno_automatico ( $VendedorEmail, $TransacaoID,
      $Referencia, $TipoFrete, $ValorFrete, $Anotacao, $DataTransacao,
      $TipoPagamento, $StatusTransacao, $CliNome, $CliEmail,
      $CliEndereco, $CliNumero, $CliComplemento, $CliBairro, $CliCidade,
      $CliEstado, $CliCEP, $CliTelefone, $produtos, $NumItens) {

      // AQUI VOCÊ TEM OS DADOS RECEBIDOS DO PAGSEGURO, JÁ VERIFICADOS.
      // CONFIRA A LISTA DE PRODUTOS E O VALOR COM O QUE VOCÊ TEM NO
      // BANCO DE DADOS E, SE ESTIVER TUDO CERTO, ATUALIZE O STATUS
      // DO PEDIDO.

      $id_pedido = intval($Referencia);
      $pedido = Pedido::inicializaPedidoComId($id_pedido);
      $giftcard = GiftCard::inicializaGiftCardComId($pedido->cd_giftcard);

      //Verifica se a data de expiração já passou
      $data_atual_timestamp=time(); //current timestamp
      $data_expiracao = $data_atual_timestamp+7776000+7776000; // Will add 180 days to the $timestamp
      $data_exp_formatada = date("d/m/Y", $data_expiracao);

      switch ($StatusTransacao) {
          case "Aguardando Pagto":
              //Verificar se a transacao sempre passa por este status
              $pedido->insereIdTransacaoPagSeguro($TransacaoID);
              StatusPedido::atualizaStatusPedido(12, $id_pedido);

              break;
          case "Aprovado" :
              StatusPedido::atualizaStatusPedido(13, $id_pedido);
              $giftcard->atualizaStatusGiftCard(2);

              $cliente = Cliente::inicializaClienteComId($pedido->cd_cliente);

              $pedido->enviaEmailConfirmacaoPedidoParaCliente($cliente);

              $giftcard = GiftCard::inicializaGiftCardComId($pedido->cd_giftcard);

              if ($giftcard->email != ""){
                $cliente = Cliente::inicializaClienteComId($pedido->cd_cliente);

                $data_atual_timestamp = time(); //current timestamp
                $data_expiracao = $data_atual_timestamp+7776000+7776000; // Will add 180 days to the $timestamp
                $data_exp_formatada = date("d/m/Y", $data_expiracao);

                $giftcard->enviaEmailGiftCardParaCliente ($cliente, $data_exp_formatada);
              }
              

              break;
          case "Completo" :
              StatusPedido::atualizaStatusPedido(14, $id_pedido);

              break;
          case "Em Análise" :
              StatusPedido::atualizaStatusPedido(15, $id_pedido);

              break;
          case "Cancelado" :
              StatusPedido::atualizaStatusPedido(16, $id_pedido);
              $giftcard->atualizaStatusGiftCard(4);

              break;
      }
    }
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/topo.php"); ?>
<div class="tarja_top_a_identificacao">
<!-- area loja login -->
<div class="padrao login">

<!--  box login -->
<div class="box_login">
    <!-- não logado -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/includes/box_login.php"); ?>
    <!-- não logado fim -->

    <!-- box itens -->
    <?php include($_SERVER['DOCUMENT_ROOT']."/includes/box_carrinho.php"); ?>
    <!-- box itens fim -->
</div>
<!-- box login fim -->

</div>
<!-- area loja login fim -->
</div>

<div class="tarja_top_b_identificacao">
	<!-- titulos -->
    <div class="padrao">
    <div class="tit_esquerdo ident">Confirmação de pedido</div>
    <div class="lmp"></div>
     </div>
</div>


<!--  conteudo -->
<div class="conteudo_b">
<div class="padrao">

<!--  conteudo maior -->
<div class="conteudo_principal_maior">
Seu pagamento está em fase de processamento pelo PagSeguro.<br />
Dentro de instantes você receberá um e-mail do PagSeguro com a confirmação de pagamento e um e-mail do NUWA Spa com os dados de fechamento do pedido.<br />
Após a confirmação o gift card será enviado para você ou para a pessoa que você escolheu presentear.<br/><br/>
Obrigado por escolher nossa loja online.
</div>
<!-- conteudo maior fim -->

</div>
</div>
<!--  conteudo fim-->
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/rodape.php"); ?>