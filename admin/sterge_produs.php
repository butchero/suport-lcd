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
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@basic check
	if(!is_numeric($_GET["id_produs"]) || empty($_GET["id_produs"]))
		die("Produs invalid!");
	
	$id_produs=$_GET["id_produs"];		
		
	if(is_numeric($_GET["cat"]) && !empty($_GET["cat"]))
	{	
		$id_cat=$_GET["cat"];
	}
	else
	{
		$arr_produs=arrayFromDB(array("id_cat"), "t_produse", "WHERE id_produs='".$id_produs."'");
		$id_cat=$arr_produs[0]["id_cat"];
	}
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@toate categoriile
	$arr_toate_cat=arrayFromDB("*", "t_categorii", "WHERE producator='0' ORDER BY nr_ordine ASC");	
	$arr_toate_cat_dupa_id=array();
	
	foreach($arr_toate_cat as $value)
		$arr_toate_cat_dupa_id[$value["id_cat"]]=array("id_cat"=>$value["id_cat"], "nume_cat"=>$value["nume_cat"], "link_cat"=>$value["link_cat"], "id_parinte"=>$value["id_parinte"], "producator"=>$value["producator"], "nr_ordine"=>$value["nr_ordine"], "descriere_cat"=>$value["descriere_cat"], "nr_produse"=>$value["nr_produse"], "activ"=>$value["activ"], "discount"=>$value["discount"], "filtre_preturi"=>$value["filtre_preturi"]);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@construiesc link-ul de redirectare
	if(empty($_GET["string"]))
		$url_redirect=URL_ADMIN."catalog.php?cat=".$id_cat;
	else $url_redirect=URL_ADMIN."cauta_produs.php?string=".$_GET["string"];	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//STERGE PRODUS
	if(stergeProdus($id_produs))
		$url_redirect.="&produs_sters=true";
	else $url_redirect.="&produs_sters=false";	
	
	header("Location:".$url_redirect);
?>