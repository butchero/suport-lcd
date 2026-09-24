<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2008       		   **
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
	$display_page="cautare.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@string cautare - clean up
	$cautare_string=curataSpatiiAlbe(trim(read_Link($_GET["string"])));

	//---------------------------------------------------------------------------------------------------------------------------------
	//@verificare
	if(strlen($cautare_string)<3)
		die("Cautarea se face dupa minim 3 caractere !");
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina=$cautare_string;	

	$arr_cautare_string=explode(" ", $cautare_string);
	$nr_pieces=count($arr_cautare_string);
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@sql cautare
	$sql="SELECT id_produs, t_produse.id_cat, id_prod, nume_produs, t_categorii.nume_cat, t_categorii.link_cat, pret, pret_vechi, descriere_produs, caracteristici, data_adaugarii, stoc, tip,
				 MATCH(nume_produs,descriere_produs,caracteristici) AGAINST ('".prepareStringToDB($cautare_string)."') AS score
		   			FROM t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat	
		   				WHERE MATCH(nume_produs,descriere_produs,caracteristici) AGAINST ('".prepareStringToDB($cautare_string)."')";			
	
	//---------------------------------------------------------------------------------------------------------------------------------		
	//@paginare
	require_once("clase/paginare.php");
	
	$paginare=new paginare("pag", $sql, URL_BASE."cautare/".prepareLink($_GET["string"])."/p".PATTERN, AFISARI_PE_PAG, true); 
	$paginare_string=$paginare->doPaginare(); 				    

	//---------------------------------------------------------------------------------------------------------------------------------
	$result=mysql_query($sql." LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	//@patch ca sa nu scriu totul din nou, o sa incetineasca un pic - luat din arrayFromDB, nu am folosit arrayFromDB pt ca nu fost gandita pt UNION
	$i=0;			
	while($row=mysql_fetch_array($result))
	{		
		//@loop prin campurile selectate si atribuire valori din bd
		foreach($row as $key=>$value)
		{
			$arr_produse[$i][$key]=prepareStringFromDB($value);
		}
		$i++;
	}	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@stoc
	$arr_stoc=getStocuri();
	
	//@numarul de produse
	$nr_produse=count($arr_produse);
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@salvez cautarea/incrementez contorul daca s-a mai cautat o data
	$arr_cautare=arrayFromDB(array("COUNT(id_cautare) AS nr", "id_cautare"),
							 "t_cautari",
							 "WHERE cautare='".prepareStringToDB($cautare_string)."' GROUP BY id_cautare");
	
	if($nr_produse>0)
	{
		if($arr_cautare[0]["nr"]==0)
			arrayInsertToDB("t_cautari", array("cautare"), array($cautare_string));
		else 
			arrayUpdateToDB("t_cautari", array("contor"), array("contor+1"), array("id"=>"id_cautare", "valoare"=>$arr_cautare[0]["id_cautare"]), true);
	}	

	//---------------------------------------------------------------------------------------------------------------------------------
	//LOOP PRIN PRODUSE
	for($i=0;$i<$nr_produse;$i++)
	{
		//-----------------------------------------------------------------------------------------------------------------------------
		//DETALII PRODUS
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@parintii nodului (categoriei din care face produsul)
		$parinti_cat_produs=new parintiNod();
		$arr_parinti_cat_produs=$parinti_cat_produs->getParinti($arr_produse[$i]["id_cat"]);

		unset($arr_categorii_produs);
		
		if(is_array($arr_parinti_cat_produs))
		{
			foreach($arr_parinti_cat_produs as $key=>$value)
			{
				$arr_cat_parinte=arrayFromDB(array("id_cat", "nume_cat", "link_cat"), "t_categorii", "WHERE id_cat='".$value."'");
				$arr_categorii_produs[]=array("link_cat"=>URL_BASE.strtolower($arr_cat_parinte[0]["link_cat"]), "nume_cat"=>$arr_cat_parinte[0]["nume_cat"]);
			}			
		}
		$arr_categorii_produs[]=array("link_cat"=>URL_BASE.strtolower($arr_produse[$i]["link_cat"]), "nume_cat"=>$arr_produse[$i]["nume_cat"]);
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@poza principala						
		$adresa_poza=getPozaPrincipalaProdus($arr_produse[$i]["id_produs"]);
		
		//@poza producator
		$adresa_poza_producator=getPozaMicaProducator($arr_produse[$i]["id_prod"]);				
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@filtre
		$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat=".$arr_produse[$i]["id_cat"]." AND afiseaza_filtru='1' ORDER BY id_filtru ASC"); 
		$nr_filtre=count($arr_filtre);
		
		for($j=0;$j<$nr_filtre;$j++)
		{
			$filtre[$j]=array("id_filtru"=>$arr_filtre[$j]["id_filtru"],
							  "nume_filtru"=>$arr_filtre[$j]["nume_filtru"]);			  							  											  
		}
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@caracteristici
		unset($caracteristici);
		$val_carac=explode(";", $arr_produse[$i]["caracteristici"]);
		
		for($j=0;$j<$nr_filtre;$j++)
		{
			$caracteristici[$j]=array("nume_carac"=>$arr_filtre[$j]["nume_filtru"],
									  "val_carac"=>(empty($val_carac[$j+1]))?"-":$val_carac[$j+1]);
		}
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@galerie produs			
		unset($poze_sec_mici, $poze_sec_medii);
		
		$arr_galerie=genereazaGalerie($arr_produse[$i]["id_produs"]);
		$poze_sec_mici=$arr_galerie["mici"];
		$poze_sec_medii=$arr_galerie["medii"];			
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@convertor valutar
		$popup_js=getConvertorValutar($arr_produse[$i]["pret"]);
								
		//-----------------------------------------------------------------------------------------------------------------------------
		//@rating produs
		$rating=new produsRating($arr_produse[$i]["id_produs"]);
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@producator
		$arr_producator=arrayFromDB(array("nume_cat"), "t_categorii", "WHERE id_cat='".$arr_produse[$i]["id_prod"]."'");
		
		//-------------------------------------------------------------------------------------------------------------------------
		//@categorii secundare asociate produsului
		(CAT_SECUNDARE)?$arr_cat_sec=getCategoriiSecundare($arr_produse[$i]["id_produs"]):"";
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu toate detaliile produsului
		$arr_produse_detalii[$i]=array("id_produs"=>$arr_produse[$i]["id_produs"],										   
									   "id_cat"=>$arr_produse[$i]["id_cat"],
									   "nume_produs"=>highlight($arr_produse[$i]["nume_produs"], $arr_cautare_string),
									   "adresa_poza_produs"=>$adresa_poza,
									   "adresa_poza_producator"=>$adresa_poza_producator,
									   "stoc"=>ucfirst($arr_stoc[$arr_produse[$i]["stoc"]]),
								  	   "id_stoc"=>$arr_produse[$i]["stoc"],
									   "tip"=>$arr_produse[$i]["tip"],
									   "poze_sec_mici"=>$poze_sec_mici,
									   "poze_sec_medii"=>$poze_sec_medii,
									   "pret_produs"=>formateazaNr($arr_produse[$i]["pret"]*TVA),
									   "pret_vechi"=>(!empty($arr_produse[$i]["pret_vechi"]) && $arr_produse[$i]["pret_vechi"]!=0)?formateazaNr($arr_produse[$i]["pret_vechi"]*TVA):"",
									   "popup_js"=>$popup_js,
									   "link_produs"=>getLinkProdus($arr_produse[$i]["link_cat"], $arr_produse[$i]["nume_produs"], $arr_produse[$i]["id_produs"]),
									   "caracteristici"=>$caracteristici,
									   "producator"=>$arr_producator[0]["nume_cat"],
									   "rating"=>array("1"=>round($rating->getRating()), "2"=>RATING_MAX-round($rating->getRating())),
									   "nr_comentarii"=>$rating->getNrComentarii(),
									   "radacina_produs"=>$arr_categorii_produs,
									   "cat_sec"=>$arr_cat_sec,
									   "nr_cat_sec"=>count($arr_cat_sec));
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY

	//@string cautat
	$smarty->assign("cautare_string", prepareStringFromDB($cautare_string));
	
	//@afisare menu center (subcategoriile categoriei selectate/sau producatorii)
	$smarty->assign("catalog", $arr_catalog);	
			
	//@afisare produse
	$smarty->assign("produse", $arr_produse_detalii);	
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	//@id categorie
	$smarty->assign("id_cat", $id_cat);
	
	require_once("right.php");
	require_once("bottom.php");
?>