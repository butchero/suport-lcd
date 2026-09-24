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
	$display_page="admin/grupeaza_filtre.tpl";	
		
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@actiune adauga grup nou in categoria selectata
	if(isset($_POST["adauga_grup"]) && !empty($_POST["nume_grup_nou"]) && isset($_POST["id_cat"]) && !empty($_POST["id_cat"]) && is_numeric($_POST["id_cat"]))
	{
		$id_cat=$_POST["id_cat"];
		$nume_grup_nou=$_POST["nume_grup_nou"];
		
		$arr_check=arrayFromDB("*", "t_categorii_filtre", "WHERE id_cat='".$id_cat."' AND nume_cat_filtru='".prepareStringToDB($nume_grup_nou)."'");
		
		if(count($arr_check)==0)
		{
			arrayInsertToDB("t_categorii_filtre", array("nume_cat_filtru", "id_cat"), array($nume_grup_nou, $id_cat));
			$mesaj="Grupul a fost adaugat cu succes!";
		}
		else 
		{
			$mesaj="Exista deja un grup cu acest nume in categoria selectata!";
		}
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@afiseaza produse din categoria selectata	
	if(isset($_POST["id_cat"]) && !empty($_POST["id_cat"]) && is_numeric($_POST["id_cat"]))
	{		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@actiune stergere grup
		if(isset($_POST["grupuri"]) && !empty($_POST["grupuri"]) && is_numeric($_POST["grupuri"]) && isset($_POST["sterge_grup"]))
		{
			$id_grup=$_POST["grupuri"];
			
			arrayDeleteFromDB("t_relatii_cat_filtre", array("id_cat_filtru"), array($id_grup));
			arrayDeleteFromDB("t_categorii_filtre", array("id_cat_filtru"), array($id_grup));
			
			$mesaj="Grupul selectat a fost sters cu succes!";
		}
		
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@actiune actualizare grupuri
		if(isset($_POST["grupuri"]) && !empty($_POST["grupuri"]) && is_numeric($_POST["grupuri"]) && !isset($_POST["sterge_grup"]))
		{
			$id_grup=$_POST["grupuri"];
			$arr_filtre_grupate=$_POST["filtre_grupate"];
			$arr_filtre_disponibile=$_POST["filtre_disponibile"];
			
			//@sterg mai intai filtrele deja grupate in $id_grup
			arrayDeleteFromDB("t_relatii_cat_filtre", array("id_cat_filtru"), array($id_grup));
			
			//@inserez filtrele setate ca grupate pentru $id_grup in tabelul de relatii 
			if(is_array($arr_filtre_grupate))
				foreach($arr_filtre_grupate as $key=>$value)				
					arrayInsertToDB("t_relatii_cat_filtre", array("id_cat_filtru", "id_filtru"), array($id_grup, $value));
					
			$mesaj="Grupul a fost actualizat cu succes!";		
		}
		
		$id_cat=$_REQUEST["id_cat"];
		$arr_grupuri=arrayFromDBtoCombo("t_categorii_filtre", "id_cat_filtru", "nume_cat_filtru", "WHERE id_cat='".$id_cat."' ORDER BY id_cat_filtru ASC");
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("id_cat", $id_cat);
	$smarty->assign("grupuri", $arr_grupuri);
	$smarty->assign("filtre", $arr_filtre);
	
	require_once("right.php");
	require_once("bottom.php");
?>