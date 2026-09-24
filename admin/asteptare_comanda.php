<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2008       		   **
	**                                                                         **
	*****************************************************************************
	*****************************************************************************
	*/
	session_name("admin");
	session_start();
	
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");	
	require_once("../functii/f_bd.php");
	require_once("../functii/f_admin.php");	
	require_once("../init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@basic check
	if(!is_numeric($_GET["id_comanda"]))
		die("Comanda invalida!");
	
	$id_comanda=$_GET["id_comanda"];	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@construiesc link-ul de redirectare
	$url_redirect=URL_ADMIN."comenzi_noi.php?comanda_asteptare=true&id_comanda=".$id_comanda.((!empty($_GET["stare"]))?"&stare=".$_GET["stare"]:"");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ANULEAZA COMANDA
	arrayUpdateToDB("t_comenzi", array("stare", "nota_admin"), array("4", $_POST["nota_admin"]), array("id"=>"id_comanda", "valoare"=>$id_comanda));
	
	header("Location:".$url_redirect);
?>