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
	//--------------------------------------------------------------------------------------------------------------
	//@cos cumparaturi		
	require_once("clase/cos.php");
	
	$cos=new Cos();		
	$produse=$cos->getProduseCos();
	$nr_produse_cos=count($produse);
		
	if(count($produse)>0)
	{			
		$i=0;
		
		//@sortare produse pt a mentine ordinea in care au fost adaugate in cos (sortez dupa timestamp-ul adaugarii)
		foreach($produse as $key =>$row) 
		{
		   $data_adaugarii[$key]=$row["data_adaugarii"];
		}
		
		array_multisort($data_adaugarii, SORT_ASC, $produse);
		
		//@produsele din cos: nume, pret, cantitate
		foreach($produse as $key=>$value)
		{
			$continut_cos[$i]["id_produs"]=$value["id_produs"];
			$continut_cos[$i]["nume_produs"]=prepareStringFromDB($value["nume_produs"]);
			$continut_cos[$i]["cantitate"]=$value["cantitate"];
			$continut_cos[$i]["pret"]=formateazaNr($cos->GetSubTotal($value["id_produs"]));				
			
			$i++;				
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------
	//@bestseller

	//@daca sunt pe o categorie/subcategorie etc. filtrez bestseller-ul doar de pe categoria respectiva
	(is_numeric($id_cat) && !empty($id_cat))?$where_bestseller="AND t_produse.id_cat='".$id_cat."'":"";
	
	
	$arr_bestseller=arrayFromDB(array("id_produs", "nume_produs", "link_cat"),
								"t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
								"WHERE bestseller!=0 ".$where_bestseller." AND t_categorii.activ='1' ORDER BY bestseller DESC LIMIT 0, ".AFISARI_BESTSELLER);

	$i=0;

	if(is_array($arr_bestseller))
	{
		foreach($arr_bestseller as $key=>$value)
		{							 
			$bestseller[$i]["nume_produs"]=stringLimit(prepareStringFromDB($arr_bestseller[$key]["nume_produs"]), "24", "..");
			$bestseller[$i]["nume_produs_complet"]=prepareStringFromDB($arr_bestseller[$key]["nume_produs"]);
			$bestseller[$i]["link_produs"]=getLinkProdus($arr_bestseller[$key]["link_cat"], $arr_bestseller[$key]["nume_produs"], $arr_bestseller[$key]["id_produs"]);
			
			$i++;
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------
	//@ultimele vanzari
	$arr_ultimele_vanzari=arrayFromDB(array("t_produse.id_produs", "t_produse.nume_produs", "link_cat"),
							   		  "t_produse_comenzi LEFT JOIN t_produse ON t_produse_comenzi.id_produs=t_produse.id_produs
							   					  		 LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
							   		  "WHERE t_categorii.activ='1' ORDER BY id DESC LIMIT 0, ".AFISARI_ULTIMELE_VANZARI);
							   		  
	$i=0;

	if(is_array($arr_ultimele_vanzari))
	{
		foreach($arr_ultimele_vanzari as $key=>$value)
		{							 
			$ultimele_vanzari[$i]["nume_produs"]=stringLimit(prepareStringFromDB($arr_ultimele_vanzari[$key]["nume_produs"]), "24", "..");
			$ultimele_vanzari[$i]["nume_produs_complet"]=prepareStringFromDB($arr_ultimele_vanzari[$key]["nume_produs"]);
			$ultimele_vanzari[$i]["link_produs"]=getLinkProdus($arr_ultimele_vanzari[$key]["link_cat"], $arr_ultimele_vanzari[$key]["nume_produs"], $arr_ultimele_vanzari[$key]["id_produs"]);
			
			$i++;
		}
	}

	
	//--------------------------------------------------------------------------------------------------------------------------
	//@produs oferta speciala random
	$arr_produs_special=arrayFromDB(array("id_produs", "t_produse.id_cat", "id_prod", "nume_produs", "pret", "pret_vechi", "stoc", "t_categorii.link_cat"),
							 		"t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
							 		"WHERE t_categorii.activ='1' AND t_produse.tip='1' ORDER BY RAND() LIMIT 0, 3");			
	
	$nr_produse=count($arr_produs_special);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@loop prin produse la oferta speciala
	for($i=0;$i<$nr_produse;$i++)
	{
		//----------------------------------------------------------------------------------------------------------------------
		//@detalii produs
		
		//----------------------------------------------------------------------------------------------------------------------
		//@poza principala
		if(file_exists(URL_BASE_ABS."poze_produse/".$arr_produs_special[$i]["id_produs"]."/medii/0.jpg"))
			$adresa_poza=URL_BASE."poze_produse/".$arr_produs_special[$i]["id_produs"]."/medii/0.jpg";
		else $adresa_poza=DIR_TEMPLATE."img/fara_imagine.jpg";
		
		//----------------------------------------------------------------------------------------------------------------------
		//@convertor valutar
		unset($popup_js);

		if(!empty($arr_curs["usd"]) && !empty($arr_produs_special[$i]["pret"]))
		{
            $popup_js = (formateazaNr($arr_produs_special[$i]["pret"] / $arr_curs["usd"])) . " USD <br />";
            $popup_js .= (formateazaNr($arr_produs_special[$i]["pret"] / $arr_curs["euro"])) . " EURO";
            $popup_js = "<b>CONVERTOR VALUTAR</b><br />" . $popup_js;
        }
		//----------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu toate detaliile produsului
		$arr_produs_special_detalii[$i]=array("id_produs"=>$arr_produs_special[$i]["id_produs"],										   
									   		  "nume_produs"=>prepareStringFromDB($arr_produs_special[$i]["nume_produs"]),
											  "adresa_poza_produs"=>$adresa_poza,
											  "stoc"=>ucfirst($arr_stoc[$arr_produs_special[$i]["stoc"]-1]["stoc"]),
										  	  "stoc_poza"=>$arr_stoc[$arr_produs_special[$i]["stoc"]-1]["poza"],
											  "pret_produs"=>formateazaNr($arr_produs_special[$i]["pret"]*TVA),
											  "pret_vechi"=>(!empty($arr_produs_special[$i]["pret_vechi"]) && $arr_produs_special[$i]["pret_vechi"]!=0)?formateazaNr($arr_produs_special[$i]["pret_vechi"]*TVA):"",
											  "reducere"=>calculeazaReducere($arr_produs_special[$i]["pret_vechi"], $arr_produs_special[$i]["pret"]),
											  "popup_js"=>$popup_js,
											  "link_produs"=>getLinkProdus($arr_produs_special[$i]["link_cat"], $arr_produs_special[$i]["nume_produs"], $arr_produs_special[$i]["id_produs"]));
	}
							   		  
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@mesaj cos	
	$smarty->assign("mesaj_cos", ($cos->getTotal()==0)?"Cosul este gol.":"");

	//@afisare continut cos
	$smarty->assign("continut_cos", $continut_cos);
	
	//@nr produse cos
	$smarty->assign("nr_produse_cos", $nr_produse_cos);
	
	//@total cos
	$smarty->assign("total_cos", formateazaNr($cos->GetTotal()));
	
	//@total cos
	$smarty->assign("total_cos", formateazaNr($cos->GetTotal()));
	
	//@bestseller
	$smarty->assign("bestseller", $bestseller);

	//@afisari bestseller (top vanzari)
	$smarty->assign("top_bestseller", AFISARI_BESTSELLER);
	
	//@ultimele vanzari
	$smarty->assign("ultimele_vanzari", $ultimele_vanzari);
	
	//@afisari ultimele vanzari
	$smarty->assign("afisari_ultimele_vanzari", AFISARI_ULTIMELE_VANZARI);
	
	//@produs oferta speciala random
	$smarty->assign("produs_special", $arr_produs_special_detalii);
?>