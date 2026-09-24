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
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@toate categoriile
	$arr_toate_cat=arrayFromDB("*", "t_categorii", "WHERE producator='0' ORDER BY nr_ordine ASC");	
	$arr_toate_cat_dupa_id=array();
	
	foreach($arr_toate_cat as $value)
		$arr_toate_cat_dupa_id[$value["id_cat"]]=array("id_cat"=>$value["id_cat"], "nume_cat"=>$value["nume_cat"], "link_cat"=>$value["link_cat"], "id_parinte"=>$value["id_parinte"], "producator"=>$value["producator"], "nr_ordine"=>$value["nr_ordine"], "descriere_cat"=>$value["descriere_cat"], "nr_produse"=>$value["nr_produse"], "activ"=>$value["activ"], "discount"=>$value["discount"], "filtre_preturi"=>$value["filtre_preturi"]);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@proceseaza requestul -  functia e definita in f_admin.php
	if(toggleCategoriiActivare($_GET["id_cat"], $_GET["activ"]))
		print $_GET["activ"];
	else print -1;	
?>