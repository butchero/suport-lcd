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
	require_once("../top.php");
	require_once("../left.php");		
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Contul meu";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/contul_meu.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@fisiere download
	$arr_foldere=citesteDir(URL_BASE_ABS."fisiere");
	
	$foldere=array();

	if(is_array($arr_foldere))
	foreach($arr_foldere as $key=>$value)
	{
		$arr_fisiere=citesteDir(URL_BASE_ABS."fisiere/".$value);
		
		$foldere[]=array("nume_folder"=>$value, "fisiere"=>$arr_fisiere);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@tree fisiere download
	$smarty->assign("foldere", $foldere);
	
	//@dupa logare link la pagina precedenta, pe care era utilizatorul
	$smarty->assign("pagina_precedenta", isset($_SESSION["pagina_precedenta"]) ? $_SESSION["pagina_precedenta"] : "");
	
	require_once("../right.php");
	require_once("../bottom.php");
?>