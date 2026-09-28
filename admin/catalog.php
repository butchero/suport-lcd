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
	require_once("../functii/f_catalog.php");
	require_once("../functii/f_links.php");
	require_once("../clase/produsRating.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="admin/catalog.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@link inapoi pt restul paginilor
	$_SESSION["link_inapoi"]=$_SERVER["REQUEST_URI"];
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@vars
	$id_ordonare=3;
	
	$arr_combo_ordonari=array(0=>"Pret ASC", 1=>"Pret DESC", 2=>"Data ASC", 3=>"Data DESC");
	$arr_sql_order=array(0=>"pret ASC", 1=>"pret DESC", 2=>"id_produs ASC", 3=>"id_produs DESC");
	
	$sql_where=array();
	$url_paginare="";
	$arr_catalog=array();
	$arr_produse_detalii=array();
	$mesaj="";
	$id_prod=isset($id_prod) ? $id_prod : "";
	$cod_produs=isset($cod_produs) ? $cod_produs : "";
	$nume_cat=isset($nume_cat) ? $nume_cat : "";
	$edit=isset($_GET["edit"]) ? $_GET["edit"] : "";
	$caracteristici_filtrari=array();
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@subcategoriile categoriei selectate/sau producatorii
	if(isset($_GET["cat"]))
	{
		if($este_producator)
			$arr_catalog=getSubcategoriiDupaProducator($id_cat, $link_cat, false);
		else 
			$arr_catalog=getSubcategorii($id_cat, true, "nr_ordine", "", false);	
	}
	else 
	{
		if($edit=="categorii_principale")
		{
			$arr_catalog=getSubcategorii($id_cat, true, "nr_ordine", "AND producator='0'", false);	
		}
		elseif($edit=="producatori")			
		{
			$arr_catalog=getTotiProducatorii();			
		}
	}
			
	//---------------------------------------------------------------------------------------------------------------------------------
	//@nr produse efectiv din categoria selectata (nu folosesc "nr_produse" incrementat in t_categorii deoarece acesta reprezinta nr total de produse, inclusiv din copii)
	$arr_nr_produse=arrayFromDB(array("COUNT(id_produs) AS nr"), "t_produse", "WHERE id_cat='".$id_cat."'");
	
	//@daca nr_produse_cat=0 nu mai afisez in catalog filtrari, taburi, ordonari produse dupa pret, nume, etc
	$nr_produse_cat=$arr_nr_produse[0]["nr"]; 
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtre producatori
	if(!isset($link_pagina))
		$link_pagina=URL_ADMIN."catalog.php?cat=".$id_cat;
	require_once("../filtre_producatori.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@restul filtrelor
	require_once("../filtre.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------		
	//@filtrare produse
	if(isset($_REQUEST["producator"]) && is_numeric($_REQUEST["producator"]) && !empty($_REQUEST["producator"]))
	{		
		$id_prod=$_REQUEST["producator"];
		
		$sql_where[]="AND id_prod='".$id_prod."'";
		$url_paginare="&producator=".$id_prod;
	}
	if(isset($_REQUEST["ordonare"]) && is_numeric($_REQUEST["ordonare"]))
	{
		$id_ordonare=$_REQUEST["ordonare"];
		$url_paginare.="&ordonare=".$id_ordonare;
	}
	if(isset($_REQUEST["cod_produs"]) && !empty($_REQUEST["cod_produs"]))
	{
		$cod_produs=$_REQUEST["cod_produs"];
		
		$sql_where[]="AND cod_produs LIKE '%".prepareStringToDB($cod_produs)."%'";
		$url_paginare="&cod_produs=".$cod_produs;
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------		
	//@paginare
	require_once("../clase/paginare.php");
	
	$paginare=new paginare("pag", //numele variabilei care vin prin get: $_GET["pag"]
						   "SELECT COUNT(id_produs) AS nr FROM t_produse WHERE id_cat='".$id_cat."' ".implode(" ", $sql_where), //sql-ul care determina nr de linii
						    URL_ADMIN."catalog.php?cat=".$id_cat.$url_paginare."&pag=".PATTERN); //link-ul in care se face replace la pattern cu pagina
	$paginare_string=$paginare->doPaginare(); //doPaginare() intoarce un string cu paginile, inainte/inapoi, pagina curenta selectata					    
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@produse
	if(is_numeric($id_cat) && !empty($id_cat))
	{			
		$arr_produse=arrayFromDB(array("t_produse.id_produs",
									   "t_newsletter_config.id_produs AS id_produs_newsletter",
									   "t_produse.id_cat",
									   "id_prod",
									   "cod_produs",
									   "nume_produs",									   
									   "pret",
									   "pret_vechi",
									   "descriere_produs",
									   "caracteristici",
									   "data_adaugarii",
									   "stoc",
									   "tip",
									   "username"),
								 "t_produse LEFT JOIN t_admin ON t_produse.id_admin=t_admin.id_admin 
								 			LEFT JOIN t_newsletter_config ON t_produse.id_produs=t_newsletter_config.id_produs",
								 "WHERE t_produse.id_cat='".$id_cat."' ".implode(" ", $sql_where)." ORDER BY ".$arr_sql_order[$id_ordonare]." LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
		
		$nr_produse=count($arr_produse);
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@stoc
		$arr_stoc=getStocuri();
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//LOOP PRIN PRODUSE
		for($i=0;$i<$nr_produse;$i++)
		{
			//-------------------------------------------------------------------------------------------------------------------------
			//@detalii produs
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@poza principala						
			$adresa_poza=getPozaPrincipalaProdus($arr_produse[$i]["id_produs"]);
			
			//@poza producator
			$adresa_poza_producator=getPozaMicaProducator($arr_produse[$i]["id_prod"]);				
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@caracteristici
			$caracteristici=array();
			$val_carac=explode(";", $arr_produse[$i]["caracteristici"]);
			
			for($j=0;$j<$nr_filtre;$j++)
			{
				if($arr_filtre[$j]["afiseaza_filtru"]==1)
				{
					$caracteristici[]=array("nume_carac"=>$arr_filtre[$j]["nume_filtru"],
											"val_carac"=>(empty($val_carac[$j+1]))?"-":$val_carac[$j+1]);
				}
			}
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@galerie produs					
			unset($poze_sec_mici, $poze_sec_medii);
			
			$arr_galerie=genereazaGalerie($arr_produse[$i]["id_produs"]);
			$poze_sec_mici=$arr_galerie["mici"];
			$poze_sec_medii=$arr_galerie["medii"];
			$poze_sec_mari=$arr_galerie["mari"];			
					
			//-------------------------------------------------------------------------------------------------------------------------
			//@rating produs
			$rating=new produsRating($arr_produse[$i]["id_produs"]);
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@categorii secundare asociate produsului
			$arr_cat_sec=(CAT_SECUNDARE)?getCategoriiSecundare($arr_produse[$i]["id_produs"]):array();
			if(!is_array($arr_cat_sec))
				$arr_cat_sec=array();
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@array asociativ cu toate detaliile produsului
			$arr_produse_detalii[$i]=array("id_produs"=>$arr_produse[$i]["id_produs"],	
										   "cod_produs"=>$arr_produse[$i]["cod_produs"],									   
										   "nume_produs"=>$arr_produse[$i]["nume_produs"],
										   "nume_produs_js"=>htmlspecialchars(str_replace("'", "\\'", $arr_produse[$i]["nume_produs"])),										   
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
										   "link_produs"=>getLinkProdus($link_cat, $arr_produse[$i]["nume_produs"], $arr_produse[$i]["id_produs"]),
										   "caracteristici"=>$caracteristici,
										   "producator"=>(isset($toti_producatorii[$arr_produse[$i]["id_prod"]]) ? $toti_producatorii[$arr_produse[$i]["id_prod"]] : ""),
										   "rating"=>array("1"=>round($rating->getRating()), "2"=>RATING_MAX-round($rating->getRating())),
										   "nr_comentarii"=>$rating->getNrComentarii(),
										   "username"=>$arr_produse[$i]["username"],
										   "id_produs_newsletter"=>$arr_produse[$i]["id_produs_newsletter"],
										   "cat_sec"=>$arr_cat_sec);
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@producator selectat
	$smarty->assign("id_prod", $id_prod);
	
	//@filtru producatori
	$smarty->assign("toti_producatorii", $toti_producatorii);
	
	//@ordonarea selectata
	$smarty->assign("id_ordonare", $id_ordonare);
	
	//@combo ordonari
	$smarty->assign("combo_ordonari", $arr_combo_ordonari);
	
	//@cod produs
	$smarty->assign("cod_produs", $cod_produs);
	
	//@afisare menu center (subcategoriile categoriei selectate/sau producatorii)
	$smarty->assign("catalog", $arr_catalog);

	//@nr produse
	$smarty->assign("nr_produse_cat", $nr_produse_cat);
		
	//@afisare produse
	$smarty->assign("produse", $arr_produse_detalii);	
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	//@id categorie
	$smarty->assign("nume_cat", $nume_cat);
	
	//@id categorie
	$smarty->assign("id_cat", $id_cat);
	
	//@timestamp pt poze sa nu le ia din cache
	$smarty->assign("timestamp", time());
	
	//@edit=categorii sau producatori
	$smarty->assign("edit", $edit);
	
	//@mesaje de stergere a unei categorii, producator sau produs
	if(isset($_GET["cat_stearsa"]) && $_GET["cat_stearsa"]=="true")
	{
		if($edit=="producatori")
			$mesaj="Producatorul a fost sters cu succes!";
		else
			$mesaj="Categoria, subcategoriile si produsele continute au fost sterse cu succes!";
	}
	elseif(isset($_GET["cat_stearsa"]) && $_GET["cat_stearsa"]=="false") 
		$mesaj="Categoria nu a putut fi stearsa!";
	
	if(isset($_GET["produs_sters"]) && $_GET["produs_sters"]=="true")
		$mesaj="Produsul a fost sters cu succes!";
	elseif(isset($_GET["produs_sters"]) && $_GET["produs_sters"]=="false")
		$mesaj="Produsul nu a putut fi sters!";	
	
	//@mesaj pentru confirmarea stergerii unei categorii
	$smarty->assign("mesaj", $mesaj);
	
	require_once("right.php");
	require_once("bottom.php");
?>