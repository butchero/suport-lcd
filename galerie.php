<?
	/*
	 *****************************************************************************
	 *****************************************************************************
	 **                                                                         **
	 **          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2007       		**
	 **                                                                         **
	 *****************************************************************************
	 *****************************************************************************
	*/
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("conectare.php");
	require_once("configurare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("functii/f_securitate.php");
	require_once("functii/f_bd.php");
	require_once("functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	require_once("smarty_connect.php");
	
	if(!is_numeric($_GET["id_produs"]))
		die("Nu exista galerie asociata acestui produs!");
	
	$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".prepareStringToDB($_GET["id_produs"])."'");
	
	$poza=$_GET["poza"];
	
	if(strpos($poza, "/medii/")!==false)
		$poza=str_replace("/medii/", "/supermari/", $_GET["poza"]);
	elseif(strpos($poza, "/mari/")!==false)
		$poza=str_replace("/mari/", "/supermari/", $_GET["poza"]);
	else $poza=$_GET["poza"];	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@galerie
	$arr_galerie=genereazaGalerie($arr_produs[0]["id_produs"]);
	
	$poze_sec_medii=$arr_galerie["medii"];
	$poze_sec_supermari=$arr_galerie["supermari"];	

	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("nume_produs", $arr_produs[0]["nume_produs"]);
	
	$smarty->assign("poze_sec_medii", $poze_sec_medii);
	$smarty->assign("poze_sec_supermari", $poze_sec_supermari);
	$smarty->assign("poza", $poza);
	
	//@nume_firma
	$smarty->assign("NUME_FIRMA", NUME_FIRMA);
	
	$smarty->display("galerie.tpl");
?>