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
	$display_page="admin/editare_texte.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@basic check
	$arr_texte=arrayFromDB("*", "t_texte_site", "WHERE sectiune='".prepareStringFromDB($_GET["edit"])."'");
	
	if(count($arr_texte)!=1)
		die("Pagina de editat nu exista!");

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiunea pentru modificarea unei pagini
	if(isset($_POST["salveaza"]))
	{
		arrayUpdateToDB("t_texte_site", array("text"), array($_POST["text"]), array("id"=>"sectiune", "valoare"=>$_GET["edit"]));		
		$arr_texte=arrayFromDB("*", "t_texte_site", "WHERE sectiune='".prepareStringFromDB($_GET["edit"])."'");
	}	
		
		
	$titlu=ucfirst(str_replace("_", " ", $arr_texte[0]["sectiune"]));
	$text=$arr_texte[0]["text"];	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("titlu", $titlu);
	$smarty->assign("text", $text);
	
	
	require_once("right.php");
	require_once("bottom.php");
?>