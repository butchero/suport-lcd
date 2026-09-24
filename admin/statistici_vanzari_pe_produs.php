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
	$display_page="admin/statistici_vanzari_pe_produs.tpl";	
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@id_produs
	if(isset($_REQUEST["id_produs"]) && is_numeric($_REQUEST["id_produs"]) && !empty($_REQUEST["id_produs"]))
	{
		$id_produs=$_REQUEST["id_produs"];
		
		$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$id_produs."'");
		
		if(count($arr_produs)==0)
		{
			$mesaj="Produsul cu id ".$id_produs." nu exista!";
			$id_produs="";
		}					
		else 
		{
			$nume_produs=$arr_produs[0]["nume_produs"];
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("id_produs", $id_produs);
	$smarty->assign("nume_produs", $nume_produs);
	$smarty->assign("an_selectat", $_POST["an"]);
	$smarty->assign("luna_selectata", $_POST["luna"]);
	$smarty->assign("luni", $luni);
	
	require_once("right.php");
	require_once("bottom.php");
?>