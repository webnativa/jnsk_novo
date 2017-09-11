-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: fecoagro
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT INTO `administradores` VALUES (1,'Francisco Silva','56d83f3b485e414570125397f634bf88af954ef27a344c288b57108','chicosilva1@gmail.com','$5$rounds=5000$$zho.Z/Acr/T0LR6MGSL5Q2eadlH4Aba5pSKuFb2OI/8','2016-02-25 10:17:42',NULL);
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `data` date DEFAULT NULL,
  `enviado` tinyint(1) DEFAULT NULL,
  `publico` tinyint(4) DEFAULT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
INSERT INTO `agenda` VALUES (1,'teste','2016-03-07 10:30:48','2016-03-07 14:32:22','<p>teste</p>',NULL,NULL,NULL,NULL),(2,'teste','2016-03-07 10:31:10','2016-03-16 08:41:14','<p>teste</p>',NULL,0,NULL,NULL),(3,'teste','2016-03-07 10:31:50','2016-03-16 08:41:17','<p>teste</p>',NULL,0,NULL,NULL),(4,'teste','2016-03-07 14:30:31','2016-03-16 08:41:21','<p>teste</p>','2016-03-26',0,NULL,NULL),(5,'teste','2016-03-21 10:49:59','2017-08-08 09:00:32','<p>teste</p>','2016-03-03',1,NULL,NULL),(6,'28/09/2017 - Francisco de Assis Silva','2017-08-08 08:52:41','2017-08-08 09:00:35','<p>1233342342342342342342344444444444444444444444</p>','2017-09-28',NULL,1,NULL),(7,'03/08/2017 - Francisco de Assis Silva','2017-08-08 09:00:49',NULL,'<p>123123123</p>','2017-08-03',1,1,'É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação'),(8,'31/08/2017 - Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2017-08-08 13:22:05',NULL,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.&nbsp;</p>','2017-08-31',1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ');
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `arquivo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'francisco','http://g1.globo.com/politica/noticia/2015/10/lula-diz-que-dilma-fez-pedaladas-para-pagar-bolsa-familia-e-minha-casa.html','11391396_10153009121863160_5344839870896092153_n.jpg','2015-10-17 10:57:35','2015-10-17 11:05:04'),(2,'Banner 1','','esaude_banner_18nov15-03-03.png','2015-10-17 11:05:17','2017-08-07 15:36:11'),(3,'francisco','s','11080943_1613235748887921_9056220603007794603_n.jpg','2015-10-17 18:00:17','2015-10-17 18:00:31'),(4,'Banner 2','','esaude_banner_18nov15-07-07.png','2015-11-20 09:15:23','2017-08-07 15:36:14'),(5,'banner teste','','unnamed.jpg','2015-11-26 10:41:09','2015-11-26 10:43:15'),(6,'banner 3','','esaude_e-saude_saude_e-commerce_ecommerce_voucher.jpg','2016-03-16 19:16:13','2017-08-07 15:37:21'),(7,'banner 04','tel:(061) 3032 6569','esaude_ecommerce_whatsapp_site_2-01.jpg','2016-03-22 13:15:08','2017-08-07 15:37:23'),(8,'Campo de  produção','http://ccgc.com.br/','banner1.jpg','2017-08-07 15:38:27',NULL),(9,'Banner 2','','banner2.jpg','2017-08-08 13:24:37',NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Relatório Prestação de Contas','2016-03-04 14:06:08',NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cooperativas`
--

DROP TABLE IF EXISTS `cooperativas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cooperativas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8_unicode_ci NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `posicao` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `catalogo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `endereco` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regiao_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cooperativas`
--

LOCK TABLES `cooperativas` WRITE;
/*!40000 ALTER TABLE `cooperativas` DISABLE KEYS */;
INSERT INTO `cooperativas` VALUES (1,'Cemil','cemil','<p>A Cemil - Cooperativa Central Mineira de Latic&iacute;nios Ltda. - foi inaugurada em 1993, na cidade de Campo Belo - MG. A cooperativa iniciou suas atividades industriais com a fabrica&ccedil;&atilde;o de derivados l&aacute;cteos. A sua linha de produtos, contudo, foi ampliada no ano de 1995, j&aacute; visando a sua atua&ccedil;&atilde;o no segmento longa vida. Em 1997, ela deu in&iacute;cio &agrave; implanta&ccedil;&atilde;o de um parque industrial em Patos de Minas (MG), para onde transferiu as suas atividades em 1999.</p>\r\n\r\n<p>Atualmente, a Cemil possui um quadro de associadas composto por quatro cooperativas agropecu&aacute;rias, que s&atilde;o: a Cooperativa Agropecu&aacute;ria de Patroc&iacute;nio Ltda. (Coopa), a Cooperativa Mista Agropecu&aacute;ria de Patos de Minas Ltda. (Coopatos), a Cooperativa Agropecu&aacute;ria do Vale do Paracatu Ltda. (Coopervap) e a Cooperativa Mista Agropecu&aacute;ria de Dores do Indai&aacute; Ltda. (Comadi). Juntas, elas aglomeram mais de sete mil produtores rurais. Hoje a capacidade instalada do parque industrial da Cemil &eacute; de 20 milh&otilde;es de litros mensais. A cooperativa, ainda, conta com equipamentos modernos e de alta precis&atilde;o que garantem a efici&ecirc;ncia da sua linha de produ&ccedil;&atilde;o. Al&eacute;m disso, a gest&atilde;o atual da Cemil tem aprimorado e diversificado o seu mix, com vistas a fornecer produtos que superem as expectativas dos consumidores, acentuando o padr&atilde;o Cemil de qualidade e consolidando a marca no mercado.</p>\r\n\r\n<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"360\" src=\"//www.youtube.com/embed/5RVLnudvfkw\" width=\"640\"></iframe></p>\r\n\r\n<p>A busca constante pela melhoria da qualidade dos servi&ccedil;os prestados contribuiu para que a Cemil se destacasse no mercado entre as marcas mais vendidas do pa&iacute;s, com distribui&ccedil;&atilde;o de produtos em 19 estados brasileiros, posicionando-se em quarto lugar no ranking das empresas l&iacute;deres em vendas de produtos aromatizados de 200ml e em s&eacute;timo lugar entre as empresas l&iacute;deres em vendas de produtos longa vida de 1 litro. A Cemil tamb&eacute;m &eacute; destaquem em gest&atilde;o de log&iacute;stica. A cooperativa conta com uma frota pr&oacute;pria de caminh&otilde;es, possibilitando a entrega de grande parte dos seus produtos, tendo, assim, melhores resultados, efici&ecirc;ncia e qualidade nas entregas.</p>\r\n\r\n<p>O sucesso da marca Cemil est&aacute; centrado na busca permanente por novas tecnologias, que a permite aprimorar a qualidade dos seus produtos e oferecer uma maior comodidade e prazer aos clientes. Em novembro de 2007, a cooperativa iniciou a fabrica&ccedil;&atilde;o dos seus produtos longa vida (leite longa vida, bebidas l&aacute;cteas e sucos &agrave; base de soja) na nova embalagem CombiSwift. No ano de 2010, a Cemil ampliou a sua capacidade de produ&ccedil;&atilde;o da linha de 200ml em 70%, mudando a embalagem dos produtos de &ldquo;slim&rdquo; para &ldquo;base&rdquo; e instalando a mais moderna tecnologia do mundo. Ela tamb&eacute;m inovou ao lan&ccedil;ar o leite com embalagem de meio litro, a six pack (caixas com seis unidades) e o leite condensado meia receita.</p>\r\n\r\n<p>Buscando ampliar ainda mais a sua linha de produtos, a Cemil fez in&uacute;meros investimentos em 2010, finalizando-os em 2011, que dobraram a sua capacidade de produ&ccedil;&atilde;o e que a possibilitaram oferecer ao mercado o leite condensado com a sua marca. Em 2012 tamb&eacute;m foi adquirida mais uma m&aacute;quina de envase de 1 litro, com capacidade para 200 mil litros/dia, e mais uma m&aacute;quina de envase de produtos de 200ml, com capacidade para 40 mil litros/dia. Al&eacute;m disso, a Cooperativa tamb&eacute;m iniciou o empacotamento e a venda de leite em p&oacute;, mais um produto que veio compor o seu mix.</p>\r\n\r\n<p>Por tudo isso, a marca Cemil &eacute; sin&ocirc;nimo de qualidade e de credibilidade, resultado do esfor&ccedil;o daqueles que, desde a sua cria&ccedil;&atilde;o, trabalham incessantemente para satisfazer as necessidades dos seus clientes, superando sempre as expectativas.</p>\r\n\r\n<p>Esse crescimento, ainda, exigiu a amplia&ccedil;&atilde;o do quadro de funcion&aacute;rios da empresa. Sendo assim, a Cemil, que em setembro de 2009 contava com 364 colaboradores, agora contabiliza mais de 800 empregos gerados.</p>\r\n\r\n<p>A hist&oacute;ria da Cemil tem como pilar o trabalho incans&aacute;vel que resulta da uni&atilde;o de in&uacute;meras pessoas, entre elas o cooperado, que est&aacute; no campo produzindo o seu leite, o conselho e, sobretudo, o grupo Cemil, uma equipe forte, coesa, desde o porteiro at&eacute; o seu presidente, composta por colaboradores empenhados em fazer o melhor e entregar qualidade para os consumidores.</p>\r\n\r\n<p><a href=\"http://www.cemil.com.br/\">http://www.cemil.com.br/</a></p>\r\n',2,'2016-02-27 18:32:27',NULL,'logo-cemil.jpg',1,NULL,'Rua espirito Santo, 733, Patos de Minas - Mg',1),(2,'Carpec','carpec','<p>Em 1964, o Dr. Ornub Couto Bruno, ent&atilde;o juiz de direito da Comarca de Carmo do Parana&iacute;ba, apresentou aos seus amigos, In&aacute;cio Teixeira da Cunha e Manoel Veloso dos Reis, a import&acirc;ncia e os benef&iacute;cios de uma cooperativa para os produtores rurais da regi&atilde;o.</p>\r\n\r\n<p><br />\r\nCom o objetivo de fornecer insumos b&aacute;sicos aos produtores de leite da regi&atilde;o, a cooperativa iniciou suas atividades com uma pequena loja de insumos pecu&aacute;rios e um pequeno supermercado.</p>\r\n\r\n<p><br />\r\nOs primeiros produtores eram na maioria fornecedores de leite. Uma vez que a bacia leiteira estava sendo implantada atrav&eacute;s da instala&ccedil;&atilde;o da Companhia Industrial Nestl&eacute; na cidade de Ibi&aacute; MG, a cooperativa prestava servi&ccedil;os &agrave; Nestl&eacute;, efetuando o pagamento do leite fornecido e antecipado aos cooperados a venda de produtos veterin&aacute;rios e aliment&iacute;cios.</p>\r\n\r\n<p><br />\r\nDisp&ocirc;s tamb&eacute;m aos seus cooperados, um veterin&aacute;rio para acompanhamento e evolu&ccedil;&atilde;o do seu rebanho. Com o apoio dos amigos e produtores (tendo em vista que a cooperativa j&aacute; funcionava), partiram ent&atilde;o para a parte legal: constituir a cooperativa formalmente dentro dos padr&otilde;es do cooperativismo.</p>\r\n\r\n<p>No dia 28 de fevereiro de 1965, Dr. Ornub, juntamente com os senhores In&aacute;cio Teixeira e Manoel Veloso e outros produtores, reuniram-se e realizaram a Assembleia de Funda&ccedil;&atilde;o da Cooperativa Agropecu&aacute;ria de Carmo do Parana&iacute;ba Ltda.</p>\r\n\r\n<p>Obedecendo toda tramita&ccedil;&atilde;o legal, posteriormente foi inaugurada no dia 28 de mar&ccedil;o de 1965, a primeira sede em im&oacute;vel alugado &agrave; Rua Gov. Valadares.</p>\r\n\r\n<p>Em&nbsp;<u><strong>1989</strong></u>&nbsp;a cooperativa&nbsp;<u><strong>tornou-se cooperativa de produ&ccedil;&atilde;o</strong></u>&nbsp;pois, passou a receber produtos de cooperados para a efetuar sua comercializa&ccedil;&atilde;o.</p>\r\n\r\n<p>Em 1993 a EMATER-MG e a Cooperativa Agropecu&aacute;ria de Carmo do Parana&iacute;ba Ltda fizeram um convenio para a assist&ecirc;ncia t&eacute;cnica aos cooperados e projetos de financiamento.</p>\r\n\r\n<p>Com a vis&atilde;o cooperativista a cooperativa, elevou seu quadro social tornando assim necess&aacute;rio ampliar o atendimento ao cooperado oferecendo atendimento t&eacute;cnico agron&ocirc;mico e veterin&aacute;rio, venda de produtos agropecu&aacute;rios, insumos agr&iacute;colas, defensivos, armazenamento, rebenef&iacute;cio, comercializa&ccedil;&atilde;o de caf&eacute;, balan&ccedil;a rodovi&aacute;ria de pesagem, capta&ccedil;&atilde;o de leite e supermercado. Atendendo tamb&eacute;m aos seus cooperados com um convenio de plano de sa&uacute;de da UNIMED.</p>\r\n\r\n<p>Em 2005 iniciou a constru&ccedil;&atilde;o para amplia&ccedil;&atilde;o da sede administrativa,&nbsp;com a constru&ccedil;&atilde;o do audit&oacute;rio com capacidade para 120 pessoas.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Em 2012 foi institu&iacute;da/criada e inserida no calend&aacute;rio de eventos, a promo&ccedil;&atilde;o comercial denominada FIDELIDADE PREMIADA CARPEC para os associados produtores de leite, caf&eacute;, cereais e outros, que comprarem nos estabelecimentos comerciais da CARPEC, com objetivo de:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Distribuir pr&ecirc;mios aos associados;</p>\r\n	</li>\r\n	<li>\r\n	<p>Valorizar a fidelidade do associado;</p>\r\n	</li>\r\n	<li>\r\n	<p>Interagir cooperados entre si, colaboradores e diretores;</p>\r\n	</li>\r\n	<li>\r\n	<p>Incentivar a produ&ccedil;&atilde;o e o crescimento sustent&aacute;vel dos associados, consequentemente do munic&iacute;pio e regi&atilde;o;</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Em 18 de mar&ccedil;o de 2013, a CARPEC adquiriu um terreno, sito &agrave; Fazenda Cupins&rdquo;, lugar Soares, margem com a BR 354, neste munic&iacute;pio e comarca, com &aacute;rea de 8.60.23 hectares.</p>\r\n\r\n<p>No segundo semestre de 2013, a CARPEC iniciou a constru&ccedil;&atilde;o da F&aacute;brica de Ra&ccedil;&otilde;es e armazenagem de gr&atilde;os no terreno adquirido, sito a Fazenda Cupins, com in&iacute;cio de produ&ccedil;&atilde;o em outubro/2015.</p>\r\n\r\n<p>A CARPEC adquiriu os armaz&eacute;ns da antiga Casemg, sito &agrave; rua Governador Valadares, 1573 em&nbsp;13/05/2014.</p>\r\n\r\n<p>Em 06 de junho de 2014, a CARPEC adquiriu um terreno, sito &agrave; fazenda &ldquo;Cabeceira do C&oacute;rrego Lenheiros&rdquo;, margem com a rodovia Ageu Garcia de Deus, neste munic&iacute;pio e comarca, com &aacute;rea de 07.00.00(sete) hectares.</p>\r\n\r\n<p>As comemora&ccedil;&otilde;es alusivas aos 50 anos da CARPEC &ndash; Cooperativa Agropecu&aacute;ria de Carmo do Parana&iacute;ba Ltda., ocorreu em 24/04/2015 no Parque de Exposi&ccedil;&otilde;es Apr&iacute;gio Furtado de Oliveira em Carmo do Parana&iacute;ba/MG e, reuniu dirigentes cooperativistas, empresas parceiras, cooperados, colaboradores e familiares, um p&uacute;blico estimado de aproximadamente 9.000 pessoas.</p>\r\n\r\n<p>A FENACARPEC &ndash; I Feira de Neg&oacute;cios Agropecu&aacute;rios CARPEC aconteceu nos dias 30 e 31 de julho do ano de 2015,&nbsp;com o objetivo&nbsp;proporcionar bons neg&oacute;cios, expondo e estabelecendo parcerias estrat&eacute;gicas, contribuindo para o fomento ao desenvolvimento socioecon&ocirc;mico de Carmo do Parana&iacute;ba e regi&atilde;o.</p>\r\n\r\n<p>A CARPEC &ndash; Unidade Tiros/MG &eacute; inaugurada dia 24/10/2015, com objetivo de oferecer melhor atendimento e conforto aos cooperados daquela cidade e regi&atilde;o.</p>\r\n\r\n<p>No dia 26 de outubro de 2015, a CARPEC embarca o primeiro Container de caf&eacute; para os Estados Unidos da Am&eacute;rica, cujo objetivo &eacute; agregar valor &agrave; produ&ccedil;&atilde;o dos cooperados.</p>\r\n\r\n<p><strong>Sobre o cinquenten&aacute;rio...</strong></p>\r\n\r\n<p>O ano do cinquenten&aacute;rio foi comemorado, enaltecendo e homenageando todos aqueles que contribu&iacute;ram para o sucesso da cooperativa, os idealizadores, os fundadores da CARPEC e muitas outras pessoas que, ao longo de 50 anos, ajudaram a construir e a consolidar a cooperativa. &Eacute; um trabalho realizado por muitos, que trouxe organiza&ccedil;&atilde;o, oportunidade a toda a regi&atilde;o em que a CARPEC atua. Os valores e princ&iacute;pios foram crescendo e preservados em:</p>\r\n\r\n<p><strong>C</strong>oopera&ccedil;&atilde;o</p>\r\n\r\n<p><strong>A</strong>cessibilidade</p>\r\n\r\n<p><strong>R</strong>esponsabilidade</p>\r\n\r\n<p><strong>P</strong>rofissionalismo</p>\r\n\r\n<p><strong>&Eacute;</strong>tica</p>\r\n\r\n<p><strong>C</strong>onfian&ccedil;a e respeito ao cooperado.</p>\r\n\r\n<p>S&atilde;o as raz&otilde;es da for&ccedil;a da cooperativa, que explica por que crescemos de forma cont&iacute;nua em cinco d&eacute;cadas. H&aacute; uma intensa participa&ccedil;&atilde;o do cooperado e transpar&ecirc;ncia em rela&ccedil;&atilde;o &agrave;s informa&ccedil;&otilde;es a associados, colaboradores e parceiros.</p>\r\n\r\n<p>A hist&oacute;ria da CARPEC &eacute; de sucesso, conquistado com muito trabalho, dedica&ccedil;&atilde;o, profissionalismo, superando muitas dificuldades ao longo desses 50 anos. A cooperativa tem sido decisiva na transforma&ccedil;&atilde;o da economia da regi&atilde;o em que atua, sempre inovando em produtos e servi&ccedil;os, oferecendo condi&ccedil;&otilde;es para que o nosso cooperado e suas fam&iacute;lias melhorem as condi&ccedil;&otilde;es de vida, bem como a dos colaboradores e fam&iacute;lias tamb&eacute;m.</p>\r\n\r\n<p>A Cooperativa Agropecu&aacute;ria de Carmo do Parana&iacute;ba, h&aacute; 50 anos vem crescendo juntamente com seus cooperados. O nosso crescimento &eacute; o fruto de sua participa&ccedil;&atilde;o cooperado CARPEC.</p>\r\n\r\n<p><a href=\"http://www.carpec.com.br/\">http://www.carpec.com.br/</a></p>\r\n',1,'2016-02-28 09:52:28',NULL,'logo-carpec.jpg',1,NULL,' Av. João Batista da Silva, 398 - Juscelino Kubitschek (JK), Carmo do Paranaíba - MG',2),(3,'CooperChico','cooperchico','<p>s</p>\r\n',1,'2017-08-10 09:17:04',NULL,'gallery5.jpg',1,'gallery8.jpg','Rua Afonso Pena, 1000, Belo Horizonte-Mg',NULL),(4,'Francisco de Assis Silva','francisco-de-assis-silva','<p>1</p>\r\n',1,'2017-08-15 10:18:10',NULL,'gallery1.jpg',1,'gallery7.jpg','ua Afonso Pena, 1000, Belo Horizonte-Mg',NULL),(5,'Francisco de Assis Silva','francisco-de-assis-silva','<p>123</p>\r\n',1,'2017-08-15 10:18:45',NULL,'gallery3.jpg',1,NULL,'Rua Afonso Pena, 1000, Belo Horizonte-Mg',NULL);
/*!40000 ALTER TABLE `cooperativas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos`
--

DROP TABLE IF EXISTS `documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `enviado` tinyint(4) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos`
--

LOCK TABLES `documentos` WRITE;
/*!40000 ALTER TABLE `documentos` DISABLE KEYS */;
INSERT INTO `documentos` VALUES (1,'Francisco de Assis Silva','2017-08-15 14:40:49',NULL,'<p>234</p>',1,1);
/*!40000 ALTER TABLE `documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nucleo_id` int(11) DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8_unicode_ci NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `posicao` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setor_id` int(11) DEFAULT NULL,
  `coorporativo` tinyint(4) DEFAULT NULL,
  `mtelefone` tinyint(4) DEFAULT NULL,
  `memail` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2449BA15F8E74B7F` (`nucleo_id`),
  KEY `IDX_2449BA154D94F126` (`setor_id`),
  CONSTRAINT `FK_2449BA154D94F126` FOREIGN KEY (`setor_id`) REFERENCES `setores` (`id`),
  CONSTRAINT `FK_2449BA15F8E74B7F` FOREIGN KEY (`nucleo_id`) REFERENCES `nucleos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipe`
--

LOCK TABLES `equipe` WRITE;
/*!40000 ALTER TABLE `equipe` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fila_agenda`
--

DROP TABLE IF EXISTS `fila_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fila_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `agenda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `enviado` tinyint(1) DEFAULT NULL,
  `data_envio` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_10B0E032DB38439E` (`usuario_id`),
  CONSTRAINT `FK_10B0E032DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fila_agenda`
--

LOCK TABLES `fila_agenda` WRITE;
/*!40000 ALTER TABLE `fila_agenda` DISABLE KEYS */;
INSERT INTO `fila_agenda` VALUES (1,1,'8','2017-08-15 14:01:19',NULL,1,'2017-08-15 14:36:00'),(2,1,'7','2017-08-15 14:12:56',NULL,1,'2017-08-15 14:36:00'),(3,1,'8','2017-08-15 14:24:54',NULL,1,'2017-08-15 14:36:00'),(4,1,'7','2017-08-15 14:28:13',NULL,1,'2017-08-15 14:36:00'),(5,1,'8','2017-08-15 14:28:56',NULL,1,'2017-08-15 14:36:00'),(6,1,'7','2017-08-15 14:30:29',NULL,1,'2017-08-15 14:36:00'),(7,1,'8','2017-08-15 14:33:53',NULL,1,'2017-08-15 14:36:00'),(8,1,'7','2017-08-15 14:35:58',NULL,1,'2017-08-15 14:36:01');
/*!40000 ALTER TABLE `fila_agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fila_documentos`
--

DROP TABLE IF EXISTS `fila_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fila_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `enviado` tinyint(1) DEFAULT NULL,
  `data_envio` datetime DEFAULT NULL,
  `documento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A456C9FFDB38439E` (`usuario_id`),
  CONSTRAINT `FK_A456C9FFDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fila_documentos`
--

LOCK TABLES `fila_documentos` WRITE;
/*!40000 ALTER TABLE `fila_documentos` DISABLE KEYS */;
INSERT INTO `fila_documentos` VALUES (1,1,'2017-08-15 14:40:52',NULL,1,'2017-08-15 14:40:55','1');
/*!40000 ALTER TABLE `fila_documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instituicao`
--

DROP TABLE IF EXISTS `instituicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instituicao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `posicao` int(11) NOT NULL,
  `slug` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instituicao`
--

LOCK TABLES `instituicao` WRITE;
/*!40000 ALTER TABLE `instituicao` DISABLE KEYS */;
INSERT INTO `instituicao` VALUES (1,'Diretoria','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl nisl, laoreet ac aliquam sit amet, auctor et mi. Vivamus at ligula hendrerit, ornare lacus in, semper magna. Proin a feugiat quam. Suspendisse viverra neque in ornare fermentum. Mauris elit est, rhoncus ac viverra vitae, laoreet ac dolor. Curabitur eu pretium libero. Morbi pulvinar sem vitae orci tincidunt mattis.</p>\r\n\r\n<p>Donec erat velit, mattis accumsan malesuada quis, egestas nec arcu. Sed semper elementum lacus a dapibus. Phasellus feugiat molestie malesuada. Duis euismod, metus vitae imperdiet tempus, arcu urna tristique nulla, sed accumsan nunc urna ut nulla. Aliquam erat volutpat. Nam congue nibh eu leo fermentum, ac pretium turpis lacinia. Nulla at laoreet dui. Morbi tempus sit amet odio id mattis. Nunc feugiat, arcu at facilisis sodales, magna arcu facilisis nibh, vel elementum tellus nibh non orci. Integer congue lectus sed lectus imperdiet, vitae fermentum erat vulputate. Morbi malesuada metus eu libero tincidunt pharetra. Donec interdum elementum tortor, et rutrum sem tempus sed. Nulla facilisi. Aenean lacus orci, vestibulum quis dui porta, vulputate semper arcu.</p>\r\n\r\n<p>Etiam ut orci vel quam convallis ultrices nec ut arcu. Vestibulum vitae condimentum odio. Vestibulum ac fermentum quam. Fusce non tristique orci, sed sollicitudin arcu. Morbi at dolor scelerisque, lobortis risus id, fringilla arcu. Quisque vitae lacinia nulla. Donec ac consectetur libero, et euismod turpis. Nulla tincidunt porta leo, vitae vehicula velit ullamcorper eget.</p>\r\n\r\n<p>Nam ac lectus non nibh suscipit tempor a luctus felis. Praesent consectetur quis eros at sagittis. Vestibulum dui ante, sagittis id sapien et, scelerisque vehicula arcu. Fusce maximus lectus nec neque lacinia tempus. Fusce eu facilisis felis, eget dignissim nisi. Ut non accumsan ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc pellentesque felis ac lacus ornare molestie.</p>\r\n\r\n<p>Mauris blandit aliquet magna, et scelerisque massa ullamcorper et. Vivamus vitae lacus ex. Integer dictum pharetra imperdiet. Nullam imperdiet semper nisl nec dapibus. Pellentesque pellentesque aliquet sapien. In laoreet sapien nisi, id cursus nunc convallis sit amet. Maecenas mattis mi in ex consequat, id sollicitudin ex sodales. Integer nec dui semper lectus molestie porttitor eu sed lacus. Duis id ultricies dui, lobortis consectetur diam.</p>','2016-02-27 11:59:25',NULL,4,''),(2,'Diretrizes Estratégicas','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl nisl, laoreet ac aliquam sit amet, auctor et mi. Vivamus at ligula hendrerit, ornare lacus in, semper magna. Proin a feugiat quam. Suspendisse viverra neque in ornare fermentum. Mauris elit est, rhoncus ac viverra vitae, laoreet ac dolor. Curabitur eu pretium libero. Morbi pulvinar sem vitae orci tincidunt mattis.</p>\r\n\r\n<p>Donec erat velit, mattis accumsan malesuada quis, egestas nec arcu. Sed semper elementum lacus a dapibus. Phasellus feugiat molestie malesuada. Duis euismod, metus vitae imperdiet tempus, arcu urna tristique nulla, sed accumsan nunc urna ut nulla. Aliquam erat volutpat. Nam congue nibh eu leo fermentum, ac pretium turpis lacinia. Nulla at laoreet dui. Morbi tempus sit amet odio id mattis. Nunc feugiat, arcu at facilisis sodales, magna arcu facilisis nibh, vel elementum tellus nibh non orci. Integer congue lectus sed lectus imperdiet, vitae fermentum erat vulputate. Morbi malesuada metus eu libero tincidunt pharetra. Donec interdum elementum tortor, et rutrum sem tempus sed. Nulla facilisi. Aenean lacus orci, vestibulum quis dui porta, vulputate semper arcu.</p>\r\n\r\n<p>Etiam ut orci vel quam convallis ultrices nec ut arcu. Vestibulum vitae condimentum odio. Vestibulum ac fermentum quam. Fusce non tristique orci, sed sollicitudin arcu. Morbi at dolor scelerisque, lobortis risus id, fringilla arcu. Quisque vitae lacinia nulla. Donec ac consectetur libero, et euismod turpis. Nulla tincidunt porta leo, vitae vehicula velit ullamcorper eget.</p>\r\n\r\n<p>Nam ac lectus non nibh suscipit tempor a luctus felis. Praesent consectetur quis eros at sagittis. Vestibulum dui ante, sagittis id sapien et, scelerisque vehicula arcu. Fusce maximus lectus nec neque lacinia tempus. Fusce eu facilisis felis, eget dignissim nisi. Ut non accumsan ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc pellentesque felis ac lacus ornare molestie.</p>\r\n\r\n<p>Mauris blandit aliquet magna, et scelerisque massa ullamcorper et. Vivamus vitae lacus ex. Integer dictum pharetra imperdiet. Nullam imperdiet semper nisl nec dapibus. Pellentesque pellentesque aliquet sapien. In laoreet sapien nisi, id cursus nunc convallis sit amet. Maecenas mattis mi in ex consequat, id sollicitudin ex sodales. Integer nec dui semper lectus molestie porttitor eu sed lacus. Duis id ultricies dui, lobortis consectetur diam.</p>\r\n\r\n<p>&nbsp;</p>','2016-02-27 12:11:21',NULL,3,''),(3,'Link de Exemplo','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl nisl, laoreet ac aliquam sit amet, auctor et mi. Vivamus at ligula hendrerit, ornare lacus in, semper magna. Proin a feugiat quam. Suspendisse viverra neque in ornare fermentum. Mauris elit est, rhoncus ac viverra vitae, laoreet ac dolor. Curabitur eu pretium libero. Morbi pulvinar sem vitae orci tincidunt mattis.</p>\r\n\r\n<p>Donec erat velit, mattis accumsan malesuada quis, egestas nec arcu. Sed semper elementum lacus a dapibus. Phasellus feugiat molestie malesuada. Duis euismod, metus vitae imperdiet tempus, arcu urna tristique nulla, sed accumsan nunc urna ut nulla. Aliquam erat volutpat. Nam congue nibh eu leo fermentum, ac pretium turpis lacinia. Nulla at laoreet dui. Morbi tempus sit amet odio id mattis. Nunc feugiat, arcu at facilisis sodales, magna arcu facilisis nibh, vel elementum tellus nibh non orci. Integer congue lectus sed lectus imperdiet, vitae fermentum erat vulputate. Morbi malesuada metus eu libero tincidunt pharetra. Donec interdum elementum tortor, et rutrum sem tempus sed. Nulla facilisi. Aenean lacus orci, vestibulum quis dui porta, vulputate semper arcu.</p>\r\n\r\n<p>Etiam ut orci vel quam convallis ultrices nec ut arcu. Vestibulum vitae condimentum odio. Vestibulum ac fermentum quam. Fusce non tristique orci, sed sollicitudin arcu. Morbi at dolor scelerisque, lobortis risus id, fringilla arcu. Quisque vitae lacinia nulla. Donec ac consectetur libero, et euismod turpis. Nulla tincidunt porta leo, vitae vehicula velit ullamcorper eget.</p>\r\n\r\n<p>Nam ac lectus non nibh suscipit tempor a luctus felis. Praesent consectetur quis eros at sagittis. Vestibulum dui ante, sagittis id sapien et, scelerisque vehicula arcu. Fusce maximus lectus nec neque lacinia tempus. Fusce eu facilisis felis, eget dignissim nisi. Ut non accumsan ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc pellentesque felis ac lacus ornare molestie.</p>\r\n\r\n<p>Mauris blandit aliquet magna, et scelerisque massa ullamcorper et. Vivamus vitae lacus ex. Integer dictum pharetra imperdiet. Nullam imperdiet semper nisl nec dapibus. Pellentesque pellentesque aliquet sapien. In laoreet sapien nisi, id cursus nunc convallis sit amet. Maecenas mattis mi in ex consequat, id sollicitudin ex sodales. Integer nec dui semper lectus molestie porttitor eu sed lacus. Duis id ultricies dui, lobortis consectetur diam.</p>','2016-02-27 12:11:37',NULL,2,''),(4,'Apresentação','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl nisl, laoreet ac aliquam sit amet, auctor et mi. Vivamus at ligula hendrerit, ornare lacus in, semper magna. Proin a feugiat quam. Suspendisse viverra neque in ornare fermentum. Mauris elit est, rhoncus ac viverra vitae, laoreet ac dolor. Curabitur eu pretium libero. Morbi pulvinar sem vitae orci tincidunt mattis.</p>\r\n\r\n<p>Donec erat velit, mattis accumsan malesuada quis, egestas nec arcu. Sed semper elementum lacus a dapibus. Phasellus feugiat molestie malesuada. Duis euismod, metus vitae imperdiet tempus, arcu urna tristique nulla, sed accumsan nunc urna ut nulla. Aliquam erat volutpat. Nam congue nibh eu leo fermentum, ac pretium turpis lacinia. Nulla at laoreet dui. Morbi tempus sit amet odio id mattis. Nunc feugiat, arcu at facilisis sodales, magna arcu facilisis nibh, vel elementum tellus nibh non orci. Integer congue lectus sed lectus imperdiet, vitae fermentum erat vulputate. Morbi malesuada metus eu libero tincidunt pharetra. Donec interdum elementum tortor, et rutrum sem tempus sed. Nulla facilisi. Aenean lacus orci, vestibulum quis dui porta, vulputate semper arcu.</p>\r\n\r\n<p>Etiam ut orci vel quam convallis ultrices nec ut arcu. Vestibulum vitae condimentum odio. Vestibulum ac fermentum quam. Fusce non tristique orci, sed sollicitudin arcu. Morbi at dolor scelerisque, lobortis risus id, fringilla arcu. Quisque vitae lacinia nulla. Donec ac consectetur libero, et euismod turpis. Nulla tincidunt porta leo, vitae vehicula velit ullamcorper eget.</p>\r\n\r\n<p>Nam ac lectus non nibh suscipit tempor a luctus felis. Praesent consectetur quis eros at sagittis. Vestibulum dui ante, sagittis id sapien et, scelerisque vehicula arcu. Fusce maximus lectus nec neque lacinia tempus. Fusce eu facilisis felis, eget dignissim nisi. Ut non accumsan ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc pellentesque felis ac lacus ornare molestie.</p>\r\n\r\n<p>Mauris blandit aliquet magna, et scelerisque massa ullamcorper et. Vivamus vitae lacus ex. Integer dictum pharetra imperdiet. Nullam imperdiet semper nisl nec dapibus. Pellentesque pellentesque aliquet sapien. In laoreet sapien nisi, id cursus nunc convallis sit amet. Maecenas mattis mi in ex consequat, id sollicitudin ex sodales. Integer nec dui semper lectus molestie porttitor eu sed lacus. Duis id ultricies dui, lobortis consectetur diam.</p>','2016-02-27 12:12:29',NULL,1,'');
/*!40000 ALTER TABLE `instituicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsLetter`
--

DROP TABLE IF EXISTS `newsLetter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsLetter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsLetter`
--

LOCK TABLES `newsLetter` WRITE;
/*!40000 ALTER TABLE `newsLetter` DISABLE KEYS */;
INSERT INTO `newsLetter` VALUES (1,'chicosilva1@gmail.com','2017-08-15 16:18:21',NULL,'francisco',NULL);
/*!40000 ALTER TABLE `newsLetter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8_unicode_ci NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enviado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` VALUES (45,'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','teste-1222','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed finibus auctor erat et rhoncus. Aliquam purus eros, porttitor ut velit non, vestibulum mattis nisl. Duis in mollis ante, id feugiat lectus. Vivamus tempus elit sit amet mi dapibus sollicitudin. Pellentesque molestie rhoncus vehicula. Duis laoreet diam vitae lectus aliquet aliquam. Vivamus mollis, risus sit amet eleifend dapibus, massa mi placerat mauris, vitae ultricies sem quam non orci. Pellentesque ac pulvinar orci. Integer vulputate dui in finibus lobortis. Quisque faucibus volutpat metus in finibus.</p>\r\n\r\n<p>Nunc non quam nec erat eleifend dictum id et nisi. Integer sapien est, imperdiet ut ante sit amet, faucibus auctor libero. Nunc tempor orci nec luctus porta. Integer aliquet libero at odio eleifend, quis porttitor urna cursus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras in nisl orci. Duis nec egestas dui, eu hendrerit dui. Maecenas varius purus at pulvinar varius. Suspendisse in lacus ac nibh finibus maximus. Fusce non magna consequat, scelerisque arcu ac, convallis nisi.</p>\r\n','2017-08-07 17:35:59',NULL,'gallery7.jpg','Lorem ipsum dolor sit amet, consectetur adipiscing elit. ',0),(46,'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.&nbsp;</p>\r\n','2017-08-08 13:21:02',NULL,'gallery11.jpg','Lorem ipsum dolor sit amet, consectetur adipiscing elit. ',1),(47,'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.&nbsp;</p>\r\n','2017-08-08 13:21:16',NULL,'gallery5.jpg','Lorem ipsum dolor sit amet, consectetur adipiscing elit. ',1);
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nucleo_agenda`
--

DROP TABLE IF EXISTS `nucleo_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nucleo_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agenda_id` int(11) DEFAULT NULL,
  `nucleo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_12E8F439EA67784A` (`agenda_id`),
  KEY `IDX_12E8F439F8E74B7F` (`nucleo_id`),
  CONSTRAINT `FK_12E8F439EA67784A` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`),
  CONSTRAINT `FK_12E8F439F8E74B7F` FOREIGN KEY (`nucleo_id`) REFERENCES `nucleos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nucleo_agenda`
--

LOCK TABLES `nucleo_agenda` WRITE;
/*!40000 ALTER TABLE `nucleo_agenda` DISABLE KEYS */;
INSERT INTO `nucleo_agenda` VALUES (15,5,6),(16,6,6),(17,6,5),(22,7,6),(23,8,2);
/*!40000 ALTER TABLE `nucleo_agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nucleo_documento`
--

DROP TABLE IF EXISTS `nucleo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nucleo_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento_id` int(11) DEFAULT NULL,
  `nucleo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CF2C034345C0CF75` (`documento_id`),
  KEY `IDX_CF2C0343F8E74B7F` (`nucleo_id`),
  CONSTRAINT `FK_CF2C034345C0CF75` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`),
  CONSTRAINT `FK_CF2C0343F8E74B7F` FOREIGN KEY (`nucleo_id`) REFERENCES `nucleos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nucleo_documento`
--

LOCK TABLES `nucleo_documento` WRITE;
/*!40000 ALTER TABLE `nucleo_documento` DISABLE KEYS */;
INSERT INTO `nucleo_documento` VALUES (1,1,6),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,1);
/*!40000 ALTER TABLE `nucleo_documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nucleo_usuario`
--

DROP TABLE IF EXISTS `nucleo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nucleo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `nucleo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B33FD9F6DB38439E` (`usuario_id`),
  KEY `IDX_B33FD9F6F8E74B7F` (`nucleo_id`),
  CONSTRAINT `FK_B33FD9F6DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `FK_B33FD9F6F8E74B7F` FOREIGN KEY (`nucleo_id`) REFERENCES `nucleos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nucleo_usuario`
--

LOCK TABLES `nucleo_usuario` WRITE;
/*!40000 ALTER TABLE `nucleo_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `nucleo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nucleos`
--

DROP TABLE IF EXISTS `nucleos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nucleos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projeto_id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8_unicode_ci NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `posicao` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coorporativo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D71D6FB743B58490` (`projeto_id`),
  CONSTRAINT `FK_D71D6FB743B58490` FOREIGN KEY (`projeto_id`) REFERENCES `projetos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nucleos`
--

LOCK TABLES `nucleos` WRITE;
/*!40000 ALTER TABLE `nucleos` DISABLE KEYS */;
INSERT INTO `nucleos` VALUES (1,1,'Supermercado','Processo de compra de produtos para os supermercados das consorciadas','supermercado','<p>N&uacute;cleo Supermecado -&nbsp;Processo de compra de produtos para os supermercados das consorciadas.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Compradores:</p>\r\n\r\n<p>- Jaime Magela</p>\r\n\r\n<p>- Guilherme Rodrigues</p>\r\n\r\n<p>&nbsp;</p>\r\n',7,'2016-02-27 14:37:32',NULL,'Depositphotos_56043701_s-2015.jpg','(34) 53453-4534','jaime.magela@ccgc.com.br','daise.junia@ccgc.com.br',1),(2,1,'Agropecuária/ Medicamento','Processo de compra de produtos para as lojas agropecuárias das consorciadas (Medicamentos em geral)','agropecuario','<p>N&uacute;cleo Agropecu&aacute;ria/ Medicamento -&nbsp;Processo de compra de produtos para as lojas agropecu&aacute;rias das consorciadas (Medicamentos em geral).&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Compradores:</p>\r\n\r\n<p>- F&aacute;bio J&uacute;nior</p>\r\n\r\n<p>- Ana Maria&nbsp;</p>\r\n',3,'2016-02-28 10:24:35',NULL,'agro4.jpg','(23) 42342-3444','fabio.junior@ccgc.com.br','daise.junia@ccgc.com.br',1),(3,1,'Laticínio','Processo de compra de produtos, equipamentos, peças, insumos e embalagens para os laticínios das consorciadas','laticinio','<p>N&uacute;cleo Latic&iacute;nio - Processo de compra de produtos, equipamentos, pe&ccedil;as, insumos e embalagens para os latic&iacute;nios das consorciadas.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Comprador:</p>\r\n\r\n<p>- Helv&eacute;cio Costa</p>\r\n\r\n<p>&nbsp;</p>\r\n',4,'2016-02-28 10:25:16',NULL,'laticlo11.jpg','(12) 31231-2312','helvecio.costa@ccgc.com.br','daise.junia@ccgc.com.br',1),(4,1,'Logística','Processo de compra de produtos, serviços, equipamentos, peças e acessórios para os setores de Transporte e Postos de Combustíveis das consorciadas','logistica','<p>N&uacute;cleo Log&iacute;stica - Processo de compra de produtos, servi&ccedil;os, equipamentos, pe&ccedil;as e acess&oacute;rios para os setores de Transporte e Postos de Combust&iacute;veis das consorciadas.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Comprador:</p>\r\n\r\n<p>- Eust&aacute;quio Amorim</p>\r\n\r\n<p>&nbsp;</p>\r\n',5,'2016-03-03 22:17:24',NULL,'IMG-20150121-WA0027v2.jpg','(23) 42234-2342','eustaquio.amorim@ccgc.com.br','daise.junia@ccgc.com.br',1),(5,1,'Nutrição Animal','Processo de compra de produtos, equipamentos, peças, insumos e embalagens para as fábricas de ração das consorciadas','nutricao-animal','<p>N&uacute;cleo Nutri&ccedil;&atilde;o Animal - Processo de compra de produtos, equipamentos, pe&ccedil;as, insumos e embalagens para as f&aacute;bricas de ra&ccedil;&atilde;o das consorciadas.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Comprador:</p>\r\n\r\n<p>- Wellerson Borges</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n',6,'2016-03-03 22:21:25',NULL,'animalnutri.jpg','(34) 3818-3731','wellerson.borges@ccgc.com.br','daise.junia@ccgc.com.br',1),(6,1,'Agropecuária','Processo de compra de produtos para as lojas agropecuárias das consorciadas','agropecuaria','<p>N&uacute;cleo Agropecu&aacute;ria&nbsp;- Processo de compra de produtos para as lojas agropecu&aacute;rias das consorciadas (Pe&ccedil;as, Ferragens e Utens&iacute;lios em geral).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Compradores:</p>\r\n\r\n<p>- Jaime Magela</p>\r\n\r\n<p>- Ana Maria</p>\r\n',2,'2016-03-03 22:29:40',NULL,'bovino.jpg','(23) 42342-3424','jaime.magela@ccgc.com.br','daise.junia@ccgc.com.br',1),(7,4,'Diretoria','Diretoria CCGC e Diretoria Consorciada','ccgc-corporativo','<p>Diretoria CCGC e Diretoria Consorciada</p>\r\n',1,'2016-03-07 07:16:24','2016-03-18 11:22:46',NULL,'(34) 3818-3731','nidelson.falcao@ccgc.com.br','daise.junia@ccgc.com.br',0);
/*!40000 ALTER TABLE `nucleos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil_agenda`
--

DROP TABLE IF EXISTS `perfil_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agenda_id` int(11) DEFAULT NULL,
  `perfil_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_40F0CC9AEA67784A` (`agenda_id`),
  KEY `IDX_40F0CC9A57291544` (`perfil_id`),
  CONSTRAINT `FK_40F0CC9A57291544` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`),
  CONSTRAINT `FK_40F0CC9AEA67784A` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_agenda`
--

LOCK TABLES `perfil_agenda` WRITE;
/*!40000 ALTER TABLE `perfil_agenda` DISABLE KEYS */;
INSERT INTO `perfil_agenda` VALUES (21,7,1),(22,8,1);
/*!40000 ALTER TABLE `perfil_agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil_documento`
--

DROP TABLE IF EXISTS `perfil_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento_id` int(11) DEFAULT NULL,
  `perfil_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_10E1C48545C0CF75` (`documento_id`),
  KEY `IDX_10E1C48557291544` (`perfil_id`),
  CONSTRAINT `FK_10E1C48545C0CF75` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`),
  CONSTRAINT `FK_10E1C48557291544` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_documento`
--

LOCK TABLES `perfil_documento` WRITE;
/*!40000 ALTER TABLE `perfil_documento` DISABLE KEYS */;
INSERT INTO `perfil_documento` VALUES (1,1,1);
/*!40000 ALTER TABLE `perfil_documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfis`
--

DROP TABLE IF EXISTS `perfis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfis`
--

LOCK TABLES `perfis` WRITE;
/*!40000 ALTER TABLE `perfis` DISABLE KEYS */;
INSERT INTO `perfis` VALUES (1,'Secretaria','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `perfis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projetos`
--

DROP TABLE IF EXISTS `projetos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projetos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8_unicode_ci NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `posicao` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cor` longtext COLLATE utf8_unicode_ci,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projetos`
--

LOCK TABLES `projetos` WRITE;
/*!40000 ALTER TABLE `projetos` DISABLE KEYS */;
INSERT INTO `projetos` VALUES (1,'Central de Compras','central-de-compras','<p>Dentre as v&aacute;rias &aacute;reas de atua&ccedil;&atilde;o, o cons&oacute;rcio iniciou (Mar&ccedil;o/2013)&nbsp;sua opera&ccedil;&atilde;o com uma Central de Compras que envolve aquisi&ccedil;&atilde;o de produtos e servi&ccedil;os segmentados nas seguintes &aacute;reas:</p>\r\n\r\n<p>1) N&uacute;cleo Agropecu&aacute;ria&nbsp;- Processo de compra de produtos para as lojas agropecu&aacute;rias das consorciadas (Pe&ccedil;as, Ferragens e Utens&iacute;lios em geral).</p>\r\n\r\n<p>2) N&uacute;cleo Agropecu&aacute;ria/ Medicamento -&nbsp;Processo de compra de produtos para as lojas agropecu&aacute;rias das consorciadas (Medicamentos em geral).&nbsp;</p>\r\n\r\n<p>3) N&uacute;cleo Latic&iacute;nio - Processo de compra de produtos, equipamentos, pe&ccedil;as, insumos e embalagens para os latic&iacute;nios das consorciadas.</p>\r\n\r\n<p>4) N&uacute;cleo Log&iacute;stica - Processo de compra de produtos, servi&ccedil;os, equipamentos, pe&ccedil;as e acess&oacute;rios para os setores de Transporte e Postos de Combust&iacute;veis das consorciadas.</p>\r\n\r\n<p>5)&nbsp;N&uacute;cleo Nutri&ccedil;&atilde;o Animal - Processo de compra de produtos, equipamentos, pe&ccedil;as, insumos e embalagens para as f&aacute;bricas de ra&ccedil;&atilde;o das consorciadas.</p>\r\n\r\n<p>6) N&uacute;cleo Supermercado - Processo de compra de produtos (mercadorias) para os supermercados das consorciadas.</p>\r\n\r\n<p>A estrutura foi criada com a contrata&ccedil;&atilde;o de profissionais (compradores) oriundos das cooperativas que integram o cons&oacute;rcio e, dessa forma, buscou-se preservar o conhecimento de processos e garantir a cultura cooperativista. Tal iniciativa (central de compras) visa unir opera&ccedil;&otilde;es comuns para a obten&ccedil;&atilde;o de ganho coletivo, sem, contudo, interferir nas rela&ccedil;&otilde;es comerciais e contratuais existentes nas cooperativas. Assim, ao inv&eacute;s destas consorciadas atuarem isoladamente na compra de alguns itens predefinidos e comuns &agrave;s demais, isso &eacute; feito pela Central de Compras considerando o montante das cooperativas. Desta forma, os pedidos continuam com faturamento individualizado por cooperativa, por&eacute;m com o volume total sendo negociado conjuntamente. Vale ressaltar que os demais contatos de cunho comercial, procedimentos e projetos mantidos entre os fornecedores e as respectivas cooperativas permanecem inalterados.</p>\r\n',2,'2016-02-27 14:05:27',NULL,'Central de Compras','#f60935',1),(2,'CCGC Jurídico','juridico','<p>Jur&iacute;dico</p>\r\n',4,'2016-02-27 14:06:14','2016-03-10 10:10:40','Jurídico','#D8A84F',NULL),(3,'CCGC Recursos Humanos','educacao','<p>Recursos Humanos</p>\r\n',3,'2016-02-27 14:09:53','2016-03-10 10:10:35','Recursos Humanos','#47A2FF',NULL),(4,'CCGC Corporativo','ccgc-corporativo','<p>Trata-se da inst&acirc;ncia Corporativa do CCGC e integra os demais projetos do Cons&oacute;rcio.</p>\r\n',1,'2016-03-07 07:13:11',NULL,'Corporativo',NULL,NULL);
/*!40000 ALTER TABLE `projetos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regioes`
--

DROP TABLE IF EXISTS `regioes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regioes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regioes`
--

LOCK TABLES `regioes` WRITE;
/*!40000 ALTER TABLE `regioes` DISABLE KEYS */;
INSERT INTO `regioes` VALUES (1,'Alto Paranaíba',NULL,'alto-paranaiba'),(2,'Triângulo Mineiro',NULL,'triangulo-mineiro');
/*!40000 ALTER TABLE `regioes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setores`
--

DROP TABLE IF EXISTS `setores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setores`
--

LOCK TABLES `setores` WRITE;
/*!40000 ALTER TABLE `setores` DISABLE KEYS */;
INSERT INTO `setores` VALUES (1,'CCGC Corporativo','0000-00-00 00:00:00',NULL),(2,'Central de Compras','0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `setores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `cooperativa_id` int(11) DEFAULT NULL,
  `perfil_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EF687F257291544` (`perfil_id`),
  CONSTRAINT `FK_EF687F257291544` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'francisco de assis silva','599361b51ca5d15028310297f634bf88af954ef27a344c288b57108','chicosilva1@gmail.com','$5$rounds=5000$$zho.Z/Acr/T0LR6MGSL5Q2eadlH4Aba5pSKuFb2OI/8','2017-08-15 13:59:34',NULL,4,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8_unicode_ci NOT NULL,
  `texto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'Cemil','testete','<p><iframe frameborder=\"0\" height=\"315\" src=\"https://www.youtube.com/embed/s0dSTZdgxzg\" width=\"100%\"></iframe></p>\r\n\r\n<p>veja esse outro video</p>\r\n\r\n<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"360\" src=\"//www.youtube.com/embed/5RVLnudvfkw\" width=\"640\"></iframe></p>\r\n','2016-02-28 09:23:47',NULL,'gallery6.jpg'),(2,'Cemil','teste','<p><iframe frameborder=\"0\" height=\"315\" src=\"https://www.youtube.com/embed/s0dSTZdgxzg\" width=\"100%\"></iframe></p>\r\n','2016-03-03 10:05:53','2016-03-07 16:18:53',NULL),(3,'Coopervap','coopervap','<p><iframe frameborder=\"0\" name=\"Coopervap\" scrolling=\"no\" src=\"https://www.youtube.com/watch?v=OVudQcGf39E\"></iframe></p>\r\n','2016-03-07 15:23:06','2016-03-07 16:18:48',NULL),(4,'Coopervap','coopervap','<p><iframe align=\"middle\" frameborder=\"1\" height=\"400\" longdesc=\"Coopervap\" scrolling=\"yes\" src=\"https://www.youtube.com/watch?v=OVudQcGf39E\" width=\"1000\"></iframe></p>\r\n','2016-03-07 16:23:05','2016-03-07 16:24:07',NULL),(5,'Video 1','video-1','<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"360\" src=\"//www.youtube.com/embed/kXN0kjxIqC0\" width=\"640\"></iframe></p>\r\n','2017-08-08 08:19:11',NULL,'gallery2.jpg'),(6,'Francisco de Assis Silva','francisco-de-assis-silva','<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"315\" src=\"https://www.youtube.com/embed/2qMhb0WDVyQ\" width=\"560\"></iframe></p>\r\n','2017-08-08 13:26:07',NULL,'gallery6.jpg'),(7,'teste 2','teste-2','<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"315\" src=\"https://www.youtube.com/embed/2qMhb0WDVyQ\" width=\"560\"></iframe></p>\r\n','2017-08-08 13:26:29',NULL,'gallery5.jpg');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-15 18:22:31
