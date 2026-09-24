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
	//@restrictionare acces pt subadmini
	restrictioneazaAccesSubadmini();
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/gestioneaza_transport.tpl";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune adaugare transport
	if(isset($_POST["adauga_transport"]))
	{
		if(empty($_POST["nume_transport"]))
			$mesaj[]="Transportul nu poate fi nul!";
		if(!is_numeric($_POST["cost"]))
			$mesaj[]="Costul nu este numeric!";	

		if(empty($mesaj))
		{		
			arrayInsertToDB("t_transport", array("nume_transport", "cost"), array($_POST["nume_transport"], $_POST["cost"]));
			$mesaj="Transportul a fost adaugat cu succes!";		
		}
		else 
		{
			$mesaj=implode("<br />", $mesaj);
			
			$nume_transport=$_POST["nume_transport"];
			$cost=$_POST["cost"];
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare transport
	if(isset($_POST["modifica"]) && is_numeric($_POST["id_transport"]))
	{
		if(empty($_POST["nume_transport"]))
			$mesaj[]="Transportul nu poate fi nul!";
		if(!is_numeric($_POST["cost"]))
			$mesaj[]="Costul nu este numeric!";

		if(empty($mesaj))
		{
			arrayUpdateToDB("t_transport",
							array("nume_transport", "cost"),
							array($_POST["nume_transport"], str_replace(",", ".", $_POST["cost"])),
							array("id"=>"id_transport", "valoare"=>$_POST["id_transport"]));

			$mesaj="Modificarea transportului a fost realizata cu succes!";
		}
		else 
		{
			$mesaj=implode("<br />", $mesaj);
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere transport
	if(is_numeric($_GET["id_transport"]) && !empty($_GET["id_transport"]) && $_GET["actiune"]=="sterge")
	{
		//@verific daca transportul selectat pt stergere este folosit la vreo comanda data - daca da, stergerea nu va avea loc
		$arr_check=arrayFromDB(array("COUNT(t_comenzi.id_comanda) AS nr_comenzi"),
							   "t_transport LEFT JOIN t_comenzi ON t_transport.id_transport=t_comenzi.id_transport",
							   "WHERE t_transport.id_transport='".$_GET["id_transport"]."' GROUP BY t_transport.id_transport");

		if($arr_check[0]["nr_comenzi"]==0)
		{
			arrayDeleteFromDB("t_transport", array("id_transport"), array($_GET["id_transport"]));
			$mesaj="Transportul a fost sters cu succes!";
		}
		else
		{
			$mesaj="Transportul nu a putut fi sters deoarece este folosit in comenzi!";
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez transporturile disponibile
	$arr_transport=arrayFromDB("*", "t_transport", "ORDER BY id_transport DESC");

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("nume_transport", $nume_transport);
	$smarty->assign("cost", $cost);
	$smarty->assign("transport", $arr_transport);
	$smarty->assign("mesaj", $mesaj);

	require_once("right.php");
	require_once("bottom.php");
?>