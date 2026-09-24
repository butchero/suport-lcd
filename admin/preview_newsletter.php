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
	require_once("top.php");
	require_once("left.php");	
	require_once("../functii/f_admin.php");
	require_once("../functii/f_catalog.php");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@restrictionare acces pt subadmini
	restrictioneazaAccesSubadmini();
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/preview_newsletter.tpl";
		
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@titlu & text newsletter
	$arr_newsletter_header=arrayFromDB("*", "t_newsletter_header");
	$titlu_newsletter=$arr_newsletter_header[0]["titlu_newsletter"];
	$text_newsletter=$arr_newsletter_header[0]["text_newsletter"];
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@chilipirul zilei
	if(CHILIPIR)
	{
		$arr_chilipir=arrayFromDB(array("b.id_produs", "b.nume_produs",  "b.pret", "a.pret_curent", "a.pret_chilipir", "c.link_cat"),
								  "t_chilipirul_zilei AS a INNER JOIN t_produse AS b ON a.id_produs=b.id_produs 
								  						   LEFT JOIN t_categorii AS c ON b.id_cat=c.id_cat",
								  "WHERE a.data_chilipir='".date("Ymd")."'");

		if(count($arr_chilipir)==1)
		{			
			$smarty->assign("nume_chilipir", $arr_chilipir[0]["nume_produs"]);
			$smarty->assign("pret_chilipir", formateazaNr($arr_chilipir[0]["pret"]*TVA));
			$smarty->assign("pret_curent", formateazaNr($arr_chilipir[0]["pret_curent"]*TVA));
			$smarty->assign("poza_chilipir", getPozaPrincipalaProdus($arr_chilipir[0]["id_produs"]));
			$smarty->assign("link_chilipir", getLinkProdus($arr_chilipir[0]["link_cat"], $arr_chilipir[0]["nume_produs"], $arr_chilipir[0]["id_produs"]));
			
			//@calcul ore ramase pana expira oferta
			$timestamp1=strtotime(date("Ymd"));
			$timestamp2=time();
			
			$timp_expirare_chilipir=((($timestamp2-$timestamp1)/(60*60))*100)/24;
			
			$smarty->assign("timp_consumat", number_format($timp_expirare_chilipir, 0));
			$smarty->assign("timp_total", 100);
		}
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@produse newsletter
	$arr_newsletter=arrayFromDB(array("id_produs"), "t_newsletter_config", "ORDER BY id ASC");
	
	foreach($arr_newsletter as $key=>$value)
		$arr_id_produse_newsletter[]=$value["id_produs"];
	
	if(count($arr_newsletter)>0)
	{
		$sql_where="AND t_produse.id_produs IN (".implode(",", $arr_id_produse_newsletter).")";
		
		//---------------------------------------------------------------------------------------------------------------------------------
		//@select produse adaugate in newsletter
		$arr_produse_newsletter=arrayFromDB(array("id_produs",
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
									 		 "WHERE 1 ".$sql_where." ORDER BY t_produse.id_produs ASC");		
	}
	
	$nr_produse=count($arr_produse_newsletter);
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//LOOP PRODUSE AFLATE LA OFERTA SPECIALA
	for($i=0;$i<$nr_produse;$i++)
	{
		//---------------------------------------------------------------------------------------------------------------------------------
		//DETALII PRODUS
		
		//---------------------------------------------------------------------------------------------------------------------------------
		//@poza principala
		$adresa_poza=getPozaPrincipalaProdus($arr_produse_newsletter[$i]["id_produs"]);
		
		//---------------------------------------------------------------------------------------------------------------------------------
		//@poza producator
		$adresa_poza_producator=getPozaMicaProducator($arr_produse_newsletter[$i]["id_cat"]);		
										
		//---------------------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu toate detaliile produsului
		$arr_produse_newsletter_detalii[$i]=array("id_produs"=>$arr_produse_newsletter[$i]["id_produs"],										   
									   			  "nume_produs"=>stringLimit($arr_produse_newsletter[$i]["nume_produs"], 40),
									   			  "nume_producator"=>$arr_produse_newsletter[$i]["nume_cat"],
											      "adresa_poza_produs"=>$adresa_poza,
											      "adresa_poza_producator"=>$adresa_poza_producator,
											      "stoc"=>ucfirst($arr_stoc[$arr_produse_newsletter[$i]["stoc"]-1]["stoc"]),
										  	      "stoc_poza"=>$arr_stoc[$arr_produse_newsletter[$i]["stoc"]-1]["poza"],
											      "pret_produs"=>formateazaNr($arr_produse_newsletter[$i]["pret"]*TVA),
											      "pret_vechi"=>(!empty($arr_produse_newsletter[$i]["pret_vechi"]) && $arr_produse_newsletter[$i]["pret_vechi"]!=0)?formateazaNr($arr_produse_newsletter[$i]["pret_vechi"]*TVA):"",
											      "popup_js"=>$popup_js,
											      "link_produs"=>getLinkProdus($arr_produse_newsletter[$i]["link_cat"], $arr_produse_newsletter[$i]["nume_produs"], $arr_produse_newsletter[$i]["id_produs"]),
											      "link_cat"=>URL_BASE.$arr_produse_newsletter[$i]["link_cat"]);
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("URL_POZA", DIR_TEMPLATE."img/");
	$smarty->assign("URL_POZA_ADMIN", DIR_TEMPLATE."img_admin/");
	$smarty->assign("titlu_newsletter", $titlu_newsletter);
	$smarty->assign("text_newsletter", $text_newsletter);
	$smarty->assign("produse_newsletter", $arr_produse_newsletter_detalii);
	
	require_once("right.php");
	require_once("bottom.php");
?>