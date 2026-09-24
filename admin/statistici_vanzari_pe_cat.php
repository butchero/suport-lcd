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
	require_once("../functii/f_admin.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@restrictionare acces pt subadmini
	restrictioneazaAccesSubadmini();
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/statistici_vanzari_pe_cat.tpl";	
	
	/************************************** NOTA ******************************************/
	/*------SUNT MULTE INTEROGARI CARE INCETINESC, dar care se executa doar la admin------*/ 
	/**************************************************************************************/
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtrare dupa perioada
	if(isset($_POST["perioada"]) && $_POST["perioada"]==1)
	{
		$astazi_start=strtotime(date("Ymd"));
		$astazi_end=$astazi_start+(60*60*24)-1;
		
		$sql_where=" AND data_comanda BETWEEN ".$astazi_start." AND ".$astazi_end;
	}
	
	if(isset($_POST["de_la"]) && isset($_POST["pana_la"]))
	{
		$calendar_start=strtotime($_POST["de_la"]);
		$calendar_end=strtotime($_POST["pana_la"])+(60*60*24)-1;
		
		$sql_where=" AND data_comanda BETWEEN ".$calendar_start." AND ".$calendar_end;
	}
	else 
	{
		$_POST["de_la"]=date("Ymd");
		$_POST["pana_la"]=date("Ymd");
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@construiesc un array asociativ $categ care contine pe fiecare linie un array cu categoria principala si subcategoriile ei
	$arr_cat_principale=arrayFromDB("*", "t_categorii", "WHERE id_parinte='0' AND producator='0' ORDER BY nr_ordine ASC");
	
	$total_nr_produse=0;
	$total_vanzari=0;
	
	foreach($arr_cat_principale as $key=>$value)
	{
		$sub_arbore=new arboreComplet($value["id_cat"], 0, $arr_toate_cat);		
		$subcat=$sub_arbore->getArboreComplet();
		
		$ids[]=$value["id_cat"];
		
		if(is_array($subcat))
			foreach($subcat as $k=>$v)
				$ids[]=$v["id_cat"];
			
		if(count($ids)>0)
		{
			$arr_stats=arrayFromDB(array("SUM(t_produse_comenzi.cantitate)  AS nr_produse", "SUM(t_produse_comenzi.pret_produs * t_produse_comenzi.cantitate) AS total"),
								   "t_comenzi LEFT JOIN t_produse_comenzi ON t_comenzi.id_comanda=t_produse_comenzi.id_comanda
								          	  LEFT JOIN t_produse ON t_produse_comenzi.id_produs=t_produse.id_produs
								          	  LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
								   "WHERE t_categorii.id_cat IN (".implode(",", $ids).") AND t_comenzi.stare=2 ".$sql_where);
								   			   				   
			$categ_stats[]=array("nume_cat"=>$value["nume_cat"], "nr_produse"=>(empty($arr_stats[0]["nr_produse"]))?0:$arr_stats[0]["nr_produse"], "total"=>formateazaNr($arr_stats[0]["total"]));
			
			$total_nr_produse+=$arr_stats[0]["nr_produse"];
			$total_vanzari+=$arr_stats[0]["total"];
		}
			
		unset($ids);	
	}
	
	$_SESSION["categ_stats"]=$categ_stats; //pt placinta
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("perioada", $_POST["perioada"]);
	$smarty->assign("de_la", $_POST["de_la"]);
	$smarty->assign("pana_la", $_POST["pana_la"]);
	$smarty->assign("categ_stats", $categ_stats);
	$smarty->assign("total", array("vanzari"=>formateazaNr($total_vanzari), "nr_produse"=>$total_nr_produse));
	
	require_once("right.php");
	require_once("bottom.php");
?>