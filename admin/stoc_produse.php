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
	$display_page="admin/stoc_produse.tpl";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune adaugare transport
	if(isset($_POST["adauga_stoc"]))
	{
		if(empty($_POST["stoc"]))
			$mesaj="Stocul/Disponibilitatea nu poate fi nul(a)!";

		if(empty($mesaj))
		{		
			arrayInsertToDB("t_stoc", array("stoc"), array($_POST["stoc"]));
			$mesaj="Stocul/Disponibilitatea a fost adaugata cu succes!";		
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare transport
	if(isset($_POST["modifica"]) && is_numeric($_POST["id_stoc"]))
	{
		if(empty($_POST["stoc"]))
			$mesaj="Stocul/Disponibilitatea nu poate fi nul(a)!";

		if(empty($mesaj))
		{
			arrayUpdateToDB("t_stoc",
							array("stoc"),
							array($_POST["stoc"]),
							array("id"=>"id_stoc", "valoare"=>$_POST["id_stoc"]));

			$mesaj="Modificarea stocului/disponibilitatii a fost realizata cu succes!";
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere transport
	if(isset($_GET["id_stoc"]) && is_numeric($_GET["id_stoc"]) && !empty($_GET["id_stoc"]) && isset($_GET["actiune"]) && $_GET["actiune"]=="sterge")
	{
		//@verific daca transportul selectat pt stergere este folosit la vreo comanda data - daca da, stergerea nu va avea loc
		$arr_check=arrayFromDB(array("COUNT(t_produse.id_produs) AS nr_produse"),
							   "t_stoc LEFT JOIN t_produse ON t_stoc.id_stoc=t_produse.stoc",
							   "WHERE t_stoc.id_stoc='".$_GET["id_stoc"]."' GROUP BY t_stoc.id_stoc");

		if($arr_check[0]["nr_produse"]==0)
		{
			arrayDeleteFromDB("t_stoc", array("id_stoc"), array($_GET["id_stoc"]));
			$mesaj="Stocul/Disponibilitatea a fost stearsa cu succes!";
		}
		else
		{
			$mesaj="Stocul/Disponibilitatea nu a putut fi stearsa deoarece este folosita de produse!";
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez stocurile disponibile
	$arr_stoc=arrayFromDB("*", "t_stoc", "ORDER BY stoc ASC");

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("stoc", $arr_stoc);
	if(!isset($mesaj)) $mesaj="";
	$smarty->assign("mesaj", $mesaj);

	require_once("right.php");
	require_once("bottom.php");
?>