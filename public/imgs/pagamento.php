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
    
    
    $carrinho = new Carrinho;
    $carrinho->limpaCarrinho();

    // Recebe o codigo do pedido codificado
    $codigo_seguro = limpaString($_GET['pedido']);

    // Inicializa o pedido
    $pedido = Pedido::inicializaPedidoComCodigoSeguro($codigo_seguro);

    // Chama o metodo recuperaItens
    $valor_total = $pedido->calculaValorTotal();

    $max_parcelas = 3;
    $parcela_minima = 150.0;
    
    
    function _RedeCard_CodVer($n_filiacao,$total,$ip) {
        $data = getdate();
        $segundosAgora = $data['seconds'];
        /*
        esta é uma tabelinha de codificação da própria redecard, onde eles
        embaralham os segundos.
        NÃO ALTERAR!
        */
        $_secCodificado = array(11,17,21,31,56,34,42,3,18,13,
        12,18,22,32,57,35,43,4,19,14,9,20,23,33,58,36,44,5,24,
        15,62,25,34,59,37,45,6,25,16,27,63,26,35,60,38,46,7,26,
        17,28,14,36,2,39,47,8,29,22,55,33);

        $segundosAgora = $_secCodificado[ $segundosAgora ];

        $pad = '';
        if ($segundosAgora < 10) {
                $pad = "0";
        } else {
                $pad = "";
        }
        $tamIP = strlen($ip);
        $total = intval($total);
        $numfil = intval($n_filiacao);
        $i5 = $total + $segundosAgora;
        $i6 = $segundosAgora + $tamIP;
        $i7 = $segundosAgora * $numfil;
        $i8 = strlen($i7);
        return "$i7$i5$i6-$i8$pad$segundosAgora";
    }

    
    $total = str_replace(",", ".",formataMoney($valor_total));
    $codver = _RedeCard_CodVer('64466167', $total, $_SERVER['REMOTE_ADDR']);
    
    $titulo_pagina = "Nuwa Spa | Pagamento";
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/topo.php"); ?>
<script type="text/javascript">

    function submete(){
        if ($("input[name='BANDEIRA']:checked").val()){
            $('#form_pagamento').submit();
        }else
            alert("Por favor, selecione uma forma de pagamento.");
    }
    
    
    
    $(document).ready(function (){
        
        $("input[name='BANDEIRA']").change(function (){
            if ($("input[name='BANDEIRA']:checked").val() == "discover"){
                $('#parcelas').hide();
                $('#parcelas_1').show();
                $('#parcelas').attr('name','parcelas_not');
                $('#parcelas_1').attr('name','PARCELAS');
            } else {
                $('#parcelas').show();
                $('#parcelas_1').hide();
                $('#parcelas').attr('name','PARCELAS');
                $('#parcelas_1').attr('name','parcelas_not');
            }
        });
        
    });
      
     
</script>
<div class="tarja_top_a_identificacao"></div>

<div class="tarja_top_b_identificacao">
	<!-- titulos -->
    <div class="padrao">
    <div class="tit_esquerdo form_pagamento">Escolha a forma de pagamento</div>
    <div class="tit_direito ident"></div>
    <div class="lmp"></div>
     </div>
</div>

<!--  conteudo -->
<div class="conteudo_b">
<div class="padrao">

<!--  conteudo maior -->
<div class="conteudo_principal_maior">
    
    <p>Você pode entrar em contato com nossa equipe através do telefone 3225-2000 e agendar o dia e hora mais adequados para desfrutar do seu presente. Toda nossa equipe do NUWA Spa deseja proporcionar momentos especialmente agradáveis e renovadores aos nossos hóspedes. Momentos de cuidado, nutrição, saúde, equilíbrio e harmonia</p>
    <p><span style="color: #BCD44C">Valor total do pedido: R$ <?=formataMoney($valor_total)?></span></p>

    <div class="separador"></div>
    <form id="form_pagamento" action='/pagamento-formatacao.php' method="post" >
    <ul class="cartoes">
    <li class="card_visa" id="visa_label" ><input name="BANDEIRA" id="visa" type="radio" value="VISA"></li>
    <li class="card_master" id="mastercard_label" ><input name="BANDEIRA" id="mastercard" type="radio" value="MASTERCARD"></li>
    <li class="card_diners" id="diners_label" ><input name="BANDEIRA" id="diners" type="radio" value="DINERS"></li>
    <li class="card_hiper" id="hiper_label" ><input name="BANDEIRA" id="discover" type="radio" value="HIPER"></li>
    <li class="card_hipercard" id="hipercard_label" ><input name="BANDEIRA" id="elo" type="radio" value="HIPERCARD"></li>
    </ul>
    <br>
    <div class="div_ipt_maior" style="width:330px"><span class="lft">Parcelas: </span>
        <select id="parcelas" name="PARCELAS" class="sel_uf" style="float:right; width:200px">
            <?php for ($i = 1; $i <= $max_parcelas; $i++) { ?>
                <?php if($i == 1 || $valor_total/$i >= $parcela_minima) { ?>
                    <option value="<?=($i == 1 ? '00' : $i)?>"><?=$i?>x R$<?=formataMoney($valor_total/$i)?> <? if($i>1) echo "(sem juros)";?></option>
                <?php } ?>
            <?php } ?>
        </select>
        
        <select id="parcelas_1" name="PARCELAS" class="sel_uf" style="float:right; width:200px; display:none;">
            <?php for ($i = 1; $i <= 1; $i++) { ?>
                <?php if($i == 1 || $valor_total/$i >= $parcela_minima) { ?>
                    <option value="<?=($i == 1 ? '00' : $i)?>"><?=$i?>x R$<?=formataMoney($valor_total/$i)?> <? if($i>1) echo "(sem juros)";?></option>
                <?php } ?>
            <?php } ?>
        </select>
        
    </div>
    <div class="separador"></div>
    <input type="hidden" name="codigo_seguro" value="<?=$codigo_seguro?>">
    <input type="hidden" name="NUMPEDIDO" value="<?=$pedido->id_pedido?>">
    <input type='hidden' name="TOTAL" value=<?=$valor_total?>>
    <input type='hidden' name="FILIACAO" value='67455794'>
    <input type='hidden' name="DISTRIBUIDOR" value=''>
    <input type='hidden' name="LANGUAGE" value='POR'>
    <input type='hidden' name="CODVER" value='<?=$codver?>'>
    <!--<input type='hidden' name="URLBACK" value='http://nuwarede.isitecnologia.com.br/sys/loja/Control/rede/retorno.php'>-->
    <input type='hidden' name="URLBACK" id="URLBACK" value="http://www.nuwaspa.com.br/sys/loja/Control/rede/retorno.php">
    <input type='hidden' name="URLCIMA" value='https://nuwaspa.websiteseguro.com/img/nuwa-rede-topo.jpg'>
    <!--<input type='hidden' name="URLCIMA" value='http://nuwarede.isitecnologia.com.br/img/logo_nuwa.gif'>-->
    
    <a href="#" onclick="submete();return false;"><input type="image" class="rgt"  src="/img/bt_finalizar_pagamento.gif"></a>
    </form>
</div>
<!-- conteudo maior fim -->

</div>
</div>
<!--  conteudo fim-->

<?php include($_SERVER['DOCUMENT_ROOT']."/includes/rodape.php"); ?>