<?php

    // Includes de arquivos de sistema
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Objeto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Carrinho.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Produto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Pedido.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/GiftCard.class.php");

    // Include do arquivo de validacao de cliente
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Cliente.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/includes/valida_cliente_restrito.php");

    // Recebe o codigo do pedido codificado
    $codigo_seguro = limpaString($_GET['pedido']);

    // Inicializa o pedido
    $pedido = Pedido::inicializaPedidoComCodigoSeguro($codigo_seguro);

    // Inicializa o giftcard
    $giftcard = GiftCard::inicializaGiftCardComId($pedido->cd_giftcard);
    
    // Chama o metodo recuperaItens
    $pedido->recuperaItens();

    // Limpa o carrinho
    $carrinho = new Carrinho();

    $id_cliente = $_SESSION['id_cliente'];

        // Cria um array com os produtos do carrinho
    $produtos_carrinho = $carrinho->produtos;
    if(count($produtos_carrinho) == 0){
        $carrinho_vazio = true;
    }
    else{
        $carrinho_vazio = false;
    }

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/topo.php"); ?>
<script type="text/javascript">
$(document).ready(function (){

    $('#bt_presentear').click(function (){
        $('#presentear').show();
        $('#nao_presentear').hide();
    });


    $('#bt_cancelar_presentear').click(function (){
        $('#presentear').hide();
        $('#nao_presentear').show();
    });

    $('#form_presentear').submit(function (){
        
        nome = $('#presentear_nome').val();
        email = $('#presentear_email').val();
        email1 = $('#presentear_email_repetido').val();
        mensagem = $('#presentear_mensagem').val();

        if (email == "" || email1 == "" || nome == ""){
            alert("Todos campos devem ser preenchidos");
            return false;
        }

        if (email != email1){
            alert("Os e-mails informados devem coincidir.");
            return false;
        }
        
        return true;
    });


    <? if ($giftcard->nome) { ?>
        $('#presentear').show();
        $('#nao_presentear').hide();
    <? } ?>

});

    
</script>
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
    <div class="tit_direito ident"></div>
    <div class="lmp"></div>
     </div>
</div>

<!--  conteudo -->
<div class="conteudo_a">
<div class="padrao">

<!--  conteudo maior -->
<div class="conteudo_principal_maior">

Você pode entrar em contato com nossa equipe através do telefone 3225-2000 e agendar o dia e hora mais adequados para desfrutar do seu presente. 
Toda nossa equipe do NUWA Spa deseja proporcionar momentos especialmente agradáveis e renovadores aos nossos hóspedes. 
Momentos de cuidado, nutrição, saúde, equilíbrio e harmonia.

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_carrinho">

  <?php if (!$carrinho_vazio){
        ?>
        <tr>
            <th width="45%" height="50" class="tdl">Tratamentos e terapias</th>
            <th width="16%">Quantidade</th>
            <th width="18%">Valores unit&aacute;rios</th>
            <th width="21%">Total (pre&ccedil;o e dura&ccedil;&atilde;o)</th>
          </tr>

          <?
              $total_carrinho = 0;
              foreach ($produtos_carrinho as $item_produto){
                    $produto = Produto::inicializaProdutoComId($item_produto['id_produto']);
                    $quantidade_produto = $item_produto['quantidade'];
                    $total_produto = intval($quantidade_produto) * floatval($produto->preco);

                    // Calcula o valor total da compra no carrinho
                    $total_carrinho += floatval($total_produto);
              ?>
              <tr>
                <td class="tda"><?=$produto->nome?></td>
                <td class="tdb"><div class="quantidade"><?=$quantidade_produto?></div></td>
                <?
                    $duracao = intval($produto->duracao);
                    if ($duracao > 60){
                        $duracao = ((int)($duracao/60))."h ".($duracao%60)."min";
                    } else {
                        $duracao = "$duracao min";
                    }
                ?>
                <td class="tdd">R$ <?=formataMoney($produto->preco)?> - <?=$duracao?></td>
                <?
                    $duracao = intval($produto->duracao)*$quantidade_produto;
                    if ($duracao > 60){
                        $duracao = ((int)($duracao/60))."h ".($duracao%60)."min";
                    } else {
                        $duracao = "$duracao min";
                    }
                ?>
                <td class="tdd">R$ <?=formataMoney($total_produto)?> - <?=$duracao?></td>
              </tr>
              <tr>
                <td colspan="4" height="6"></td>
                </tr>
              
          <? } ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="tdf">TOTAL</td>
        <td class="tdg"><span class="rs">R$</span> <?=formataMoney($total_carrinho)?></td>
      </tr>
      <tr>
        <td colspan="4"><div class="separador"></div></td>
      </tr>
  <? } else { ?>

        <tr>
            <th width="45%" height="50" class="tdl">Tratamentos e terapias</th>
            <th width="16%">Quantidade</th>
            <th width="18%">Valores unit&aacute;rios</th>
            <th width="21%">Total (pre&ccedil;o e dura&ccedil;&atilde;o)</th>
        </tr>
          <?  $pedido->recuperaItens();
              $preco_total = 0;
              $duracao_total = 0;
              foreach($pedido->itens_pedido as $item) {
                  $preco_total += $item->preco*$item->quantidade;
                  $duracao_total += $item->duracao*$item->quantidade;
                ?>
             <tr>
            <td class="tda"><?=$item->nome?></td>
            <td class="tdb"><div class="quantidade"><?=$item->quantidade?></div></td>
            <?
                $duracao = intval($item->duracao);
                if ($duracao > 60){
                    $duracao = ((int)($duracao/60))."h ".($duracao%60)."min";
                } else {
                    $duracao = "$duracao min";
                }
            ?>
            <td class="tdd">R$ <?=formataMoney($item->preco)?> - <?=$duracao?></td>
            <?
                $duracao = intval($item->duracao)*$item->quantidade;
                if ($duracao > 60){
                    $duracao = ((int)($duracao/60))."h ".($duracao%60)."min";
                } else {
                    $duracao = "$duracao min";
                }
            ?>
            <td class="tdd">R$ <?=formataMoney($preco_total)?> - <?=$duracao?></td>
          </tr>
          <tr>
            <td colspan="4" height="6"></td>
            </tr>
          <tr>
          <? } ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="tdf">TOTAL</td>
            <td class="tdg"><span class="rs">R$</span> <?=formataMoney($preco_total)?></td>
        </tr>

<? } ?>

  <tr id="nao_presentear">
    <td colspan="4" class="tdf" ><a href="#" id="bt_presentear"><img src="/img/bt_quero_presentear.gif" width="217" height="38"></a>
        <a href="/sys/loja/Control/delete/del_gift.php?pedido=<?=$codigo_seguro?>"><img src="/img/bt_finalizar_pagamento.gif" width="217" height="38"></a>
    </td>
  </tr>
 </table>

<div id="presentear" style="display:none;">
    <div class="titulo">Presentear</div>

    <p>Você pode entrar em contato com nossa equipe através do telefone 3225-2000 e agendar o dia e hora mais adequados para desfrutar do seu presente. Toda nossa equipe do NUWA Spa deseja proporcionar momentos especialmente agradáveis e renovadores aos nossos hóspedes. </p>

    <form id="form_presentear" action="/sys/loja/Control/insert/ins_gift.php" method="POST">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="div_ipt_maiorb"><span class="lft">Nome</span> <input tabindex="1" type="text" name="presentear_nome" id="presentear_nome" class="ipt_maiorb" value="<?=$giftcard->nome?>"></div></td>
        <td rowspan="5" align="right" valign="top">
        <div class="ipt_area_menor"><textarea tabindex="4" type="text" name="presentear_mensagem" id="presentear_mensagem" class="ipt_area_m" onfocus="clearText(this,'Que tal escrever uma mensagem?')" onblur="showText(this,'Que tal escrever uma mensagem?');"><?=($giftcard->mensagem)?$giftcard->mensagem:"Que tal escrever uma mensagem?"?></textarea></div>
        </td>
      </tr>
      <tr>
        <td><div class="div_ipt_maiorb"><span class="lft">E-mail</span> <input tabindex="2" type="text" name="presentear_email" id="presentear_email" class="ipt_maiorb" value="<?=$giftcard->email?>"></div></td>
      </tr>
      <tr>
        <td><div class="div_ipt_maiorb"><span class="lft">Repetir e-mail</span> <input tabindex="3" type="text" name="presentear_email_repetido" id="presentear_email_repetido" class="ipt_maiorb" value="<?=$giftcard->email?>"></div></td>
      </tr>
      <tr>
          <td>&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="2" class="tdh"><img src="/img/gball.gif" width="21" height="14">Campos obrigatórios</td>
      </tr>
      <tr>
          <input name="pedido" type="hidden" value="<?=$codigo_seguro?>">
        <td class="tdf"><a href="#" id="bt_cancelar_presentear"><img src="/img/bt_cancelar_presentear.gif" width="221" height="38"></a> 
            <input type="image" src="/img/bt_finalizar_pagamento.gif">
        </td>
      </tr>
    </table>
    </form>

</div>
</div>
<!-- conteudo maior fim -->

</div>
</div>
<!--  conteudo fim-->

<?php include($_SERVER['DOCUMENT_ROOT']."/includes/rodape.php"); ?>