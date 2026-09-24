<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2007       		   **
	**                                                                         **
	*****************************************************************************
	*****************************************************************************
	*/
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");
	require_once("../init.php");	
	require_once("../functii/f_bd.php");
	require_once("../functii/f_links.php");
	require_once("../functii/f_generale.php");
	require_once("rss_generator.inc.php");
	
	$rss_channel=new rssGenerator_channel();
	$rss_channel->title=NUME_FIRMA;
	$rss_channel->link=URL_BASE;
	$rss_channel->description="Ultimele noutati..";
	$rss_channel->language="en-us";
	$rss_channel->generator="RSS Feed Generator";	
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//@select ultimele produsea adaugate
	$arr_produse=arrayFromDB(array("id_produs",
								   "t_produse.id_cat",
								   "id_prod",
								   "nume_produs",
								   "pret",
								   "pret_vechi",
								   "stoc",
								   "t_categorii.link_cat",
								   "t_producatori.nume_cat",
								   "t_producatori.id_cat"),
							 "t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat 
							 			LEFT JOIN t_categorii AS t_producatori ON t_produse.id_prod=t_producatori.id_cat",
							 "WHERE t_produse.tip='0' AND t_categorii.activ='1' ORDER BY id_produs DESC LIMIT 0, ".AFISARI_ULTIMELE_PRODUSE_ADAUGATE);		
	
	$nr_produse=count($arr_produse);
	
	//------------------------------------------------------------------------------------------------------------------------------
	//LOOP PRIN ULTIMELE PRODUSE ADAUGATE
	for($i=0;$i<$nr_produse;$i++)
	{
		//@item
		$item = new rssGenerator_item();
		$item->title=$arr_produse[$i]["nume_produs"];
		$item->description="<ul>";
		$item->description.= "<li>Pret: ".formateazaNr($arr_produse[$i]["pret"]*TVA)." ".MONEDA."</li>";
		$item->description.= "<li>Producator: ".$arr_produse[$i]["nume_cat"]."</li>";		
		$item->description.="</ul>";
		$item->description.="Click pe titlu pentru mai multe detalii..";
		$item->link=getLinkProdus($arr_produse[$i]["link_cat"], $arr_produse[$i]["nume_produs"], $arr_produse[$i]["id_produs"]);
		
		  if($i>5)
		  	$item->pubDate=date("r", strtotime("-1 day"));
		  else $item->pubDate=date("r");
		  		
		  $rss_channel->items[] = $item;
	}
	
	$image= new rssGenerator_image();
	
	$image->description=NUME_FIRMA;
	$image->url=DIR_TEMPLATE."img/sigla.jpg";
	$image->link=URL_BASE;
	
	$rss_channel->image = $image;
	
	$rss_feed = new rssGenerator_rss();
	$rss_feed->encoding = 'UTF-8';
	$rss_feed->version = '2.0';
	
	header('Content-Type: text/xml');
	echo $rss_feed->createFeed($rss_channel); 
?>