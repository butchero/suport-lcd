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
	$display_page="admin/gestioneaza_bannere.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere banner
	if(isset($_GET["id_banner"]) && !empty($_GET["id_banner"]) && is_numeric($_GET["id_banner"]) && $_GET["actiune"]=="sterge")
	{
		$id_banner=$_GET["id_banner"];
		$arr_banner=arrayFromDB("*", "t_bannere", "WHERE id_banner='".$id_banner."'");
		
		@unlink(URL_BASE_ABS."bannere/".$arr_banner[0]["fisier"]);
		arrayDeleteFromDB("t_bannere", array("id_banner"), array($id_banner));
		$mesaj="Bannerul a fost sters cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune adaugare banner
	if(isset($_POST["adauga_banner"]))
	{
		$nume_banner=$_POST["nume_banner"];
		$link_banner=$_POST["link_banner"];
		$extensie_banner=strtolower(getExtensieFisier($_FILES["banner"]["name"]));
		
		//@verificari
		if(empty($nume_banner))
			$mesaj[]="Nu ati completat numele bannerului!";
		if(empty($link_banner))
			$mesaj[]="Nu ati completat link-ul bannerului!";	
		if(!in_array($extensie_banner, $arr_extensii_valide))
			$mesaj[]="Extensia fisierului nu este o extensie valida: ".implode(", ", $arr_extensii_valide)."!";
			
		if(empty($mesaj))
		{	
			$arr_ultimul=arrayFromDB(array("MAX(nr_ordine)+1 AS ultimul"), "t_bannere");
			$ultimul=$arr_ultimul[0]["ultimul"];
			
			if(empty($ultimul) || !is_numeric($ultimul))
				$ultimul=1;
			
			$id_banner_nou=arrayInsertToDB("t_bannere",
											array("nume_banner", "link_banner", "nr_ordine"),
											array($nume_banner, $link_banner, $ultimul));	

			arrayUpdateToDB("t_bannere", array("fisier"), array($id_banner_nou.".".$extensie_banner), array("id"=>"id_banner", "valoare"=>$id_banner_nou));
														
			@move_uploaded_file($_FILES["banner"]["tmp_name"], URL_BASE_ABS."bannere/".$id_banner_nou.".".$extensie_banner);
			$mesaj="Bannerul a fost adaugat cu succes!";
		}
		else 
		{
			$mesaj=implode("<br />", $mesaj);
		}		
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare banner existent
	if(isset($_POST["modifica_banner"]))
	{
		$id_banner=$_POST["id_banner"];
		$nume_banner=$_POST["nume_banner"];
		$link_banner=$_POST["link_banner"];
		$nr_ordine=$_POST["nr_ordine"];
		$extensie_banner=strtolower(getExtensieFisier($_FILES["banner"]["name"]));
		
		//@verificari
		if(empty($nume_banner))
			$mesaj[]="Nu ati completat numele bannerului!";
		if(empty($link_banner))
			$mesaj[]="Nu ati completat link-ul bannerului!";	
		if(!empty($_FILES["banner"]["name"]) && !in_array($extensie_banner, $arr_extensii_valide))
			$mesaj[]="Extensia fisierului nu este o extensie valida: ".implode(", ", $arr_extensii_valide)."!";
			
		if(empty($mesaj))
		{
			$nume_fisier=$id_banner.".".$extensie_banner;
			$arr_banner=arrayFromDB(array("fisier"), "t_bannere", "WHERE id_banner='".$id_banner."'");
			(!empty($_FILES["banner"]["name"]))?@unlink(URL_BASE_ABS."bannere/".$arr_banner[0]["fisier"]):$nume_fisier=$arr_banner[0]["fisier"];
			
			arrayUpdateToDB("t_bannere",
							 array("nume_banner", "link_banner", "fisier", "nr_ordine"),
						 	 array($nume_banner, $link_banner, $nume_fisier, $nr_ordine),
						 	 array("id"=>"id_banner", "valoare"=>$id_banner));
														
			move_uploaded_file($_FILES["banner"]["tmp_name"], URL_BASE_ABS."bannere/".$id_banner.".".$extensie_banner);
			$mesaj="Bannerul a fost modificat cu succes!";
		}
		else 
		{
			$mesaj=implode("<br />", $mesaj);
		}		
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@afisare bannere existente
	$arr_bannere=arrayFromDB("*", "t_bannere", "ORDER BY nr_ordine ASC");

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("bannere", $arr_bannere);
	if(!isset($mesaj)) $mesaj="";
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("timestamp", time());
	
	require_once("right.php");
	require_once("bottom.php");
?>