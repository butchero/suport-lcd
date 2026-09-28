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
	//@autorizare user logat
	require_once("autentificare.php");
	
	if(isset($_REQUEST["id_admin"]) && is_numeric($_REQUEST["id_admin"]))
	{
		$arr_check=arrayFromDB(array("super_admin"), "t_admin", "WHERE id_admin='".$_REQUEST["id_admin"]."'");
		if($arr_check[0]["super_admin"]!=0)
		{
			die("Nu sunteti autorizat sa editati/stergeti un administrator!");
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/subadmini.tpl";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune adaugare transport
	if(isset($_POST["adauga_subadmin"]))
	{
		if(empty($_POST["subadmin_username"]))
			$mesaj[]="Username-ul nu poate fi nul!";
		if(empty($_POST["subadmin_parola"]) || strlen(trim($_POST["subadmin_parola"]))<6)
			$mesaj[]="Parola trebuie sa aiba minim 6 caractere!";	

		if(empty($mesaj))
		{		
			$parola_noua=md5(trim($_POST["subadmin_parola"]));
			
			arrayInsertToDB("t_admin",
							 array("username", "parola", "super_admin"), 
							 array($_POST["subadmin_username"], $parola_noua, 0));
			$mesaj="Subadminul a fost adaugat cu succes!";		
		}
		else 
		{
			$mesaj=implode("<br />", $mesaj);
			
			$subadmin_username=$_POST["subadmin_username"];
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare transport
	if(isset($_POST["modifica"]) && is_numeric($_POST["id_admin"]))
	{
		if(empty($_POST["subadmin_username"]))
			$mesaj[]="Username-ul nu poate fi nul!";
		if(empty($_POST["subadmin_parola"]) || strlen(trim($_POST["subadmin_parola"]))<6)
			$mesaj[]="Parola trebuie sa aiba minim 6 caractere!";

		if(empty($mesaj))
		{
			$parola_noua=md5(trim($_POST["subadmin_parola"]));
			
			arrayUpdateToDB("t_admin",
							array("username", "parola"),
							array($_POST["subadmin_username"], $parola_noua),
							array("id"=>"id_admin", "valoare"=>$_POST["id_admin"]));

			$mesaj="Modificarea subadminului a fost realizata cu succes!";
		}
		else 
		{
			$mesaj=implode("<br />", $mesaj);
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere admin
	if(isset($_GET["id_admin"]) && is_numeric($_GET["id_admin"]) && !empty($_GET["id_admin"]) && isset($_GET["actiune"]) && $_GET["actiune"]=="sterge")
	{
		arrayDeleteFromDB("t_admin", array("id_admin"), array($_GET["id_admin"]));
		$mesaj="Subadminul a fost sters cu succes!";		
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez subadminiii
	$arr_subadmini=arrayFromDB("*", "t_admin", "WHERE super_admin='0' ORDER BY id_admin DESC");

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	if(!isset($subadmin_username)) $subadmin_username="";
	if(!isset($mesaj)) $mesaj="";
	$smarty->assign("subadmin_username", $subadmin_username);
	$smarty->assign("subadmini", $arr_subadmini);
	$smarty->assign("mesaj", $mesaj);

	require_once("right.php");
	require_once("bottom.php");
?>