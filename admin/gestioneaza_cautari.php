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
	$display_page="admin/gestioneaza_cautari.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare cautare
	if(isset($_POST["modifica"]) && !empty($_POST["id_cautare"]) && is_numeric($_POST["id_cautare"]))
	{
		arrayUpdateToDB("t_cautari",
						 array("cautare", "contor"), array($_POST["cautare"], $_POST["contor"]),
						 array("id"=>"id_cautare", "valoare"=>$_POST["id_cautare"]));
		$mesaj="Cautarea a fost actualizata cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere cautare
	if(isset($_GET["id_cautare"]) && !empty($_GET["id_cautare"]) && is_numeric($_GET["id_cautare"]) && $_GET["actiune"]=="sterge")
	{
		arrayDeleteFromDB("t_cautari", array("id_cautare"), array($_GET["id_cautare"]));
		$mesaj="Cautarea a fost stearsa cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@afisare cautari facute ordonate desc dupa contor
	require_once("../clase/paginare.php");
	
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_cautare) AS nr FROM t_cautari", 
						    URL_ADMIN."gestioneaza_cautari.php?pag=".PATTERN, 10);
						    
	$paginare_string=$paginare->doPaginare();
	
	$arr_cautari=arrayFromDB("*", "t_cautari", "ORDER BY contor DESC LIMIT ".$paginare->getLimitStart().", 10");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("paginare", $paginare_string);
	$smarty->assign("cautari", $arr_cautari);
	$smarty->assign("pag", $_GET["pag"]);
	
	require_once("right.php");
	require_once("bottom.php");
?>