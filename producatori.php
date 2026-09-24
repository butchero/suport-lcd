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
	require_once("functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="producatori.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Producatori";
	
	//@vars
	$sql_where=array();
	$caracteristici_filtrari=array();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@subcategoriile categoriei selectate/sau producatorii
	$arr_catalog=getTotiProducatorii(true, "nr_ordine", true);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@afisare toti producatorii
	$smarty->assign("catalog", $arr_catalog);
	
	require_once("right.php");
	require_once("bottom.php");
?>