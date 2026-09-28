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
	//@string cautare - clean up
	$cautare_string=(isset($_GET["string"]))?curataSpatiiAlbe(trim(read_Link($_GET["string"]))):"";
	$arr_produse=array();
	$arr_produse_detalii=array();
	$arr_catalog=array();

	//---------------------------------------------------------------------------------------------------------------------------------
	//@verificare
	//if(strlen($cautare_string)<3)
		//die("Cautarea se face dupa minim 3 caractere !");
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina=$cautare_string;	

	//---------------------------------------------------------------------------------------------------------------------------------
	//@similitudini
	//$arr_categorii_sim=arrayFromDB("*", "t_categorii", "WHERE nume_cat SOUNDS LIKE('".$cautare_string."') AND producator='0'");
	//$arr_producatori_sim=arrayFromDB("*", "t_categorii", "WHERE nume_cat SOUNDS LIKE('".$cautare_string."') AND producator='1'");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@construiesc sql cautare	- imbarligat si primitiv pentru a obtine relevanta - pe viitor trebuie sa studiez cautarea BOOLEANA
	$arr_cautare_string=explode(" ", $cautare_string);
	$nr_pieces=count($arr_cautare_string);
	
	//@titlu: fiecare cuvant; cod produs: EAN-ul introdus (cu sau fara spatii)
	$sql_where="activ=1";
	$este_lista_completa=(isset($_GET["show"]) && $_GET["show"]=="toate_produsele");

	if($cautare_string!="" && !$este_lista_completa)
	{
		$sql_titlu=array();
		for($i=0;$i<$nr_pieces;$i++)
		{
			if($arr_cautare_string[$i]==="")
				continue;
			$sql_titlu[]="nume_produs LIKE '%".prepareStringToDB($arr_cautare_string[$i])."%'";
		}

		$sql_match=array();
		if(count($sql_titlu)>0)
			$sql_match[]="(".implode(" AND ", $sql_titlu).")";

		$cod_cautat=preg_replace("/\s+/", "", $cautare_string);
		if($cod_cautat!=="")
			$sql_match[]="cod_produs LIKE '%".prepareStringToDB($cod_cautat)."%'";

		if(count($sql_match)>0)
			$sql_where.=" AND (".implode(" OR ", $sql_match).")";

		$arr_radacina=array(array("nume_radacina"=>"Cautare: ".$cautare_string,
								  "link_radacina"=>URL_BASE."cautare/".prepareLink($cautare_string)));
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	$sql="SELECT id_produs, t_produse.id_cat, id_prod, nume_produs, t_categorii.nume_cat, t_categorii.link_cat, pret, pret_vechi, descriere_produs, caracteristici, data_adaugarii, stoc, tip
		   	FROM t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat WHERE ".$sql_where." ORDER BY id_produs DESC"; 
				
	
	//---------------------------------------------------------------------------------------------------------------------------------		
	//@paginare
	require_once("clase/paginare.php");
	
	$paginare=new paginare("pag", $sql, URL_BASE.((isset($_GET["show"]) && $_GET["show"]=="toate_produsele")?"toate-produsele":"cautare/".prepareLink(isset($_GET["string"]) ? $_GET["string"] : ""))."/p".PATTERN, AFISARI_PE_PAG*10, true); 
	$paginare_string=$paginare->doPaginare(); 				    

	//---------------------------------------------------------------------------------------------------------------------------------
	$result=$mysqli->query($sql." LIMIT ".$paginare->getLimitStart().", ".(AFISARI_PE_PAG*10));
	
	//@patch ca sa nu scriu totul din nou, o sa incetineasca un pic - luat din arrayFromDB, nu am folosit arrayFromDB pt ca nu fost gandita pt UNION
	$i=0;			
	while($row=$result->fetch_assoc())
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
		if(empty($arr_cautare[0]["nr"]))
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
		$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat=".$arr_produse[$i]["id_cat"]." ORDER BY id_filtru ASC"); 
		$nr_filtre=count($arr_filtre);
		
		for($j=0;$j<$nr_filtre;$j++)
		{
			$filtre[$j]=array("id_filtru"=>$arr_filtre[$j]["id_filtru"],
							  "nume_filtru"=>$arr_filtre[$j]["nume_filtru"]);			  							  											  
		}
		
		//-----------------------------------------------------------------------------------------------------------------------------
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
		$arr_cat_sec=(CAT_SECUNDARE)?getCategoriiSecundare($arr_produse[$i]["id_produs"]):array();
		if(!is_array($arr_cat_sec))
			$arr_cat_sec=array();
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu toate detaliile produsului
		$arr_produse_detalii[$i]=array("id_produs"=>$arr_produse[$i]["id_produs"],										   
									   "id_cat"=>$arr_produse[$i]["id_cat"],
									   "nume_produs"=>$arr_produse[$i]["nume_produs"],
									   "adresa_poza_produs"=>$adresa_poza,
									   "adresa_poza_producator"=>$adresa_poza_producator,
									   "stoc"=>ucfirst($arr_stoc[$arr_produse[$i]["stoc"]]),
								  	   "id_stoc"=>$arr_produse[$i]["stoc"],
									   "tip"=>$arr_produse[$i]["tip"],
									   "poze_sec_mici"=>$poze_sec_mici,
									   "poze_sec_medii"=>$poze_sec_medii,
									   "pret_produs"=>formateazaNr($arr_produse[$i]["pret"]*TVA),
									   "pret_vechi"=>(!empty($arr_produse[$i]["pret_vechi"]) && $arr_produse[$i]["pret_vechi"]!=0)?formateazaNr($arr_produse[$i]["pret_vechi"]*TVA):"",
									   "reducere"=>calculeazaReducere($arr_produse[$i]["pret_vechi"]*TVA, $arr_produse[$i]["pret"]*TVA),
									   "popup_js"=>$popup_js,
									   "link_produs"=>getLinkProdus($arr_produse[$i]["link_cat"], $arr_produse[$i]["nume_produs"], $arr_produse[$i]["id_produs"]),
									   "caracteristici"=>$caracteristici,
									   "producator"=>(isset($arr_producator[0]["nume_cat"]) ? $arr_producator[0]["nume_cat"] : ""),
									   "rating"=>array("1"=>round($rating->getRating()), "2"=>RATING_MAX-round($rating->getRating())),
									   "nr_comentarii"=>$rating->getNrComentarii(),
									   "radacina_produs"=>$arr_categorii_produs,
									   "cat_sec"=>$arr_cat_sec,
									   "nr_cat_sec"=>count($arr_cat_sec),
									   "border"=>($i>0 && $i%2!=0)?1:0);
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY

	//@string cautat
	$smarty->assign("cautare_string", prepareStringFromDB($cautare_string));
	
	//@similitudini
	$smarty->assign("categorii_sim", (!empty($arr_categorii_sim))?$arr_categorii_sim:"");
	$smarty->assign("producatori_sim", (!empty($arr_producatori_sim))?$arr_producatori_sim:"");
	
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