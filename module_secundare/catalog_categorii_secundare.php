<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2006       		   **
	**                                                                         **
	*****************************************************************************
	*****************************************************************************
	*/
	require_once("../top.php");
	require_once("../left.php");	
	require_once("../functii/f_catalog.php");
	require_once("../functii/f_links.php");
	require_once("../clase/produsRating.php");

	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="module_secundare/catalog_categorii_secundare.tpl";
	
	$arr_cat_secundara=arrayFromDB("*", "t_categorii_secundare", "WHERE link_cat_sec='".$_GET["cat_sec"]."'");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@verificare cat secundara
	if(count($arr_cat_secundara)!=1)
	{
		header("HTTP/1.0 404 Not Found");
		$display_page="404.tpl";
		
		require_once("../right.php");
		require_once("../bottom.php");
		
		exit;
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtrare afectiuni
	if($arr_cat_secundara[0]["id_parinte"]==0) //daca este selectata o categorie de pe nivelul 0
	{
		$id_cat_sec=$arr_cat_secundara[0]["id_cat_sec"];
		$link_cat_sec=getLinkCatSec($arr_cat_secundara[0]["link_cat_sec"]);
		$nume_cat_sec=$arr_cat_secundara[0]["nume_cat_sec"];
		
		$arr_cat_sec_copii=arrayFromDB("*", "t_categorii_secundare", "WHERE id_parinte='".$id_cat_sec."'");
		$arr_cat_secundare[]=$id_cat_sec;
		
		foreach($arr_cat_sec_copii as $k=>$v)
		{
			$arr_cat_secundare[]=$v["id_cat_sec"];
			$cat_sec[]=array("id_cat_sec"=>$v["id_cat_sec"], "nume_cat_sec"=>$v["nume_cat_sec"], "link_cat_sec"=>getLinkCatSec($v["link_cat_sec"]));
		}
		
		//@sql filtrare produse in fct de categoria selectata
		$sql_in=implode(",", $arr_cat_secundare);
	}
	else //daca este selectata o categorie de pe nivelul 1
	{
		$arr_parinte=arrayFromDB("*", "t_categorii_secundare", "WHERE id_cat_sec='".$arr_cat_secundara[0]["id_parinte"]."'");
		
		$id_cat_sec=$arr_parinte[0]["id_cat_sec"];
		$link_cat_sec=getLinkCatSec($arr_parinte[0]["link_cat_sec"]);
		$nume_cat_sec=$arr_parinte[0]["nume_cat_sec"];
		
		$cat_sec_selectata=$arr_cat_secundara[0]["id_cat_sec"];
		
		$arr_cat_sec_copii=arrayFromDB("*", "t_categorii_secundare", "WHERE id_parinte='".$arr_cat_secundara[0]["id_parinte"]."'");
		$arr_cat_secundare[]=$arr_cat_secundara[0]["id_parinte"];
		
		foreach($arr_cat_sec_copii as $k=>$v)
		{
			$arr_cat_secundare[]=$v["id_cat_sec"];
			$cat_sec[]=array("id_cat_sec"=>$v["id_cat_sec"], "nume_cat_sec"=>$v["nume_cat_sec"], "link_cat_sec"=>getLinkCatSec($v["link_cat_sec"]));
		}
		
		//@sql filtrare produse in fct de categoria selectata
		$sql_in=$cat_sec_selectata;
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@LADIES AND GENTLEMEN, i give you "THE SQL"
	$sql="SELECT DISTINCT(a.id_produs), b.id_cat, id_prod, nume_produs, b.nume_cat, b.link_cat, pret, pret_vechi, descriere_produs, caracteristici, data_adaugarii, stoc, tip
		   			  FROM t_produse AS a 
		   		INNER JOIN t_categorii AS b ON a.id_cat=b.id_cat	
		   		INNER JOIN t_relatii_cat_sec_produse AS c ON a.id_produs=c.id_produs 
		   	WHERE c.id_cat_sec IN (".$sql_in.") AND b.activ=1";
						
	//---------------------------------------------------------------------------------------------------------------------------------		
	//@paginare
	require_once("../clase/paginare.php");
	
	$paginare=new paginare("pag", $sql, getLinkCatSec($_GET["cat_sec"])."-p".PATTERN, AFISARI_PE_PAG, true); 
	$paginare_string=$paginare->doPaginare(); 				    

	//---------------------------------------------------------------------------------------------------------------------------------
	$result=$mysqli->query($sql." LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	//@patch ca sa nu scriu totul din nou, o sa incetineasca un pic - luat din arrayFromDB, nu am folosit arrayFromDB pt ca nu fost gandita pt UNION
	$i=0;			
	while($row=$result->fetch_array())
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
		
		//-------------------------------------------------------------------------------------------------------------------------
		//@categorii secundare asociate produsului
		(CAT_SECUNDARE)?$arr_cat_sec=getCategoriiSecundare($arr_produse[$i]["id_produs"]):"";
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@producator
		$arr_producator=arrayFromDB(array("nume_cat"), "t_categorii", "WHERE id_cat='".$arr_produse[$i]["id_prod"]."'");
		
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
									   "cat_sec"=>$arr_cat_sec);
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY

	$smarty->assign("nume_cat_sec_principala", $nume_cat_sec);
	$smarty->assign("link_cat_sec_principala", $link_cat_sec);
	
	//@categorii secundare
	$smarty->assign("cat_sec", $cat_sec);
	
	//@link categorie selectata
	$smarty->assign("cat_sec_selectata", $cat_sec_selectata);
				
	//@afisare produse
	$smarty->assign("produse", $arr_produse_detalii);	
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	//@id categorie
	$smarty->assign("id_cat", $id_cat);
	
	require_once("../right.php");
	require_once("../bottom.php");
?>