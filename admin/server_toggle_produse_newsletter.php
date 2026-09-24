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
	if(is_numeric($_GET["id_produs"]) && is_numeric($_GET["activ"]))
	{
		if($_GET["activ"]==0)
		{
			arrayDeleteFromDB("t_newsletter_config", array("id_produs"), array($_GET["id_produs"]));
			print 0;
		}
		elseif($_GET["activ"]==1)
		{
			arrayInsertToDB("t_newsletter_config", array("id_produs"), array($_GET["id_produs"]));
			print 1;
		}
	}
	else print -1;	
?>