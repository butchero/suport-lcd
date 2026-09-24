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
	//@basic check
	if(!is_numeric($_GET["cat"]))
		die("Categorie invalida!");
	
	$id_cat=$_GET["cat"];	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@aflu parintele categoriei pentru a face redirectul un nivel mai sus de categorie
	$arr_parinte_cat=arrayFromDB(array("id_parinte", "producator"), "t_categorii", "WHERE id_cat='".$id_cat."'");
	
	$id_parinte=$arr_parinte_cat[0]["id_parinte"];
	$producator=$arr_parinte_cat[0]["producator"];
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@toate categoriile
	$arr_toate_cat=arrayFromDB("*", "t_categorii", "WHERE producator='0' ORDER BY nr_ordine ASC");	
	$arr_toate_cat_dupa_id=array();
	
	foreach($arr_toate_cat as $value)
		$arr_toate_cat_dupa_id[$value["id_cat"]]=array("id_cat"=>$value["id_cat"], "nume_cat"=>$value["nume_cat"], "link_cat"=>$value["link_cat"], "id_parinte"=>$value["id_parinte"], "producator"=>$value["producator"], "nr_ordine"=>$value["nr_ordine"], "descriere_cat"=>$value["descriere_cat"], "nr_produse"=>$value["nr_produse"], "activ"=>$value["activ"], "discount"=>$value["discount"], "filtre_preturi"=>$value["filtre_preturi"]);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@construiesc link-ul de redirectare
	$url_redirect=URL_ADMIN."catalog.php?";
	
	if($id_parinte==0 && $producator==0)
		$url_redirect.="edit=categorii_principale";
	elseif($id_parinte==0 && $producator==1)
		$url_redirect.="edit=producatori";
	else $url_redirect.="cat=".$id_parinte;	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@sterge categorie - functia e de definita in "f_admin.php"
	if(stergeCategorie($id_cat))
		$url_redirect.="&cat_stearsa=true";
	else $url_redirect.="&cat_stearsa=false";
	
	header("Location:".$url_redirect);
?>