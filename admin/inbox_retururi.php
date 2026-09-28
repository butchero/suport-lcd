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
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/inbox_retururi.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@stari posibile formulare retur
	$arr_stari_f_retur=array(0=>"Nou", 1=>"Rezolvat", 2=>"In procesare", 3=>"In curs de rez.");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@setare status formular retur
	if(isset($_REQUEST["status"]) && is_numeric($_REQUEST["status"]) && isset($_GET["id_formular"]) && is_numeric($_GET["id_formular"]) && !empty($_GET["id_formular"]))
	{
		arrayUpdateToDB("t_formulare_retur", array("status"), array($_REQUEST["status"]), array("id"=>"id_formular", "valoare"=>$_GET["id_formular"]));
		$mesaj="Formularul a fost marcat ca \"".$arr_stari_f_retur[$_REQUEST["status"]]."\"!";
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@stergere formular retur
	if(isset($_REQUEST["sterge"]) && isset($_GET["id_formular"]) && is_numeric($_GET["id_formular"]) && !empty($_GET["id_formular"]))
	{
		arrayDeleteFromDB("t_formulare_retur", array("id_formular"), array($_GET["id_formular"]));
		$mesaj="Formularul de retur a fost sters!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@variabile
	$utilizator=isset($_REQUEST["utilizator"]) ? $_REQUEST["utilizator"] : "";
	$status_selectat=isset($_REQUEST["status_formulare"]) ? $_REQUEST["status_formulare"] : "";
	
	if(!empty($_REQUEST["utilizator"]))
	{
		$sql_where.=" AND username LIKE '%".prepareStringToDB($utilizator)."%'";
		$link_sufix.="&utilizator=".$utilizator;
	}
	if(isset($_REQUEST["status_formulare"]) && is_numeric($_REQUEST["status_formulare"]))
	{
		$sql_where.=" AND a.status='".$status_selectat."'";
		$link_sufix.="&status_formulare=".$status_selectat;
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");
	
	if(!isset($sql_where)) $sql_where="";
	if(!isset($link_sufix)) $link_sufix="";
	if(!isset($mesaj)) $mesaj="";
	if(!isset($arr_f_retur) || !is_array($arr_f_retur)) $arr_f_retur=array();
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_formular) AS nr FROM t_formulare_retur AS a LEFT JOIN t_useri b ON a.id_user=b.id_user WHERE 1 ".$sql_where, 
						    URL_ADMIN."inbox_retururi.php?pag=".PATTERN.$link_sufix); 
	$paginare_string=$paginare->doPaginare();
	$nr_rezultate=$paginare->getNrRezultate();
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez formularele de retur
	$arr_formulare_retur=arrayFromDB(array("a.id_formular", "a.nr_telefon", "a.data_trimitere", "a.status", "b.nume", "b.prenume", "b.username", "b.localitate", "b.societate"),	
									 "t_formulare_retur AS a LEFT JOIN t_useri b ON a.id_user=b.id_user",
									 "WHERE 1 ".$sql_where." ORDER BY id_formular ASC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	foreach($arr_formulare_retur as $key=>$value)
	{
		$arr_f_retur[$key]["id_formular"]=$value["id_formular"];
		$arr_f_retur[$key]["nume"]=((!empty($value["societate"]))?$value["societate"]."/":"").$value["nume"]." ".$value["prenume"];
		$arr_f_retur[$key]["localitate"]=$value["localitate"];
		$arr_f_retur[$key]["nr_telefon"]=$value["nr_telefon"];
		$arr_f_retur[$key]["username"]=$value["username"];
		$arr_f_retur[$key]["data_trimitere"]=date(DATA_FORMAT, $value["data_trimitere"]);
		$arr_f_retur[$key]["status"]=$arr_stari_f_retur[$value["status"]];
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);	
	$smarty->assign("utilizator", $utilizator);
	$smarty->assign("f_retur", $arr_f_retur);
	$smarty->assign("stari", $arr_stari_f_retur);
	$smarty->assign("stare_formular_selectat", $status_selectat);
	$smarty->assign("paginare", $paginare_string);

	require_once("right.php");
	require_once("bottom.php");
?>