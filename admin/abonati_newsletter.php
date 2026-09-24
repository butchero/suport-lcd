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
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@restrictionare acces pt subadmini
	restrictioneazaAccesSubadmini();
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/abonati_newsletter.tpl";
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@actiune pentru stergerea unui produs din newsletter
	if(isset($_GET["actiune"]) && $_GET["actiune"]=="sterge" && is_numeric($_GET["id_newsletter"]) && !empty($_GET["id_newsletter"]))
	{
		arrayDeleteFromDB("t_newsletter", array("id_newsletter"), array($_GET["id_newsletter"]));
		$mesaj="Abonatul a fost sters din newsletter!";
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");
	
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_newsletter) AS nr FROM t_newsletter",
						    URL_ADMIN."abonati_newsletter.php?pag=".PATTERN); 
	$paginare_string=$paginare->doPaginare();

	//-------------------------------------------------------------------------------------------------------------------------------------
	//@afisare abonati newsletter
	$arr_abonati=arrayFromDB("*", "t_newsletter", "ORDER BY contor DESC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("paginare", $paginare_string);
	$smarty->assign("arr_abonati", $arr_abonati);
	
	require_once("right.php");
	require_once("bottom.php");
?>