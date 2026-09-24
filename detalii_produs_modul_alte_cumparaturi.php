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
	//------------------------------------------------------------------------------------------------------------------------------
	//@cine a cumparat x a cumparat si y, z	
	$arr_alte_produse=arrayFromDB(array("DISTINCT(id_comanda) AS id_comanda"), "t_produse_comenzi", "WHERE id_produs='".$id_produs."'");
	
	if(count($arr_alte_produse)>0)
	{
		foreach($arr_alte_produse as $k=>$v)
			$alte_produse[]=$v["id_comanda"];
		
		if(count($alte_produse)>0)
			$sql_in=" IN (".implode(", ", $alte_produse).")";
		
		$arr_alte_produse=arrayFromDB(array("t_produse_comenzi.id_produs",
											"t_produse.id_cat",								  
											"t_produse.nume_produs",
											"pret",
											"pret_vechi",
											"stoc",
											"t_categorii.link_cat"),
									  "t_produse_comenzi LEFT JOIN t_produse ON t_produse_comenzi.id_produs=t_produse.id_produs
									    				 LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
									  "WHERE t_categorii.activ='1' AND t_produse_comenzi.id_comanda ".$sql_in."								 		
									   		AND t_produse_comenzi.id_produs!='".$id_produs."'
									 			GROUP BY t_produse_comenzi.id_produs LIMIT 0, 10");		
		
		$nr_produse=count($arr_alte_produse);
		
		//------------------------------------------------------------------------------------------------------------------------------
		//@loop
		for($i=0;$i<$nr_produse;$i++)
		{
			//--------------------------------------------------------------------------------------------------------------------------
			//@detalii produs
			
			//--------------------------------------------------------------------------------------------------------------------------
			//@poza principala
			$adresa_poza=getPozaPrincipalaMicaProdus($arr_alte_produse[$i]["id_produs"]);
						
			//--------------------------------------------------------------------------------------------------------------------------
			//@convertor valutar
			$popup_js=getConvertorValutar($arr_alte_produse[$i]["pret"]);		
											
			//--------------------------------------------------------------------------------------------------------------------------
			//@array asociativ cu toate detaliile produsului
			$arr_alte_produse_detalii[$i]=array("id_produs"=>$arr_alte_produse[$i]["id_produs"],										   
											    "nume_produs"=>$arr_alte_produse[$i]["nume_produs"],
											    "nume_producator"=>$arr_alte_produse[$i]["nume_cat"],
											    "adresa_poza_produs"=>$adresa_poza,									    
											    "pret_produs"=>formateazaNr($arr_alte_produse[$i]["pret"]*TVA),
											    "pret_vechi"=>(!empty($arr_alte_produse[$i]["pret_vechi"]) && $arr_alte_produse[$i]["pret_vechi"]!=0)?formateazaNr($arr_alte_produse[$i]["pret_vechi"]*TVA):"",										   
											    "link_produs"=>getLinkProdus($arr_alte_produse[$i]["link_cat"], $arr_alte_produse[$i]["nume_produs"], $arr_alte_produse[$i]["id_produs"]),
											    "link_cat"=>URL_BASE.$arr_alte_produse[$i]["link_cat"]);
		}
	}
?>