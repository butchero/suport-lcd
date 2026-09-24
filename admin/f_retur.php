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
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/f_retur.tpl";
	
	if(!isset($_GET["id_formular"]) || !is_numeric($_GET["id_formular"]) || empty($_GET["id_formular"]))
		die("ID formular invalid!");
	else $id_formular=$_GET["id_formular"];	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@text formular de retur
	$arr_texte_pagina=arrayFromDB("*", "t_texte_site", "WHERE sectiune='formular_retur'");
	
	//@date formular
	$arr_formular=arrayFromDB("*", "t_formulare_retur", "WHERE id_formular='".$id_formular."'");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@judete
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet", "ORDER BY judet ASC");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@date retur
	$arr_date_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$arr_formular[0]["id_user"]."'");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@date retur
	$nume=$arr_formular[0]["nume"];
	$nume_p_contact=$arr_formular[0]["nume_persoana_contact"];
	$oras=$arr_formular[0]["oras"];
	$nr_telefon=$arr_formular[0]["nr_telefon"];
	
	$arr_produse_temp=unserialize($arr_formular[0]["produse_defecte"]);
	$nr_linii=count($arr_produse_temp["produse"]);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@produse retur	
	for($i=0;$i<$nr_linii;$i++)
	{
		$arr_produse[$i]=array("cantitate"=>$arr_produse_temp["cantitati"][$i],
							   "produs"=>$arr_produse_temp["produse"][$i],
							   "descriere"=>$arr_produse_temp["descrieri"][$i]);							   	   
	}
		
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("SEDIUL", SEDIUL);
	$smarty->assign("text_formular_retur", $arr_texte_pagina[0]["text"]);
	
	$smarty->assign("id_formular", $_GET["id_formular"]);
	$smarty->assign("nota_admin", $arr_formular[0]["nota_admin"]);
	$smarty->assign("adresa_livrare", "Judetul ".$arr_judete[$arr_date_user[0]["id_jud"]]." - ".$arr_date_user[0]["localitate"]." - Adresa: ".$arr_date_user[0]["adresa"]." - Cod postal: ".$arr_date_user[0]["cod_postal"]);
	$smarty->assign("date_user", $arr_date_user);
	$smarty->assign("nume_persoana_contact", $nume_p_contact);
	$smarty->assign("nr_telefon", $nr_telefon);
	$smarty->assign("data_retur", date(DATA_FORMAT, $arr_formular[0]["data_trimitere"]));
	$smarty->assign("produse", $arr_produse);

	require_once("right.php");
	require_once("bottom.php");
?>