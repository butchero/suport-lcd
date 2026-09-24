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
	require_once("../functii/f_bd.php");
	require_once("../functii/f_admin.php");	
	require_once("../functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@proceseaza requestul - functia e de definita in "f_admin.php" 
	ordoneazaFiltre($_POST["filtre_list"], $_SESSION["id_cat"]); //e definita in f_admin.php
?>