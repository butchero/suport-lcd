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
	require_once("../functii/f_securitate.php");
	require_once("../clase/gestioneazaFiltre.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/gestioneaza_filtre.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@check id_categorie
	if(!empty($_REQUEST["cat"]) && is_numeric($_REQUEST["cat"]))
		$id_cat=$_REQUEST["cat"];
	
	$arr_categorie=arrayFromDB("*", "t_categorii", "WHERE id_cat='".$id_cat."'");
	$nume_cat=stringLimit($arr_categorie[0]["nume_cat"], 40);
	
	if(count($arr_categorie)!=1)
		die("Categoria de editat nu exista !");

	//---------------------------------------------------------------------------------------------------------------------------------	
	//@instantiez clasa gestioneazaFiltre
	$gestioneazaFiltre=new gestioneazaFiltre($id_cat);	
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//ACTIUNE FILTRE
	
	//@adauga filtru nou
	if(isset($_POST["nume_filtru_nou"]))
	{
		$nume_filtru_nou=$_POST["nume_filtru_nou"];
		$este_filtru=(isset($_POST["este_filtru"]))?1:0;
		$nr_valori=count($_POST["valori"]);

		if(isset($_POST["increment"]))
			$nr_valori++;
		else
			if(isset($_POST["decrement"]))
				$nr_valori--;

		$valori=array();

		for($i=0;$i<$nr_valori;$i++)
			$valori[]=$_POST["valori"][$i];
			
		if($_POST["adauga_filtru_nou"])
		{
			$gestioneazaFiltre->adaugaFiltru($nume_filtru_nou, $este_filtru, $valori);
			$mesaj=$gestioneazaFiltre->getMesaj();
			unset($nume_filtru_nou, $este_filtru, $valori);
		}
	}
	
	//@modifica nume filtru si seteaza afisare filtru on/off
	if(isset($_POST["modifica"]) && is_numeric($_POST["id_filtru"]) && !empty($_POST["id_filtru"]))
	{
		$afiseaza_filtru=(isset($_POST["este_filtru"]))?1:0;
		$gestioneazaFiltre->modificaFiltru($_POST["nume_filtru"], $_POST["id_filtru"], $afiseaza_filtru);
		$mesaj=$gestioneazaFiltre->getMesaj();	
	}
	
	//@modifica/sterge o valoare din filtru	
	if(is_numeric($_GET["id_val"]) && is_numeric($_GET["id_filtru"]) && !empty($_GET["id_filtru"]) && ($_GET["actiune"]=="modifica" || $_GET["actiune"]=="sterge"))
	{		
		$gestioneazaFiltre->modificaValoare($_POST["valori_posibile"][$_GET["id_val"]], $_GET["id_filtru"], $_GET["id_val"], ($_GET["actiune"]=="sterge")?true:false);		
		$mesaj=$gestioneazaFiltre->getMesaj();
	}
		
	//@salveaza toti parametrii/valorile filtrului
	if(isset($_POST["salveaza"]) && is_numeric($_POST["id_filtru"]) && !empty($_POST["id_filtru"]))
	{
		$afiseaza_filtru=(isset($_POST["este_filtru"]))?1:0;				
		$gestioneazaFiltre->modificaFiltru($_POST["nume_filtru"], $_POST["id_filtru"], $afiseaza_filtru);
		$nr_valori_posibile=count($_POST["valori_posibile"]);		
		
		for($i=0;$i<$nr_valori_posibile;$i++)				
			$gestioneazaFiltre->modificaValoare($_POST["valori_posibile"][$i], $_POST["id_filtru"], $i, false);		
		
		if(isset($_POST["valoare_noua"]) && !empty($_POST["valoare_noua"]))	
			$gestioneazaFiltre->adaugaValoare($_POST["valoare_noua"], $_POST["id_filtru"]);		
			
		$mesaj=$gestioneazaFiltre->getMesaj();
	}
	
	//@sterge un filtru complet
	if(isset($_POST["sterge"]) && is_numeric($_POST["id_filtru"]) && !empty($_POST["id_filtru"]))
	{			
		$gestioneazaFiltre->stergeFiltru($_POST["id_filtru"]);	
		$mesaj=$gestioneazaFiltre->getMesaj();
	}
	
	//@adaug o valoare noua in filtru
	if(isset($_POST["valoare_noua"]) && !empty($_POST["valoare_noua"]) && is_numeric($_POST["id_filtru"]) && !empty($_POST["id_filtru"]))
	{
		$gestioneazaFiltre=new gestioneazaFiltre($id_cat);
		$gestioneazaFiltre->adaugaValoare($_POST["valoare_noua"], $_POST["id_filtru"]);
		
		$mesaj=$gestioneazaFiltre->getMesaj();
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------	
	//FILTRE
	
	//@stochez in array-ul $filtre toate caractericile/filtrele si valori aferente pt categoria data
	$filtre=$gestioneazaFiltre->getFiltre();
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("nume_filtru_nou", $nume_filtru_nou);
	$smarty->assign("este_filtru", $este_filtru);
	$smarty->assign("nume_cat", $nume_cat);
	$smarty->assign("filtre", $filtre);
	$smarty->assign("id_cat", $id_cat);
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("valori", $valori);
	
	require_once("right.php");
	require_once("bottom.php");
?>