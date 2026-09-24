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
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/export_magazine_online.tpl";	
	
	if(isset($_POST["export"]))
	{
		require_once(URL_BASE_ABS."export_bd_pt_altemagazine/export.php");
		
		$arr_fisiere[]=array("nume"=>"categorii.csv", "link"=>URL_BASE."export_bd_pt_altemagazine/categorii.csv");
		$arr_fisiere[]=array("nume"=>"producatori.csv", "link"=>URL_BASE."export_bd_pt_altemagazine/producatori.csv");
		$arr_fisiere[]=array("nume"=>"produse.csv", "link"=>URL_BASE."export_bd_pt_altemagazine/produse.csv");
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("fisiere_csv", $arr_fisiere);

	require_once("right.php");
	require_once("bottom.php");
?>