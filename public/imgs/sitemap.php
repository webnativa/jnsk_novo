<?php
    // Includes
    // Includes de arquivos de sistema
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Basic.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/api/Model/Database.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Objeto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/TipoProduto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/Produto.class.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/sys/loja/Model/MatrizProduto.class.php");

    // Inicializa os tipos de produtos cadastrados na loja
    $tipos_produto = TipoProduto::listaTipoProduto();
    $todos_produtos = array();
    foreach ($tipos_produto as $tipo) {
        
        // Monta uma lista com os produtos do tipo
        $produtos = Produto::listaProdutoPorTipo($tipo->id_tipo_produto);
        foreach ($produtos as $produto) {
            if($produto->disponivel == 1){
                array_push($todos_produtos, "$tipo->url/$produto->url");
            }
        }
    }
    header("Content-type: application/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <url>
      <loc>http://www.nuwaspa.com.br/</loc>
      <lastmod>2012-11-01</lastmod>
      <changefreq>monthly</changefreq>
      <priority>1.0</priority>
   </url>
<?php
    for($i=0;$i<count($todos_produtos);$i++){
?>
   <url>
      <loc>http://www.nuwaspa.com.br/loja/<?= $todos_produtos[$i]; ?></loc>
      <changefreq>monthly</changefreq>
   </url>
<?php
    }
?>    
   <url>
      <loc>http://www.nuwaspa.com.br/institucional/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/institucional/a-lenda/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/institucional/convenios/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/institucional/parceiros/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/ensino/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/ensino/workshops/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/ensino/palestras/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/corporativo/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/corporativo/clientes/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/corporativo/gifts/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/corporativo/eventos/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/corporativo/proposta/</loc>
      <changefreq>yearly</changefreq>
   </url>
   <url>
      <loc>http://www.nuwaspa.com.br/contato/</loc>
      <changefreq>yearly</changefreq>
   </url>
</urlset>