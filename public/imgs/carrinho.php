<?php
    // Includes de arquivos de sistema
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Objeto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Carrinho.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Produto.class.php");

    // Include do arquivo de validacao de cliente
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Cliente.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/includes/valida_cliente.php");

    // Recebe a acao e o codigo do produto
    $acao = limpaString($_GET['acao']);
    $id_produto = intval($_GET['terapia']);

    // Inicializa o carrinho
    $carrinho = new Carrinho();

    // Em virtude da implementacao do servico de cache da Locaweb (Varnish) o Internet Explorer passou
    // a ter problemas com a manipulacao de cabecalhos http, o que acabou gerando problema com o cookie.
    // O IE passa a visualizar o cookie apenas apos um reload  total na pagina. Por isso a implementacao
    // do carrinho vai diferenciar as acoes para browsers diferentes.

    // Define o navegador do usuario
    $navegador_usuario = $_SERVER['HTTP_USER_AGENT'];
    if(strstr($navegador_usuario, "MSIE")){
        $internet_explorer = true;
        $reload_pagina = false;
    }
    else{
        $internet_explorer = false;
    }
    unset($navegador_usuario);

    // Define as acoes para o carrinho
    if(isset($acao)){
        if($internet_explorer){ // Acoes para usuarios de Internet Explorer
            switch ($acao){
                case "adicionar":
                    $carrinho->adicionaProduto($id_produto);
                    $reload_pagina = true;
                    break;
                case "atualizar":
                    $quantidade_nova = intval($_GET['quantidade']);
                    $produto_atualizar = $carrinho->consultaPosicaoQuantidadeProduto($id_produto);
                    if($quantidade_nova > 0){
                        $carrinho->atualizaQuantidadeProduto($produto_atualizar, $quantidade_nova);
                    }
                    else{
                        $carrinho->removeProduto($produto_atualizar);
                    }
                    $reload_pagina = true;
                    break;
                case "remover":
                    $produto_remover = $carrinho->consultaPosicaoQuantidadeProduto($id_produto);
                    $carrinho->removeProduto($produto_remover);
                    $reload_pagina = true;
                    break;
                case "limpar":
                    $carrinho->limpaCarrinho();
                    $reload_pagina = true;
                    break;
            }
        }
        else{
            switch ($acao){ // Acoes para usuarios de todos os demais browsers
                case "adicionar":
                    $carrinho->adicionaProduto($id_produto);
                    header('Location: /carrinho.php');
                    die();
                    break;
                case "atualizar":
                    $quantidade_nova = intval($_GET['quantidade']);
                    $produto_atualizar = $carrinho->consultaPosicaoQuantidadeProduto($id_produto);
                    if($quantidade_nova > 0){
                        $carrinho->atualizaQuantidadeProduto($produto_atualizar, $quantidade_nova);
                    }
                    else{
                        $carrinho->removeProduto($produto_atualizar);
                    }
                    header('Location: /carrinho.php');
                    die();
                    break;
                case "remover":
                    $produto_remover = $carrinho->consultaPosicaoQuantidadeProduto($id_produto);
                    $carrinho->removeProduto($produto_remover);
                    header('Location: /carrinho.php');
                    die();
                    break;
                case "limpar":
                    $carrinho->limpaCarrinho();
                    header('Location: /carrinho.php');
                    die();
                    break;
            }
        }
    }

    // Cria um array com os produtos do carrinho
    $produtos_carrinho = $carrinho->produtos;
    if(count($produtos_carrinho) == 0){
        $carrinho_vazio = true;
    }
    else{
        $carrinho_vazio = false;
    }

    
?>
<?php
if ($reload_pagina){ ?>
<script type="text/javascript">
window.location = "/carrinho.php";
</script>
<? } ?>    
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/topo.php"); ?>
<script type="text/javascript">
function atualizaQuantidadeProduto(produto, qtde_atual, obj){
    var qtde_nova = obj.value;
    if(qtde_atual != qtde_nova){
        var pagina = '/carrinho.php?acao=atualizar&terapia='+produto+'&quantidade='+qtde_nova;
        window.location = pagina;
    }
}
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
    <div class="tit_esquerdo ident">Carrinho de compras</div>
    <div class="tit_direito ident"><a href="/loja/"><img src="/img/bt_continuar_compra.gif" width="217" height="33" class="rgt"></a></div>
    <div class="lmp"></div>
     </div>
</div>


<!--  conteudo -->
<div class="conteudo_b">
<div class="padrao">

<!--  conteudo maior -->
<div class="conteudo_principal_maior">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_carrinho">

  <?php if (!$carrinho_vazio){
        ?>
          <tr>
            <th width="34%" height="35" class="tdl">Tratamentos e terapias</th>
            <th width="14%">Quantidade</th>
            <th width="12%">Remover</th>
            <th width="18%">Valores unit&aacute;rios</th>
            <th width="22%">Total (pre&ccedil;o e dura&ccedil;&atilde;o)</th>
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
                <td class="tdb"><input class="quantidade" id="quantidade" type="text" onchange="atualizaQuantidadeProduto(<?=$produto->id_produto?>, <?=$quantidade_produto?> , this);" value="<?=$quantidade_produto?>" /></td>
                <td class="tdc"><a href="/carrinho.php?acao=remover&terapia=<?= $produto->id_produto; ?>"><img src="img/bt_remover.gif" width="39" height="29"></a></td>
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
                <td colspan="5" height="6"></td>
              </tr>
         <?php }

         ?>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="tdf">TOTAL</td>
            <td class="tdg"><span class="rs">R$</span> <?=formataMoney($total_carrinho)?></td>
          </tr>
          <tr>
            <td colspan="5"><div class="separador"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" class="tdf"><a href="/sys/loja/Control/insert/ins_pedido.php"><img src="/img/bt_fechar_pedido.gif" width="217" height="33"></a></td>
           </tr>
        </table>

         <?

        } else {?>

      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="5" height="5">Seu carrinho está vazio. <br>Que tal navegar em nossa <span style="text-decoration: underline"><a href="/loja/">loja virtual</a></span> e conhecer mais sobre nossas terapias?</td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      </table>
  <? } ?>

</div>
<!-- conteudo maior fim -->

</div>
</div>
<!--  conteudo fim-->
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/rodape.php"); ?>