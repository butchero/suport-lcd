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
	$display_page="admin/gestioneaza_bannere_cat.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@check id_categorie
	if(isset($_GET["cat"]) && is_numeric($_GET["cat"]) && !empty($_GET["cat"]))
		$id_cat=$_GET["cat"];
	
	$arr_cat_bannere=arrayFromDB("*", "t_categorii", "WHERE id_cat='".$id_cat."'");
	
	if(count($arr_cat_bannere)!=1)
		die("Categoria pentru care doriti sa gestionati bannerele nu exista!");
		
	$nume_cat_bannere=$arr_cat_bannere[0]["nume_cat"];	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere banner
	if(isset($_GET["id_banner"]) && !empty($_GET["id_banner"]) && is_numeric($_GET["id_banner"]) && $_GET["actiune"]=="sterge")
	{
		$id_banner=$_GET["id_banner"];
		$arr_banner=arrayFromDB("*", "t_bannere_categorii", "WHERE id_banner='".$id_banner."'");
		
		@unlink(URL_BASE_ABS."bannere_cat/".$arr_banner[0]["fisier"]);
		arrayDeleteFromDB("t_bannere_categorii", array("id_banner"), array($id_banner));
		$mesaj="Bannerul a fost sters cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune adaugare banner
	if(isset($_POST["adauga_banner"]))
	{
		$nume_banner=$_POST["nume_banner"];
		$link_banner=$_POST["link_banner"];
		$rata_aparitie=$_POST["rata_aparitie"];
		
		$extensie_banner=strtolower(getExtensieFisier($_FILES["banner"]["name"]));
		
		//@verificari
		if(empty($nume_banner))
			$mesaj[]="Nu ati completat numele bannerului!";
		if(empty($link_banner))
			$mesaj[]="Nu ati completat link-ul bannerului!";	
		if(!in_array($extensie_banner, $arr_extensii_valide))
			$mesaj[]="Extensia fisierului nu este o extensie valida: ".implode(", ", $arr_extensii_valide)."!";
		if(!is_numeric($rata_aparitie) || $rata_aparitie<0 || $rata_aparitie>100)
			$mesaj[]="Rata de aparitie trebuie sa fie cuprinsa intre 0% si 100%!";
			
		if(empty($mesaj))
		{				
			$id_banner_nou=arrayInsertToDB("t_bannere_categorii",
											array("id_cat", "nume_banner", "link_banner", "rata_aparitie"),
											array($id_cat, $nume_banner, $link_banner, $rata_aparitie));	

			arrayUpdateToDB("t_bannere_categorii", array("fisier"), array($id_banner_nou.".".$extensie_banner), array("id"=>"id_banner", "valoare"=>$id_banner_nou));
														
			@move_uploaded_file($_FILES["banner"]["tmp_name"], URL_BASE_ABS."bannere_cat/".$id_banner_nou.".".$extensie_banner);
			$mesaj="Bannerul pentru categoria \"".$nume_cat_bannere."\" a fost adaugat cu succes!";
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
		$rata_aparitie=$_POST["rata_aparitie"];
		
		$extensie_banner=strtolower(getExtensieFisier($_FILES["banner"]["name"]));
		
		//@verificari
		if(empty($nume_banner))
			$mesaj[]="Nu ati completat numele bannerului!";
		if(empty($link_banner))
			$mesaj[]="Nu ati completat link-ul bannerului!";	
		if(!empty($_FILES["banner"]["name"]) && !in_array($extensie_banner, $arr_extensii_valide))
			$mesaj[]="Extensia fisierului nu este o extensie valida: ".implode(", ", $arr_extensii_valide)."!";
		if(!is_numeric($rata_aparitie) || $rata_aparitie<0 || $rata_aparitie>100)
			$mesaj[]="Rata de aparitie trebuie sa fie cuprinsa intre 0% si 100%!";	
			
		if(empty($mesaj))
		{
			$nume_fisier=$id_banner.".".$extensie_banner;
			$arr_banner=arrayFromDB(array("fisier"), "t_bannere_categorii", "WHERE id_banner='".$id_banner."'");
			(!empty($_FILES["banner"]["name"]))?@unlink(URL_BASE_ABS."bannere_cat/".$arr_banner[0]["fisier"]):$nume_fisier=$arr_banner[0]["fisier"];
			
			arrayUpdateToDB("t_bannere_categorii",
							 array("id_cat", "nume_banner", "link_banner", "fisier", "rata_aparitie"),
						 	 array($id_cat, $nume_banner, $link_banner, $nume_fisier, $rata_aparitie),
						 	 array("id"=>"id_banner", "valoare"=>$id_banner));
														
			move_uploaded_file($_FILES["banner"]["tmp_name"], URL_BASE_ABS."bannere_cat/".$id_banner.".".$extensie_banner);
			$mesaj="Bannerul pentru categoria \"".$nume_cat_bannere."\" a fost modificat cu succes!";
		}
		else 
		{
			$mesaj=implode("<br />", $mesaj);
		}		
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@afisare bannere existente
	$arr_bannere=arrayFromDB("*", "t_bannere_categorii", "WHERE id_cat='".$id_cat."' ORDER BY id_banner ASC");

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	if(!isset($mesaj)) $mesaj="";
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("cat", $id_cat);
	$smarty->assign("nume_cat_bannere", $nume_cat_bannere);
	$smarty->assign("bannere", $arr_bannere);
	$smarty->assign("timestamp", time());
	
	require_once("right.php");
	require_once("bottom.php");
?>