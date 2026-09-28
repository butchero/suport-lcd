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
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/ordoneaza_categorii.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@check id_parinte
	if(isset($_GET["id_parinte"]) && is_numeric($_GET["id_parinte"]) && !empty($_GET["id_parinte"]))
	{
		$id_parinte=$_GET["id_parinte"];
		$arr_parinte=arrayFromDB(array("nume_cat"), "t_categorii", "WHERE id_cat='".$id_parinte."'");
		$nume_parinte=$arr_parinte[0]["nume_cat"];
	}
	else
	{ 
		$id_parinte=0;
		$nume_parinte="";
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiunea pentru ordonarea default a (sub)categoriilor
	if(isset($_POST["ordoneaza_alfabetic"]))
	{
		require_once("../functii/f_catalog.php");
		
		if(isset($_GET["ordoneaza"]) && $_GET["ordoneaza"]=="producatori") //ordonare pt producatori
			$arr_categorii_de_ordonat=getTotiProducatorii(false, "nume_cat");
		else  						  //pt (sub)categorii
			$arr_categorii_de_ordonat=getSubcategorii($id_parinte, false, "nume_cat"); //al 3-lea param "nume_cat" e coloana dupa care se face ordonarea
		
		$nr_categorii_de_ordonat=count($arr_categorii_de_ordonat);
				
		for($i=0;$i<$nr_categorii_de_ordonat;$i++)
		{
			//@update nr-ul de ordine
			arrayUpdateToDB("t_categorii", array("nr_ordine"), array($i+1), array("id"=>"id_cat", "valoare"=>$arr_categorii_de_ordonat[$i]["id_cat"]));
		}
		
		//@pentru a actualiza ordinea si la meniu fac redirect
		header("Location:".URL_ADMIN."ordoneaza_categorii.php?id_parinte=".$id_parinte."&ordoneaza=".(isset($_GET["ordoneaza"]) ? $_GET["ordoneaza"] : "")."&ordoneaza_alfabetic=true");
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@categorii
	if(isset($_GET["ordoneaza"]) && $_GET["ordoneaza"]=="producatori")
	{
		require_once("../functii/f_catalog.php");
		$arr_categorii=getTotiProducatorii();
		
		//@ordoneaza='producatori' l-am pus in sesiune ca sa nu il mai transmit cu ajax catre "server_ordoneaza_categorii.php"
		$_SESSION["ordoneaza"]="producatori";
	}
	else 
	{
		$_SESSION["ordoneaza"]="";
		$arr_categorii=arrayFromDB(array("id_cat", "nume_cat"),
								   "t_categorii",
								   "WHERE id_parinte='".$id_parinte."' AND producator='0' ORDER BY nr_ordine ASC");
	}
							   
	//---------------------------------------------------------------------------------------------------------------------------------						   
	//@id_parinte l-am pus in sesiune ca sa nu il mai transmit cu ajax catre "server_ordoneaza_categorii.php"						   
	$_SESSION["id_parinte"]=$id_parinte;						   
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("categorii", $arr_categorii);
	$smarty->assign("id_parinte", $id_parinte);
	$smarty->assign("nume_parinte", $nume_parinte);
	$smarty->assign("ordoneaza", isset($_GET["ordoneaza"]) ? $_GET["ordoneaza"] : "");
	$smarty->assign("mesaj", (isset($_GET["ordoneaza_alfabetic"]) && $_GET["ordoneaza_alfabetic"]=="true")?"Ordonare alfabetica realizata cu succes!":"");
	
	require_once("right.php");
	require_once("bottom.php");
?>
