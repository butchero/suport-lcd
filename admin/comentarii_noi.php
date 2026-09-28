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
	require_once("../functii/f_catalog.php");
	require_once("../functii/f_links.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/comentarii_noi.tpl";	

	(isset($_GET["comentariu_aprobat"]) && $_GET["comentariu_aprobat"]=="true")?$mesaj="Comentariul a fost aprobat cu succes!":"";
	(isset($_GET["comentariu_sters"]) && $_GET["comentariu_sters"]=="true")?$mesaj="Comentariul a fost sters cu succes!":"";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare
	if(isset($_POST["id_edit_comentariu"]) && is_numeric($_POST["id_edit_comentariu"]) && isset($_POST["modifica"]))
	{
		arrayUpdateToDB("t_comentarii", array("comentariu"), array(nl2br($_POST["comentariu"])), array("id"=>"id_comentariu", "valoare"=>$_POST["id_edit_comentariu"]));
		$mesaj="Comentariul a fost actualizat!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune aprobare comentariu
	if(isset($_POST["id_comentariu"]) && is_numeric($_POST["id_comentariu"]) && isset($_POST["aproba"]))
	{
		arrayUpdateToDB("t_comentarii", array("activ"), array(1), array("id"=>"id_comentariu", "valoare"=>$_POST["id_comentariu"]));
		header("Location:".URL_ADMIN."comentarii_noi.php?comentariu_aprobat=true");		    
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere comentariu
	if(isset($_GET["id_comentariu"]) && is_numeric($_GET["id_comentariu"]) && $_GET["actiune"]=="sterge_comentariu")
	{
		arrayDeleteFromDB("t_comentarii", array("id_comentariu"), array($_GET["id_comentariu"]));
		header("Location:".URL_ADMIN."comentarii_noi.php?comentariu_sters=true");		    
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@editare comentariu - date pt formularul de editare
	if(isset($_POST["id_comentariu"]) && is_numeric($_POST["id_comentariu"]) && isset($_POST["editeaza"]))
	{
		$arr_comentariu=arrayFromDB("*",
								    "t_comentarii LEFT JOIN t_useri ON t_comentarii.id_user=t_useri.id_user
								    			  LEFT JOIN t_produse ON t_comentarii.id_produs=t_produse.id_produs",
								    "WHERE id_comentariu='".$_POST["id_comentariu"]."'");
								    
		$id_comentariu=$arr_comentariu[0]["id_comentariu"];
		$username_comentariu=$arr_comentariu[0]["username"];
		$comentariu=inverse_nl2br($arr_comentariu[0]["comentariu"]);
		$data_adaugarii=date(DATA_FORMAT, $arr_comentariu[0]["data_adaugarii"]);
		$nume_produs=stringLimit($arr_comentariu[0]["nume_produs"], 60, "...");				    
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");
		
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_comentariu) AS nr FROM t_comentarii 
						   		LEFT JOIN t_useri ON t_comentarii.id_user=t_useri.id_user 
						   		LEFT JOIN t_produse ON t_comentarii.id_produs=t_produse.id_produs
						   	WHERE activ='0'", 
						    URL_ADMIN."comentarii_noi.php?pag=".PATTERN.(isset($link_sufix) ? $link_sufix : ""));
						     
	$paginare_string=$paginare->doPaginare();
	$nr_rezultate=$paginare->getNrRezultate(); 
	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectare tranzactii (comenzi)
	$arr_comentarii=arrayFromDB("*",
							    "t_comentarii LEFT JOIN t_useri ON t_comentarii.id_user=t_useri.id_user
							    			  LEFT JOIN t_produse ON t_comentarii.id_produs=t_produse.id_produs",
							    "WHERE activ='0' ORDER BY id_comentariu DESC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
		
	if(is_array($arr_comentarii))
	{				    
		foreach($arr_comentarii as $key=>$value)
		{
			$comentarii[$key]["id_comentariu"]=$value["id_comentariu"];
			$comentarii[$key]["username"]=$value["username"];
			$comentarii[$key]["data_adaugarii"]=date(DATA_FORMAT, $value["data_adaugarii"]);
			$comentarii[$key]["comentariu"]=$value["comentariu"];
			$comentarii[$key]["nume_produs"]=stringLimit($value["nume_produs"], 70);
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
		
	//@afisare erori/mesaje
	if(!isset($mesaj)) $mesaj="";
	if(!isset($id_comentariu)) $id_comentariu="";
	if(!isset($username_comentariu)) $username_comentariu="";
	if(!isset($comentariu)) $comentariu="";
	if(!isset($data_adaugarii)) $data_adaugarii="";
	if(!isset($nume_produs)) $nume_produs="";
	if(!isset($comentarii) || !is_array($comentarii)) $comentarii=array();
	$smarty->assign("mesaj", $mesaj);
	
	//@date editare comentariu
	$smarty->assign("id_comentariu", $id_comentariu);	
	$smarty->assign("username_comentariu", $username_comentariu);
	$smarty->assign("comentariu", $comentariu);
	$smarty->assign("data_adaugarii", $data_adaugarii);
	$smarty->assign("nume_produs", $nume_produs);
	
	//@comentarii
	$smarty->assign("comentarii", $comentarii);
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	require_once("right.php");
	require_once("bottom.php");
?>