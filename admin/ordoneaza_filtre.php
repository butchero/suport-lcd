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
	$display_page="admin/ordoneaza_filtre.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@check id_parinte
	if(isset($_GET["cat"]) && is_numeric($_GET["cat"]) && !empty($_GET["cat"]))
	{
		$id_cat=$_GET["cat"];
		
		$arr_cat=arrayFromDB(array("nume_cat"), "t_categorii", "WHERE id_cat='".$id_cat."'");
		$nume_cat=$arr_cat[0]["nume_cat"];
		
		//@id_cat l-am pus in sesiune ca sa nu il mai transmit cu ajax catre "server_ordoneaza_filtre.php"
		$_SESSION["id_cat"]=$id_cat; //pt requestul ajax trimis 
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiunea pentru ordonarea default a (sub)categoriilor
	if(isset($_POST["ordoneaza_alfabetic"]))
	{
		require_once("../functii/f_catalog.php");
		
		$arr_filtre_de_ordonat=arrayFromDB("*", "t_filtre", "WHERE id_cat='".$id_cat."' ORDER BY nume_filtru ASC");
		$nr_filtre_de_ordonat=count($arr_filtre_de_ordonat);
				
		for($i=0;$i<$nr_filtre_de_ordonat;$i++)
		{
			//@update nr-ul de ordine
			arrayUpdateToDB("t_filtre", array("nr_ordine"), array($i+1), array("id"=>"id_filtru", "valoare"=>$arr_filtre_de_ordonat[$i]["id_filtru"]));
		}
		
		//@pentru a actualiza ordinea si la meniu fac redirect
		header("Location:".URL_ADMIN."ordoneaza_filtre.php?cat=".$id_cat."&ordoneaza_alfabetic=true");
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtre	
	$arr_filtre=arrayFromDB(array("id_filtru", "nume_filtru"), "t_filtre", "WHERE id_cat='".$id_cat."' ORDER BY nr_ordine ASC");
		   
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("filtre", $arr_filtre);
	$smarty->assign("nume_cat", isset($nume_cat) ? $nume_cat : "");
	$smarty->assign("mesaj", (isset($_GET["ordoneaza_alfabetic"]) && $_GET["ordoneaza_alfabetic"]=="true")?"Ordonare alfabetica realizata cu succes!":"");
	
	require_once("right.php");
	require_once("bottom.php");
?>
