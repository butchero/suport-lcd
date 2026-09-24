<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2008       		   **
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
	$display_page="admin/gestioneaza_liste_discount.tpl";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune incarca lista
	if(isset($_POST["incarca"]) && is_numeric($_POST["id_lista"]))
	{
		$arr_lista_discounturi=arrayFromDB("*", "t_liste_discount_categorii", "WHERE id_lista='".$_POST["id_lista"]."'");
		
		foreach($arr_lista_discounturi as $key=>$value)
		{
			arrayUpdateToDB("t_categorii", array("discount"), array($value["discount"]), array("id"=>"id_cat", "valoare"=>$value["id_cat"]));
		}

		arrayUpdateToDB("t_liste_discount", array("ultima_lista_folosita"), array("0"));
		arrayUpdateToDB("t_liste_discount", array("ultima_lista_folosita"), array("1"), array("id"=>"id_lista", "valoare"=>$_POST["id_lista"]));
		
		$mesaj="Lista a fost incarcata cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune adaugare lista
	if(isset($_POST["adauga_lista_discount"]))
	{
		if(empty($_POST["nume_lista_discount"]))
			$mesaj="Numele listei nu poate fi nul!";
			
		$arr_check=arrayFromDB("*", "t_liste_discount", "WHERE nume_lista='".$_POST["nume_lista_discount"]."' AND id_lista!='".$_POST["id_lista"]."'");
		
		if(count($arr_check)==1)
			$mesaj="Exista deja o lista cu acest nume!";	

		if(empty($mesaj))
		{		
			arrayInsertToDB("t_liste_discount", array("nume_lista"), array($_POST["nume_lista_discount"]));
			$mesaj="Lista a fost adaugata cu succes!";		
		}
	}	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare lista
	if(isset($_POST["modifica"]) && is_numeric($_POST["id_lista"]))
	{
		if(empty($_POST["nume_lista_discount"]))
			$mesaj="Numele listei nu poate fi nul!";
			
		$arr_check=arrayFromDB("*", "t_liste_discount", "WHERE nume_lista='".$_POST["nume_lista_discount"]."' AND id_lista!='".$_POST["id_lista"]."'");
		
		if(count($arr_check)==1)
			$mesaj="Exista deja o lista cu acest nume!";

		if(empty($mesaj))
		{
			arrayUpdateToDB("t_liste_discount",
							array("nume_lista"),
							array($_POST["nume_lista_discount"]),
							array("id"=>"id_lista", "valoare"=>$_POST["id_lista"]));

			$mesaj="Lista a fost modificata cu succes!";
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere lista
	if(is_numeric($_GET["id_lista"]) && !empty($_GET["id_lista"]) && $_GET["actiune"]=="sterge")
	{
		arrayDeleteFromDB("t_liste_discount", array("id_lista"), array($_GET["id_lista"]));
		arrayDeleteFromDB("t_liste_discount_categorii", array("id_lista"), array($_GET["id_lista"]));
		
		$mesaj="Lista a fost stearsa cu succes!";
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez listele de discount
	$arr_liste_discount=arrayFromDB("*", "t_liste_discount", "ORDER BY id_lista ASC");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@liste combobox
	foreach($arr_liste_discount as $key=>$value)
		$liste_combobox[$value["id_lista"]]=$value["nume_lista"];
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@arbore categorii
	$toate_categoriile=new arboreComplet(0, 0, $arr_toate_cat);
	$arr_categ=$toate_categoriile->getArboreComplet();		
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@lista selectata
	if(isset($_POST["lista_discount"]) && is_numeric($_POST["lista_discount"]) && !empty($_POST["lista_discount"]))
	{
		$lista_selectata=$_POST["lista_discount"];
	
		foreach($arr_categ as $key=>$value)
		{
			$arr_discount=arrayFromDB("*", "t_liste_discount_categorii", "WHERE id_lista='".$lista_selectata."' AND id_cat='".$value["id_cat"]."'");
			
			if(empty($arr_discount[0]["discount"]))
			{
				$arr_discounturi_cat[]=0;
				
				if(isset($_POST["salveaza_discounturi"]))
				{
					arrayInsertToDB("t_liste_discount_categorii", 
									array("id_lista", "id_cat", "discount"),
									array($lista_selectata, $value["id_cat"], $_POST["discounturi"][$key]));
				}
			}
			else	
			{
				$arr_discounturi_cat[]=$arr_discount[0]["discount"];
				
				if(isset($_POST["salveaza_discounturi"]))
				{
					arrayUpdateToDB("t_liste_discount_categorii", 
									array("discount"),
									array($_POST["discounturi"][$key]),
									array("id"=>"id_discount", "valoare"=>$arr_discount[0]["id_discount"]));
				}
			}
		}
		
		if(isset($_POST["salveaza_discounturi"]))
		{
			$mesaj="Lista a fost salvata cu succes!";	
			unset($lista_selectata);		
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("liste_discount", $arr_liste_discount);
	$smarty->assign("lista_selectata", $lista_selectata);
	$smarty->assign("liste_combobox", $liste_combobox);
	$smarty->assign("toate_categ", $arr_categ);
	$smarty->assign("discounturi_cat", $arr_discounturi_cat);

	require_once("right.php");
	require_once("bottom.php");
?>