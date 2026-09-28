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
	require_once("functii/f_catalog.php");
	require_once("clase/produsRating.php");
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="index.tpl";

	//-----------------------------------------------------------------------------------------------------------------------------
	//@bannere prima pagina
	$arr_bannere=arrayFromDB("*", "t_bannere", "ORDER BY nr_ordine ASC");
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//@texte prima pagina
	$arr_texte=arrayFromDB("*", "t_texte_site", "WHERE sectiune='despre_noi'");
	$text_despre_noi=$arr_texte[0]["text"];
	
	$arr_texte=arrayFromDB("*", "t_texte_site", "WHERE sectiune='contact'");
	$text_contact=$arr_texte[0]["text"];
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//@stoc (array asociativ care il folosesc la detalii produs pt a afla poza stoc si starea stocului)
	$arr_stoc=arrayFromDB("*", "t_stoc", "ORDER BY id_stoc ASC");
		
	//-----------------------------------------------------------------------------------------------------------------------------
	//@categorii secundare
	if(CAT_SECUNDARE && file_exists(URL_BASE_ABS."module_secundare/categorii_secundare.php"))
	{
		require(URL_BASE_ABS."module_secundare/categorii_secundare.php");
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//@select produse aflate la oferta speciala
	$arr_produse_speciale=arrayFromDB("*",
									  "t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
							 		  "WHERE t_produse.tip='1' AND t_categorii.activ='1' ORDER BY id_produs DESC LIMIT 0, ".AFISARI_OFERTE_SPECIALE);		
	
	$nr_produse=count($arr_produse_speciale);
	$arr_produse_speciale_detalii=array();
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//LOOP PRODUSE AFLATE LA OFERTA SPECIALA
	for($i=0;$i<$nr_produse;$i++)
	{
		//-------------------------------------------------------------------------------------------------------------------------
		//@detalii produs
		
		//--------------------------------------------------------------------------------------------------------------------------
		//@poza principala
		$adresa_poza=getPozaPrincipalaProdus($arr_produse_speciale[$i]["id_produs"]);
		
		//@poza producator
		$adresa_poza_producator=getPozaMicaProducator($arr_produse_speciale[$i]["id_prod"]);		
		
		//--------------------------------------------------------------------------------------------------------------------------
		//@convertor valutar
		$popup_js=getConvertorValutar($arr_produse_speciale[$i]["pret"]);
										
		//--------------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu toate detaliile produsului
		$arr_produse_speciale_detalii[$i]=array("id_produs"=>$arr_produse_speciale[$i]["id_produs"],										   
									   			"nume_produs"=>stringLimit($arr_produse_speciale[$i]["nume_produs"], 80),
									   			"nume_producator"=>(isset($toti_producatorii[$arr_produse_speciale[$i]["id_prod"]]) ? $toti_producatorii[$arr_produse_speciale[$i]["id_prod"]] : ""),
											    "adresa_poza_produs"=>$adresa_poza,
											    "adresa_poza_producator"=>$adresa_poza_producator,
											    "stoc"=>ucfirst(isset($arr_stoc[$arr_produse_speciale[$i]["stoc"]-1]["stoc"]) ? $arr_stoc[$arr_produse_speciale[$i]["stoc"]-1]["stoc"] : ""),
										  	    "stoc_poza"=>(isset($arr_stoc[$arr_produse_speciale[$i]["stoc"]-1]["poza"]) ? $arr_stoc[$arr_produse_speciale[$i]["stoc"]-1]["poza"] : ""),
											    "pret_produs"=>formateazaNr($arr_produse_speciale[$i]["pret"]*TVA),
											    "pret_vechi"=>(!empty($arr_produse_speciale[$i]["pret_vechi"]) && $arr_produse_speciale[$i]["pret_vechi"]!=0)?formateazaNr($arr_produse_speciale[$i]["pret_vechi"]*TVA):"",
											    "reducere"=>calculeazaReducere($arr_produse_speciale[$i]["pret_vechi"]*TVA, $arr_produse_speciale[$i]["pret"]*TVA),
											    "popup_js"=>$popup_js,
											    "link_produs"=>getLinkProdus($arr_produse_speciale[$i]["link_cat"], $arr_produse_speciale[$i]["nume_produs"], $arr_produse_speciale[$i]["id_produs"]),
											    "link_cat"=>URL_BASE.$arr_produse_speciale[$i]["link_cat"]);											    
	}
	
	//*****************************************************************************************************************************
	//@Note: e copy paste la cod - ar tb rescris pe viitor folosind o clasa pt detalii produs
	//-----------------------------------------------------------------------------------------------------------------------------
	//@select ultimele produsea adaugate
	$arr_produse=arrayFromDB("*",
							 "t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
							 "WHERE t_produse.tip='0' AND t_categorii.activ='1' ORDER BY id_produs DESC LIMIT 0, ".AFISARI_ULTIMELE_PRODUSE_ADAUGATE);		
	
	$nr_produse=count($arr_produse);
	$arr_produse_detalii=array();
	
	//------------------------------------------------------------------------------------------------------------------------------
	//LOOP PRIN ULTIMELE PRODUSE ADAUGATE
	for($i=0;$i<$nr_produse;$i++)
	{
		//--------------------------------------------------------------------------------------------------------------------------
		//@detalii produs
			
		//--------------------------------------------------------------------------------------------------------------------------
		//@poza principala
		$adresa_poza=getPozaPrincipalaProdus($arr_produse[$i]["id_produs"]);
		
		//@poza producator
		$adresa_poza_producator=getPozaMicaProducator($arr_produse[$i]["id_prod"]);				
		
		//--------------------------------------------------------------------------------------------------------------------------
		//@convertor valutar
		$popup_js=getConvertorValutar($arr_produse[$i]["pret"]);		
		
		//--------------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu toate detaliile produsului
		$arr_produse_detalii[$i]=array("id_produs"=>$arr_produse[$i]["id_produs"],										   
									   "nume_produs"=>stringLimit($arr_produse[$i]["nume_produs"], 80),
									   "nume_producator"=>(isset($toti_producatorii[$arr_produse[$i]["id_prod"]]) ? $toti_producatorii[$arr_produse[$i]["id_prod"]] : ""),
									   "adresa_poza_produs"=>$adresa_poza,
									   "adresa_poza_producator"=>$adresa_poza_producator,
									   "stoc"=>ucfirst(isset($arr_stoc[$arr_produse[$i]["stoc"]-1]["stoc"]) ? $arr_stoc[$arr_produse[$i]["stoc"]-1]["stoc"] : ""),
								  	   "stoc_poza"=>(isset($arr_stoc[$arr_produse[$i]["stoc"]-1]["poza"]) ? $arr_stoc[$arr_produse[$i]["stoc"]-1]["poza"] : ""),
									   "pret_produs"=>formateazaNr($arr_produse[$i]["pret"]*TVA),
									   "pret_vechi"=>(!empty($arr_produse[$i]["pret_vechi"]) && $arr_produse[$i]["pret_vechi"]!=0)?formateazaNr($arr_produse[$i]["pret_vechi"]*TVA):"",
									   "reducere"=>calculeazaReducere($arr_produse[$i]["pret_vechi"], $arr_produse[$i]["pret"]),
									   "popup_js"=>$popup_js,
									   "link_produs"=>getLinkProdus($arr_produse[$i]["link_cat"], $arr_produse[$i]["nume_produs"], $arr_produse[$i]["id_produs"]),
									   "link_cat"=>URL_BASE.$arr_produse[$i]["link_cat"]);
	}
		
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	
	//@bannere prima pagina
	$smarty->assign("nr_bannere", count($arr_bannere));
	$smarty->assign("bannere", $arr_bannere);
	
	//@texte prima pagina
	$smarty->assign("text_despre_noi", $text_despre_noi);
	$smarty->assign("text_contact", $text_contact);
	
	//@afisare produse
	$smarty->assign("produse", $arr_produse_detalii);
	
	//@afisare produse
	$smarty->assign("produse_speciale", $arr_produse_speciale_detalii);
	
	//@afisare oferta speciala (pe coloana left sau right)
	$smarty->assign("afiseaza_box_oferte_speciale", 1); //0=false

	//@var pt a sti ca sunt pe index.php
	$smarty->assign("prima_pag", 1);
	
	require_once("right.php");
	require_once("bottom.php");
?>