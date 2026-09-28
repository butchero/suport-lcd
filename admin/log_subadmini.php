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
	$display_page="admin/log_subadmini.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@combo subadmini
	$arr_subadmini=arrayFromDBtoCombo("t_admin", "id_admin", "username", "WHERE super_admin='0' ORDER BY id_admin DESC");	

	//---------------------------------------------------------------------------------------------------------------------------------
	//@afisare loguri
	if(isset($_REQUEST["id_admin"]) && !empty($_REQUEST["id_admin"]) && is_numeric($_REQUEST["id_admin"]))
	{
		$id_admin=$_REQUEST["id_admin"];
		
		require_once("../clase/paginare.php");
		$paginare=new paginare("pag", 
							   "SELECT COUNT(id_log) AS nr FROM t_loguri WHERE id_admin='".$id_admin."'", 
							    URL_ADMIN."log_subadmini.php?pag=".PATTERN."&id_admin=".$id_admin, 30);
							    
		$paginare_string=$paginare->doPaginare();
							    
		$arr_loguri=arrayFromDB(array("FROM_UNIXTIME(data_log, '%d.%m.%Y') AS data_log", "log"),
							    "t_loguri",
							    "WHERE id_admin='".$id_admin."' ORDER BY id_log DESC LIMIT ".$paginare->getLimitStart().", 30");					    
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("subadmini", $arr_subadmini);
	if(!isset($arr_loguri) || !is_array($arr_loguri)) $arr_loguri=array();
	if(!isset($paginare_string)) $paginare_string="";
	if(!isset($id_admin)) $id_admin="";
	$smarty->assign("loguri", $arr_loguri);
	$smarty->assign("paginare", $paginare_string);
	$smarty->assign("id_admin", $id_admin);
	
	require_once("right.php");
	require_once("bottom.php");
?>