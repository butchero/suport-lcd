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
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/cosul_meu.tpl";

	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Cosul meu";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere produs din cos
	if(isset($_GET["sterge_produs"]) && is_numeric($_GET["sterge_produs"]))
	{
		$cos->scoateProdus($_GET["sterge_produs"]);
		header("Location:".URL_BASE."cosul-meu");
		exit;		
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune golire cos
	if(isset($_POST["goleste_cos"]))
	{
		$cos->golesteCos();
		header("Location:".URL_BASE."cosul-meu");	
		exit;		
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune actualizare cos
	if(isset($_POST["actualizeaza_cos"]))
	{
		for($i=0;$i<count($_POST["id_produs"]);$i++)
		{
			$cos->modificaProdus($_POST["id_produs"][$i], $_POST["cantitate"][$i]);
		}
		
		$_SESSION["comentariu_comanda"]=nl2br($_POST["comentarii"]);
		
		header("Location:".URL_BASE."cosul-meu");	
		exit;
	}	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@judet user
	$scutit_de_comanda_minima=false;
	
	if(isset($_SESSION["id_user"]) && is_numeric($_SESSION["id_user"]) && !empty($_SESSION["id_user"]))
	{
		$arr_judet_user=arrayFromDB("*", "t_useri INNER JOIN t_judete ON t_useri.id_jud=t_judete.id_jud", "WHERE id_user='".$_SESSION["id_user"]."'");
		$id_judet_user=$arr_judet_user[0]["id_jud"];
		
		if(in_array($id_judet_user, $arr_judete_preferentiale))
			$scutit_de_comanda_minima=true;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------	
	$total_cos=0;
	$erori_cos=false;
	
	//@afisare produse cos curent (variabila $produse este definita in right.php)
	if(is_array($produse) && count($produse)>0)
	{
		foreach($produse as $key=>$value)
		{
			//@poza produs
			$adresa_poza=getPozaPrincipalaMicaProdus($value["id_produs"]);
			
			//@check against stoc (NU_E_PE_STOC e definita in configurare.php)
			if($cos->getStoc($value["id_produs"])==NU_E_PE_STOC)
			{
				$stoc=0;
				$erori_cos=true;
			}
			else $stoc=1;
			
			$cosul_meu[]=array("id_produs"=>$value["id_produs"],
							   "nume_produs"=>prepareStringFromDB($value["nume_produs"]),
							   "link_produs"=>getLinkProdus($value["link_categorie_produs"], $value["nume_produs"], $value["id_produs"]),
							   "link_sterge_produs"=>URL_BASE."cosul-meu/sterge-produs/".$value["id_produs"],
							   "poza_produs"=>$adresa_poza,
							   "cantitate"=>$value["cantitate"],
							   "stoc"=>$stoc,
							   "pret_unitar"=>formateazaNr($value["pret_unitar"]),
							   "pret_total"=>formateazaNr($cos->GetSubTotal($value["id_produs"])));				
			
			$total_cos+=$cos->GetSubTotal($value["id_produs"]);				
		}
	}
	
	//@finalizeaza comanda
	if(isset($_POST["finalizeaza_comanda"]) && $_POST["finalizeaza_comanda"]==1 && !$erori_cos)
	{
		for($i=0;$i<count($_POST["id_produs"]);$i++)
		{
			$cos->modificaProdus($_POST["id_produs"][$i], $_POST["cantitate"][$i]);
		}
		
		$_SESSION["comentariu_comanda"]=nl2br($_POST["comentarii"]);
		$_SESSION["transport"]=$_POST["transport"];
		
		header("Location:".URL_BASE."finalizeaza-comanda");
		exit;
	}
	
	//@transport
	if(isset($_POST["transport"]) && is_numeric($_POST["transport"]))
	{
		$arr_transport=arrayFromDB("*", "t_transport", "WHERE id_transport='".prepareStringToDB($_POST["transport"])."'");		
		$transport_cost=$arr_transport[0]["cost"];		
		$transport_selectat=$_POST["transport"];
	}
	elseif(isset($_SESSION["transport"]) && is_numeric($_SESSION["transport"]))
	{
		$arr_transport=arrayFromDB("*", "t_transport", "WHERE id_transport='".prepareStringToDB($_SESSION["transport"])."'");		
		$transport_cost=$arr_transport[0]["cost"];
		$transport_selectat=$_SESSION["transport"];
	}
	else 
	{
		$arr_transport=arrayFromDB("*", "t_transport", "ORDER BY nume_transport ASC LIMIT 0,1");		
		$transport_cost=(isset($arr_transport[0]["cost"]) ? $arr_transport[0]["cost"] : 0);
		$transport_selectat=(isset($arr_transport[0]["id_transport"]) ? $arr_transport[0]["id_transport"] : "");
	}
	
	if($total_cos<COMANDA_MINIMA)
	{
		//@conditii suplimentare (daca utilizatorul a mai comandat inainte si comanda nu a fost onorate, mai poate comanda o data fara sa fie nevoie sa indeplineasca "COMANDA MINIMA"
		$arr_comenzi_anterioare=arrayFromDB("*", "t_comenzi", "WHERE id_user='".(isset($_SESSION["id_user"]) ? $_SESSION["id_user"] : 0)."' AND (stare=0 OR stare=1)");
		
		if(count($arr_comenzi_anterioare)>0 && $total_cos>0)
			$total_comanda_check=COMANDA_MINIMA;
		else $total_comanda_check=$total_cos;	
	}
	else 
	{
		$total_comanda_check=$total_cos;
	}
	
	if($total_cos==0)
		$scutit_de_comanda_minima=false;
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@afisare cos cumparaturi
	if(!isset($cosul_meu) || !is_array($cosul_meu))
		$cosul_meu=array();
	$smarty->assign("cosul_meu", $cosul_meu);
	
	//@erori cos (erori legate de stoc produselor)
	$smarty->assign("erori_cos", $erori_cos);
	
	//@afisare total cos
	$smarty->assign("total_cos", formateazaNr($total_cos));
	$smarty->assign("total_cos_value", $total_cos);
	
	//@afisare total cos + transport
	$smarty->assign("total_cos_cu_transport", formateazaNr($total_cos+(($total_cos>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$transport_cost)));
	
	//@afisare comanda minima
	$smarty->assign("comanda_minima", (COMANDA_MINIMA!=0)?formateazaNr(COMANDA_MINIMA):"");
	$smarty->assign("comanda_minima_value", COMANDA_MINIMA);
	
	$smarty->assign("total_comanda_check", $total_comanda_check);
	
	//@nr_produse_cos
	$smarty->assign("nr_produse_cos", count($_SESSION["cos_cumparaturi"]));
	$smarty->assign("limita_cos", LIMITA_COS);
	
	//@afisare transport
	$smarty->assign("transport_combo", arrayFromDBtoCombo("t_transport", "id_transport", "nume_transport", "ORDER BY nume_transport ASC"));
	$smarty->assign("transport_selectat", $transport_selectat);
	$smarty->assign("transport_cost", formateazaNr($transport_cost));
	
	//@comentarii comanda
	$smarty->assign("comentarii_comanda", prepareStringFromDB(isset($_SESSION["comentariu_comanda"]) ? $_SESSION["comentariu_comanda"] : ""));
	
	//@nu afisez cosul din right (sa nu fie confuzie intre cosul afisat pe centru si cel din right)
	$smarty->assign("afiseaza_cos_right", 0);
	
	$smarty->assign("scutit_de_comanda_minima", ($scutit_de_comanda_minima)?1:0);
	
	require_once("../bottom.php");
?>