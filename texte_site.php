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
		
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="texte_site.tpl";
	
	$arr_texte=arrayFromDB("*", "t_texte_site", "WHERE sectiune='".prepareStringToDB($_GET["sectiune"])."'");
	
	//----------------------------------------------------------------------------------------------------------------------
	//@verific daca pagina exista in bd, in caz contrar -> eroare 404 customizata
	if(count($arr_texte)!=1)
	{
		header("HTTP/1.0 404 Not Found");
		$display_page="404.tpl";
		
		require_once("right.php");
		require_once("bottom.php");
		
		exit;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina=strtoupper(str_replace("_", " ", $arr_texte[0]["sectiune"]));
	
	//-----------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("text_sectiune", $arr_texte[0]["text"]);
	
	
	require_once("right.php");
	require_once("bottom.php");
?>