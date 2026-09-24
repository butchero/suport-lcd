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
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/parametri_site.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare valoare
	if(isset($_POST["modifica"]) && is_numeric($_POST["id_config"]))
	{
		$arr_parametru=arrayFromDB("*", "t_config", "WHERE id_config='".$_POST["id_config"]."'");
		
		arrayUpdateToDB("t_config", array("val_param"), array($_POST["valoare"]), array("id"=>"id_config", "valoare"=>$_POST["id_config"]));
		
		$mesaj="Parametrul <u>".ucwords(str_replace("_", " ", $arr_parametru[0]["nume_param"]))."</u> a fost modificat cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@select parametri site din tabel de configurare
	$arr_parametri=arrayFromDB("*", "t_config", "ORDER BY id_config ASC");
	
	foreach($arr_parametri as $key=>$value)
	{
		$parametri[$key]["id_config"]=$value["id_config"];
		$parametri[$key]["nume_param"]=ucwords(str_replace("_", " ", $value["nume_param"]));
		$parametri[$key]["val_param"]=$value["val_param"];
		$parametri[$key]["descriere_param"]=$value["descriere_param"];
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("parametri", $parametri);
	$smarty->assign("mesaj", $mesaj);
	
	require_once("right.php");
	require_once("bottom.php");
?>