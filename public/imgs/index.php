<?php
    // Includes de arquivos de sistema
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Objeto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/TipoProduto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Produto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/MatrizProduto.class.php");

    // Include do arquivo de validacao de cliente
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Cliente.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/includes/valida_cliente.php");

    // Lista os produtos em destaque
    $produtos_destaque = Produto::getProdutoEmDestaque(1, 5);

    $quantidade_produtos_destaque = count($produtos_destaque);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="Day Spa, Spa, Shiatsu, Pedras Quentes, Vichy Shower, Relaxante, Ayurvédica, Drenagem linfática, Banhos de Ofurô, Hidratação Facial, Hidratação Corporal, Yoga, Sauna"/>
<title>Nuwa Spa | Day Spa em Brasília - DF</title>
<link rel="stylesheet" href="/home/css/layout<?=($quantidade_produtos_destaque > 1)?"_$quantidade_produtos_destaque":""?>.css" type="text/css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Old+Standard+TT&v1' rel='stylesheet' type='text/css'/>
<script type="text/javascript" src="/home/js/jquery.js"></script>
<script type="text/javascript" src="/home/js/loader.js"></script>
<script type="text/javascript" src="/home/js/browser.js"></script>
<script type="text/javascript" src="/home/js/slider.js"></script>

<script type="text/javascript" src="/home/js/easing.js"></script>
<script type="text/javascript" src="/home/js/mobilyselect.js"></script>
<script type="text/javascript" src="/home/js/colorbox.js"></script>
<script type="text/javascript" src="/home/js/scrollto.js"></script>
<script type="text/javascript" src="/home/js/functions.js"></script>
<script type="text/javascript" src="http://use.typekit.com/iwx3ceb.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32466665-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

</head>
<body>
    
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-W3XJLZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-W3XJLZ');</script>
<!-- End Google Tag Manager -->

<? if ($quantidade_produtos_destaque) { ?>
    <!--  destaques da home -->
    <div class="home_destaques">
        <div id="slides">
        <ul class="slides_container">
        <?
        $letra = "a";
        foreach ($produtos_destaque as $produto){
            ?>
            <li class="li_<?=$letra?>">
                <div class="figura" style="background:url(/img-terapias/thumb190_<?=mudaExtensaoParaJpg($produto->img_lista)?>);"><a href="/loja/<?=$produto->url_tipo_produto?>/<?=$produto->url?>"></a></div>
                <div class="nome"><a href="/loja/<?=$produto->url_tipo_produto?>/<?=$produto->url?>"><?=$produto->nome?></a></div>
                <div class="real">R$</div>
                <div class="preco"><?=formataMoney($produto->preco)?></div>
            </li>
            <? 
            $letra++;
        } ?>

        </ul>
        </div>
    </div>
    <!--  destques da home fim -->
<? } ?>

<div id="header_wrapper">
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/topo_comum.php"); ?>
</div>
<!-- End Fixed Header Container -->

<div id="wrapper">
<div id="mask">

 <!-- foto 1 -->
<div class="item" id="section1">
<div class="content">
<div class="imgcontainer"><img class="bgimg" src="/home/img/background/a.jpg" alt="" /></div>
<ul class="toggle">
<li><a href="#section4" class="scrollitem toggle_previous"></a></li>
<li><a href="#section2" class="scrollitem toggle_next"></a></li>
</ul>
</div>

</div>
<!-- foto 1 -->

<!-- foto 2 -->
<div class="item" id="section2">
<div class="content">
<div class="imgcontainer"><img class="bgimg" src="/home/img/background/b.jpg" alt="" /></div>
<ul class="toggle">
<li><a href="#section1" class="scrollitem toggle_previous"></a></li>
<li><a href="#section3" class="scrollitem toggle_next"></a></li>
</ul>
</div>
</div>
<!-- foto 2 -->

<!-- foto 3 -->
<div class="item" id="section3">

<div class="content">
<div class="imgcontainer"><img class="bgimg" src="/home/img/background/c.jpg" alt="" /></div>
<ul class="toggle">
<li><a href="#section2" class="scrollitem toggle_previous"></a></li>
<li><a href="#section4" class="scrollitem toggle_next"></a></li>
</ul>
</div>
</div>
<!-- foto 3 -->


<!-- foto 4 -->
<div class="item" id="section4">
<div class="content">
<div class="imgcontainer"><img class="bgimg" src="/home/img/background/d.jpg" alt="" /></div>
<ul class="toggle">
<li><a href="#section3" class="scrollitem toggle_previous"></a></li>
<li><a href="#section1" class="scrollitem toggle_next"></a></li>

</ul>
</div>
</div>
<!-- foto 4 -->

</div>
</div>


<div id="footer">
<?php include($_SERVER['DOCUMENT_ROOT']."/includes/rodape_comum.php"); ?>
</div>
</body>
</html>