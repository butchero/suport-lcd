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
	$display_page="sitemap.tpl";
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@generare sitemap
	$sitemap=new arboreComplet(0, 0, $arr_toate_cat);
	$arr_sitemap=$sitemap->getArboreComplet();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="SITEMAP ".strtoupper(NUME_DOMENIU_SITE);
	
	//-----------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("sitemap", $arr_sitemap);
	
	require_once("right.php");
	require_once("bottom.php");
?>