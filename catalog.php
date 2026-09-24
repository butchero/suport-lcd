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
	require_once("functii/f_links.php");
	require_once("clase/produsRating.php");

	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="catalog.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@vars
	$sql_where=array();
	$caracteristici_filtrari="";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@subcategoriile categoriei selectate/sau producatorii
	if(isset($_GET["cat"]))
	{
		if($este_producator)
			$arr_catalog=getSubcategoriiDupaProducator($id_cat, $link_cat);
		else 
			$arr_catalog=getSubcategorii($id_cat);
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@bannere categorii (afisarea se face random in functie de rata de aparitie)
	$arr_bannere_cat=arrayFromDB("*", "t_bannere_categorii", "WHERE id_cat='".$id_cat."' ORDER BY id_banner ASC");
	
	$nr_random=rand(0, 100);
	$limita_inferioara=0;
	
	//construiesc intervale in functie de rata de aparitie si verific numarul generat random de care interval apartine - do u have a better idea ?! :P
	foreach($arr_bannere_cat as $k=>$v)
	{
		if($nr_random>=$limita_inferioara && $nr_random<$limita_inferioara+$v["rata_aparitie"])
		{
			$banner_gasit=$k;
			
			//inlocuiesc nume fisier cu adresa completa, ca sa pot da direct assign in smarty si sa am si path-ul catre fisier in array
			$arr_bannere_cat[$k]["fisier"]=URL_BASE."bannere_cat/".$v["fisier"];
			
			break;
		}		
		$limita_inferioara+=$v["rata_aparitie"];				
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@link complet (cu filtrari, producatori, etc)
	$link_pagina=URL_BASE.$link_cat; // $link_cat e definit in left.php
	
	$link_pagina.=($_GET["show"]=="toate_produsele")?"toate-produsele":"";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@toate filtrele generale in afara de producatori
	if(isset($_GET["filtru"]))
		$filtru="/filtru/".$_GET["filtru"];	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@link in functie de tabul selectat + filtrare preturi care se concateneaza la sfarsitul link-ului (concatenarea se face direct in template)
	if(strpos($_SERVER["REQUEST_URI"], "?")!==false)
	{
		$uri=explode("?", $_SERVER["REQUEST_URI"]);
		
		if(strpos($uri[1], "|")!==false)
		{
			$uri_pieces=explode("|", $uri[1]);
			
			$_GET["tab_selectat"]=$uri_pieces[0];
			$url_limite_preturi=$uri_pieces[1];
			
			if(!empty($uri_pieces))
			{				
				if(!preg_match("/^(sub|peste|[0-9]+)-([0-9]+)$/", $url_limite_preturi, $limite_preturi))
				{
					die("Filtrare dupa pret incorecta!");
				}
				else
				{
					if(is_numeric($limite_preturi[1]) && is_numeric($limite_preturi[2]))
						$sql_where[]="AND pret * ".TVA." BETWEEN ".$limite_preturi[1]." AND ".$limite_preturi[2];
					elseif($limite_preturi[1]=="sub" && is_numeric($limite_preturi[2]))
						$sql_where[]="AND pret * ".TVA." <= ".$limite_preturi[2];
					elseif($limite_preturi[1]=="peste" && is_numeric($limite_preturi[2]))		
						$sql_where[]="AND pret * ".TVA." >= ".$limite_preturi[2];
				}
			}
		}
		else
		{
			$_GET["tab_selectat"]=$uri[1];
		}
	}

	if(isset($_GET["tab_selectat"]) && array_key_exists($_GET["tab_selectat"], $taburi))
	{
		$tab="?".$_GET["tab_selectat"].((!empty($url_limite_preturi))?"|".$url_limite_preturi:"");	
	}
	else
	{
		if(!empty($url_limite_preturi))
			$tab="?|".$url_limite_preturi;
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtre producatori
	require_once("filtre_producatori.php");
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtru(producatori)
	if(isset($_GET["prod"]))
	{		
		$arr_prod=arrayFromDB(array("id_cat", "link_cat", "nume_cat"), "t_categorii", "WHERE link_cat='".prepareStringToDB($_GET["prod"])."'");
		
		if(is_numeric($arr_prod[0]["id_cat"]))
		{
			$link_pagina.="/".$arr_prod[0]["link_cat"];
			$sql_where[]="AND id_prod='".$arr_prod[0]["id_cat"]."'";
			
			//@la array-ul filtre memorate se mai adauga si restul de filtre din filtre.php
			$filtre_memorate[0]=array("nume_filtru"=>"Producator",
									  "valoare_filtru"=>$arr_prod[0]["nume_cat"],
									  "link_filtru"=>str_replace("/".$_GET["prod"], "", $link_pagina).$filtru);			
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtru(taburi)
	if(isset($_GET["tab_selectat"]) && $_GET["tab_selectat"]=="noutati")
	{
		$sql_where[]="AND data_adaugarii > '".strtotime(ZILE_LIMIT." days ago")."'";
	}
	if(isset($_GET["tab_selectat"]) && $_GET["tab_selectat"]=="pe-stoc")
	{
		$sql_where[]="AND stoc='".$taburi["pe-stoc"]."'";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtru(sortari)
	if(($_GET["sort"]=="asc" || $_GET["sort"]=="desc") && in_array($_GET["col"], array_flip($sort_cols))) //$sort_cols e definita in configurare.php
	{
		$sql_sort="ORDER BY ".$sort_cols[$_GET["col"]]." ".$_GET["sort"];
		$link_sort="/sorteaza-".$_GET["col"]."-".$_GET["sort"];
	}
	elseif($_GET["tab_selectat"]=="noutati") $sql_sort="ORDER BY data_adaugarii DESC";	
	else $sql_sort="ORDER BY id_produs DESC";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@restul filtrelor
	require_once("filtre.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------		
	//@paginare
	require_once("clase/paginare.php");

	$paginare=new paginare("pag",
						   "SELECT COUNT(id_produs) AS nr FROM t_produse 
						    	WHERE ".(($_GET["show"]!="toate_produsele")?"t_produse.id_cat='".$id_cat."'":"1").
				   		   		      implode(" ", $sql_where)." ".
								      $caracteristici_filtrari,
						    $link_pagina.$link_sort."/p".PATTERN.$filtru.$tab);
	$paginare_string=$paginare->doPaginare(); //doPaginare() intoarce un string cu paginile, inainte/inapoi, pagina curenta selectata					    
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//PRODUSE
	if((is_numeric($id_cat) && !empty($id_cat)) || $_GET["show"]=="toate_produsele")
	{			
		//-----------------------------------------------------------------------------------------------------------------------------
		//@stoc
		$arr_stoc=getStocuri();
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@loop prin produse
		$arr_produse=arrayFromDB("*",
								 "t_produse",
								 "WHERE ".(($_GET["show"]!="toate_produsele")?"t_produse.id_cat='".$id_cat."'":"1").implode(" ", $sql_where)." ".$caracteristici_filtrari." ".$sql_sort.
								 " LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
		
		$nr_produse=count($arr_produse);
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//LOOP PRIN PRODUSE
		for($i=0;$i<$nr_produse;$i++)
		{
			//-------------------------------------------------------------------------------------------------------------------------
			//DETALII PRODUS
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@poza principala						
			$adresa_poza=getPozaPrincipalaProdus($arr_produse[$i]["id_produs"]);
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@poza producator
			$adresa_poza_producator=getPozaMicaProducator($arr_produse[$i]["id_prod"]);				
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@caracteristici
			unset($caracteristici);
			$val_carac=explode(";", $arr_produse[$i]["caracteristici"]);

			for($j=0;$j<$nr_filtre;$j++)
			{
				if($arr_filtre[$j]["afiseaza_filtru"]==1)
				{
					$caracteristici[]=array("nume_carac"=>$arr_filtre[$j]["nume_filtru"],
											"val_carac"=>(empty($val_carac[$j+1]))?"-":$val_carac[$j+1],
											"nr_ordine"=>$arr_filtre[$j]["nr_ordine"]);
				}
			}
			
			//-------------------------------------------------------------------------------------------------------------------------
			//sortare caracteristici dupa nr_ordine
			if(count($caracteristici)>0)
			{
				foreach($caracteristici as $key=>$value)			
					$arr_nr_ordine[$key]=$value["nr_ordine"];
				
				array_multisort($arr_nr_ordine, SORT_ASC, $caracteristici);	
			}
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@galerie produs			
			unset($poze_sec_mici, $poze_sec_medii);
			
			$arr_galerie=genereazaGalerie($arr_produse[$i]["id_produs"]);
			$poze_sec_mici=$arr_galerie["mici"];
			$poze_sec_medii=$arr_galerie["medii"];
			$poze_sec_mari=$arr_galerie["mari"];			
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@convertor valutar
			$popup_js=getConvertorValutar($arr_produse[$i]["pret"]);
									
			//-------------------------------------------------------------------------------------------------------------------------
			//@rating produs
			$rating=new produsRating($arr_produse[$i]["id_produs"]);
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@categorii secundare asociate produsului
			(CAT_SECUNDARE)?$arr_cat_sec=getCategoriiSecundare($arr_produse[$i]["id_produs"]):"";
											
			//-------------------------------------------------------------------------------------------------------------------------
			//@array asociativ cu toate detaliile produsului
			$arr_produse_detalii[$i]=array("id_produs"=>$arr_produse[$i]["id_produs"],										   
										   "nume_produs"=>$arr_produse[$i]["nume_produs"],
										   "adresa_poza_produs"=>$adresa_poza,
										   "adresa_poza_producator"=>$adresa_poza_producator,
										   "stoc"=>ucfirst($arr_stoc[$arr_produse[$i]["stoc"]]),
								  		   "id_stoc"=>$arr_produse[$i]["stoc"],
										   "tip"=>$arr_produse[$i]["tip"],
										   "poze_sec_mici"=>$poze_sec_mici,
										   "poze_sec_medii"=>$poze_sec_medii,
										   "poze_sec_mari"=>$poze_sec_mari,
										   "pret_produs"=>formateazaNr($arr_produse[$i]["pret"]*TVA),
										   "pret_vechi"=>(!empty($arr_produse[$i]["pret_vechi"]) && $arr_produse[$i]["pret_vechi"]!=0)?formateazaNr($arr_produse[$i]["pret_vechi"]*TVA):"",
										   "reducere"=>calculeazaReducere($arr_produse[$i]["pret_vechi"]*TVA, $arr_produse[$i]["pret"]*TVA),
										   "popup_js"=>$popup_js,
										   "link_produs"=>getLinkProdus($link_cat, $arr_produse[$i]["nume_produs"], $arr_produse[$i]["id_produs"]),
										   "caracteristici"=>$caracteristici,
										   "producator"=>$toti_producatorii[$arr_produse[$i]["id_prod"]],
										   "link_producator"=>$toti_producatorii_links[$arr_produse[$i]["id_prod"]],
										   "rating"=>array("1"=>round($rating->getRating()), "2"=>RATING_MAX-round($rating->getRating())),
										   "nr_comentarii"=>$rating->getNrComentarii(),
										   "cat_sec"=>$arr_cat_sec,
										   "nr_cat_sec"=>count($arr_cat_sec),
										   "border"=>($i>0 && $i%2!=0)?1:0);
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@header 404 daca in urma fitrarilor nu s-a obtinut nici un rezultat
	if(isset($_GET["filtru"]) && $nr_produse==0)
	{
		header("HTTP/1.0 404 Not Found");
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtre preturi
	require_once("filtre_preturi.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@banner cat
	$smarty->assign("banner_cat", $arr_bannere_cat[$banner_gasit]);
	
	//@taburi
	$smarty->assign("link_toate_produsele", URL_BASE.$link_cat);
	$smarty->assign("link_noutati", URL_BASE.$link_cat."?noutati");
	$smarty->assign("link_tab_1", URL_BASE.$link_cat."?pe-stoc");
	
	//@sortari
	$smarty->assign("link_sort_dupa_pret_asc", $link_pagina."/sorteaza-pret-asc".$filtru);
	$smarty->assign("link_sort_dupa_pret_desc", $link_pagina."/sorteaza-pret-desc".$filtru);
	$smarty->assign("link_sort_dupa_produs_asc", $link_pagina."/sorteaza-produs-asc".$filtru);
	$smarty->assign("link_sort_dupa_produs_desc", $link_pagina."/sorteaza-produs-desc".$filtru);
	
	//@afisare menu center (subcategoriile categoriei selectate/sau producatorii)
	$smarty->assign("catalog", $arr_catalog);

	//@ valori posibile: 0 sau 1, folosesc variabila aceasta pt a nu mai afisa taburile de produse in caz ca nu sunt produse in categorie
	$smarty->assign("afiseaza_caseta_produse", ($nr_produse==0 && !isset($_GET["filtru"]) && !isset($_GET["prod"]) && !isset($_GET["tab_selectat"]))?0:1); 
	
	//@filtre preturi
	$smarty->assign("filtre_preturi", $filtre_preturi);
	
	//@link tab
	$smarty->assign("tab", $tab);
	
	//@afisare filtru producatori					 
	$smarty->assign("filtru_producatori", $filtru_producatori);	
	
	//@afisare restul filtrelor
	$smarty->assign("filtre", $filtre);	
	
	//@afisare filtre memorate
	$smarty->assign("filtre_memorate", $filtre_memorate);
	
	//@stergere filtre memorate		
	$smarty->assign("filtre_stergere", $filtre_stergere);
		
	//@taburi
	$smarty->assign("tab_selectat", (isset($_GET["tab_selectat"]) && array_key_exists($_GET["tab_selectat"], $taburi))?$_GET["tab_selectat"]:"");
	
	//@afisare produse
	$smarty->assign("produse", $arr_produse_detalii);	
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	//@id categorie
	$smarty->assign("id_cat", $id_cat);
	
	require_once("right.php");
	require_once("bottom.php");
?>