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
	require_once("../functii/f_catalog.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@modul activat/dezactivat check
	if(!CAT_SECUNDARE)
		die("Aceasta sectiune este dezactivata! <br /><a href='".URL_ADMIN."'>Prima pagina din administrare.</a>");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/asociatii_produse.tpl";	

	//---------------------------------------------------------------------------------------------------------------------------------
	//@id produs
	if(isset($_REQUEST["id_produs"]) && !empty($_REQUEST["id_produs"]) && is_numeric($_REQUEST["id_produs"]))
	{
		$id_produs=$_REQUEST["id_produs"];	
		$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$id_produs."'");
		
		if(count($arr_produs)==0)
		{
			$mesaj="Nu exista produsul cu ID-ul ".$id_produs." !";
			unset($id_produs);
		}
		else
			$nume_produs=$arr_produs[0]["nume_produs"];	
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@id cat secundara	
	if(isset($_REQUEST["id_cat_sec"]) && !empty($_REQUEST["id_cat_sec"]) && is_numeric($_REQUEST["id_cat_sec"]))
		$id_cat_sec=$_REQUEST["id_cat_sec"];
	
	//---------------------------------------------------------------------------------------------------------------------------------		
	//@actiune salvare asociatii
	if(isset($_POST["flag_submit"]) && $_POST["flag_submit"]==1)
	{
		arrayDeleteFromDB("t_relatii_cat_sec_produse", array("id_produs"), array($id_produs));		
		$subcat_asociate=$_POST["subcategorii_asociate"];
		
		if(is_array($subcat_asociate))
		{
			foreach($subcat_asociate as $k=>$v)
				arrayInsertToDB("t_relatii_cat_sec_produse", array("id_cat_sec", "id_produs"), array($v, $id_produs));
			
			$mesaj="Actualizarea asocierilor s-a facut cu succes!";
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@afisare optiuni produs
	if(isset($id_produs))
	{
		//-----------------------------------------------------------------------------------------------------------------------------
		//@subcategorii secundare asociate produsului
		$arr_subcat_asociate=getCategoriiSecundare($id_produs);
	
		foreach($arr_subcat_asociate as $k=>$v)
		{
			$combo_cat_asociate[$v["id_cat_sec"]]=$v["nume_cat_sec"];
			$id_cat_asociate[]=$v["id_cat_sec"];
		}
	
		//-----------------------------------------------------------------------------------------------------------------------------
		//@subcategorii disponibile pentru asociere
		if(!empty($id_cat_sec))
		{
			$arr_subcat_disponibile=arrayFromDB("*", "t_categorii_secundare", "WHERE id_parinte='".$id_cat_sec."'".((count($id_cat_asociate)>0)?" AND id_cat_sec NOT IN (".implode(",", $id_cat_asociate) .")":""));
		
			foreach($arr_subcat_disponibile as $k=>$v)
				$combo_cat_disponibile[$v["id_cat_sec"]]=$v["nume_cat_sec"];
		}
										 
		//-----------------------------------------------------------------------------------------------------------------------------
		//@selectare categorii sec. -> combo-box
		$combo_categorii_sec=arrayFromDBtoCombo("t_categorii_secundare", "id_cat_sec", "nume_cat_sec", "WHERE id_parinte='0'");
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("id_produs", $id_produs);
	$smarty->assign("nume_produs", $nume_produs);
	$smarty->assign("id_cat_sec", $id_cat_sec);
	$smarty->assign("combo_cat", $combo_categorii_sec);
	$smarty->assign("combo_cat_asociate", $combo_cat_asociate);
	$smarty->assign("combo_cat_disponibile", $combo_cat_disponibile);

	
	require_once("right.php");
	require_once("bottom.php");
?>