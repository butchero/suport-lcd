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
	$display_page="admin/gestioneaza_fisiere.tpl";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@url dir upload
	$dir_foldere=URL_BASE_ABS."fisiere/";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune creare director	
	if(isset($_POST["adauga_dir"]) && !empty($_POST["nume_dir"]))
	{
		$creeaza_dir=@mkdir($dir_foldere.strtolower($_POST["nume_dir"]), 0777);
		
		if($creeaza_dir)
			$mesaj="Director creat cu succes!";
		else $mesaj="Directorul nu a putut fi creat!";	
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere director	
	if(isset($_GET["actiune"]) && $_GET["actiune"]=="sterge_folder" && !empty($_GET["folder"]))
	{
		$sterge_dir=removeDir($dir_foldere.$_GET["folder"]);
		
		if($sterge_dir)
			$mesaj="Director a fost sters cu succes!";
		else $mesaj="Directorul nu a putut fi sters!";	
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere director	
	if(isset($_GET["actiune"]) && $_GET["actiune"]=="sterge_fisier" && !empty($_GET["folder"]) && !empty($_GET["fisier"]))
	{
		$sterge_fisier=@unlink($dir_foldere.$_GET["folder"]."/".$_GET["fisier"]);
		
		if($sterge_fisier)
			$mesaj="Fisierul a fost sters cu succes!";
		else $mesaj="Fisierul nu a putut fi sters!";	
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune upload fisier in director	
	if(isset($_POST["upload"]) && !empty($_POST["dir"]))
	{
		if(move_uploaded_file($_FILES["fisier"]["tmp_name"], $dir_foldere.$_POST["dir"]."/".$_FILES["fisier"]["name"]))
			$mesaj="Fisierul a fost uploadat!";
		else $mesaj="Fisierul nu a putut fi uploadat!";	
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@citeste dir
	$foldere=citesteDir($dir_foldere);
	
	if(!empty($_GET["folder"]))	
		$fisiere_dir_selectat=citesteDir($dir_foldere.$_GET["folder"]);
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("foldere", $foldere);
	$smarty->assign("folder_selectat", $_GET["folder"]);
	$smarty->assign("fisiere_dir_selectat", $fisiere_dir_selectat);

	require_once("right.php");
	require_once("bottom.php");
?>