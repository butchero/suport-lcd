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
	require_once("../functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@proceseaza requestul -  functia e definita in f_admin.php
	if(is_numeric($_GET["id_user"]) && is_numeric($_GET["flag"]))
	{
		arrayUpdateToDB("t_useri",
						 array("flag"), array($_GET["flag"]),
						 array("id"=>"id_user", "valoare"=>$_GET["id_user"]));
						 
		print ($_GET["flag"]==1)?"<b>Flag setat</b>":"<b>Flag scos</b>";		
	}
	else print -1;	
?>