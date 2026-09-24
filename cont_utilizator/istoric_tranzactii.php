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
	require_once("../top.php");
	require_once("../left.php");
	require_once("../right.php");
	require_once("../functii/f_catalog.php");		
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/istoric_tranzactii.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Istoric tranzactii";

	//--------------------------------------------------------------------------------------------------------------------------
	//@date user
	$arr_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$_SESSION["id_user"]."'");
	
	//@dir proforme pdf
	$dir_proforme=URL_BASE."proforme/".md5($arr_user[0]["data_inregistrarii"].$_SESSION["id_user"])."/";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@filtrare tranzactii dupa perioada
	$sql_where="";
	$link_sufix="";
	
	$de_la=$_REQUEST["de_la"];
	$pana_la=$_REQUEST["pana_la"];
	
	if(is_numeric($de_la) && is_numeric($pana_la))
	{
		$timestamp_de_la=strtotime($_REQUEST["de_la"]);
		$timestamp_pana_la=strtotime($_REQUEST["pana_la"])+(60*60*24)-1; //formula asta inseamna (pana_la) + 23h 59min 59sec
		
		if($timestamp_de_la > $timestamp_pana_la)
		{
			$eroare="Perioada este invalida !";
		}
		else 
		{
			$sql_where=" AND data_comanda BETWEEN ".$timestamp_de_la." AND ".$timestamp_pana_la;
			$link_sufix="&de_la=".$_REQUEST["de_la"]."&pana_la=".$_REQUEST["pana_la"];
		}
	}
	else 
	{
		$de_la=date("Ymd", $arr_user[0]["data_inregistrarii"]);
		$pana_la=date("Ymd");
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");
	
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_comanda) AS nr FROM t_comenzi WHERE id_user='".$_SESSION["id_user"]."'".$sql_where, 
						   URL_BASE."contul-meu/istoric-tranzactii?pag=".PATTERN.$link_sufix); 
	$paginare_string=$paginare->doPaginare(); 
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@selectare tranzactii (comenzi)
	$arr_tranzactii=arrayFromDB("*",
							    "t_comenzi",
							    "WHERE id_user='".$_SESSION["id_user"]."' ".$sql_where." ORDER BY id_comanda DESC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	$j=0;	
	if(is_array($arr_tranzactii))
	{				    
		foreach($arr_tranzactii as $key=>$value)
		{
			//------------------------------------------------------------------------------------------------------------------
			//@selectare produse cumparate asociate comenzii
			$arr_produse_comanda=arrayFromDB("*",
									 		 "t_produse_comenzi",
									 		 "WHERE id_comanda='".$value["id_comanda"]."'");

			$nr_produse_comanda=count($arr_produse_comanda);
									 		 		
			for($i=0;$i<$nr_produse_comanda;$i++)
			{													
				//@produsele cumparate
				$produse_comanda[$i]=array("nume_produs"=>$arr_produse_comanda[$i]["nume_produs"],	
										   "poza_produs"=>getPozaPrincipalaMicaProdus($arr_produse_comanda[$i]["id_produs"]),								   		  
								   		   "cantitate"=>$arr_produse_comanda[$i]["cantitate"],
								   		   "pret_unitar"=>formateazaNr($arr_produse_comanda[$i]["pret_produs"]),
								   		   "pret_total"=>formateazaNr($arr_produse_comanda[$i]["pret_produs"]*$arr_produse_comanda[$i]["cantitate"]*TVA));
			}
		
			//@array cu data comenzii si produsele cumparate
			$comenzi[$j]=array("id_comanda"=>$value["id_comanda"],
							   "data_comenzii"=>date(DATA_FORMAT." m:i", $value["data_comanda"]),
							   "produse"=>$produse_comanda,
							   "total_comanda"=>formateazaNr($value["total_comanda"]),
							   "proforma"=>$dir_proforme."proforma_".$value["id_comanda"].".pdf",
							   "stare_comanda"=>$stare_comanda[$value["stare"]]);			
				
			unset($arr_produse_comanda, $produse_comanda);				
			$j++;		
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@total cumparaturi din perioada data
	$arr_total_cumparaturi=arrayFromDB(array("SUM(total_comanda) AS total"), "t_comenzi", "WHERE id_user='".$_SESSION["id_user"]."' ".$sql_where);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
		
	//@afisare erori formular
	$smarty->assign("eroare", $eroare);
	
	//@perioada start (de forma YYYYMMDD pt form)
	$smarty->assign("de_la", $de_la);
	
	//@perioada end (de forma YYYYMMDD pt form)
	$smarty->assign("pana_la", $pana_la);
	
	$smarty->assign("de_la_formatat", date(DATA_FORMAT, strtotime($de_la)));
	$smarty->assign("pana_la_formatat", date(DATA_FORMAT, strtotime($pana_la)));
		
	//@afisare tranzactii (comenzi)
	$smarty->assign("comenzi", $comenzi);
	
	//@total_cumparaturi
	$smarty->assign("total_cumparaturi", formateazaNr($arr_total_cumparaturi[0]["total"]));
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	require_once("../bottom.php");
?>