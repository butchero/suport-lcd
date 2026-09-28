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
	$display_page="admin/adauga_categorie.tpl";
	
	//@formular trimis spre validare 1/0
	$form_submit=0; //netrimis
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@check id_parinte
	if(isset($_GET["cat"]) && is_numeric($_GET["cat"]) && !empty($_GET["cat"]))
	{
		$id_parinte=$_GET["cat"];
		$arr_parinte=arrayFromDB(array("nume_cat"), "t_categorii", "WHERE id_cat='".$id_parinte."'");
	}
	else $id_parinte=0;
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiunea pentru adaugarea unei noi categorii
	if(isset($_POST["adauga_categorie"]) || !empty($_POST["nume_cat"]))
	{
		//@formular trimis spre validare
		$form_submit=1; //trimis
		
		require_once("../clase/valideazaCategorie.php");
		
		$validare=new valideazaCategorie();
		
		$categorie_check=$validare->valideazaCamp($_POST["nume_cat"], "categorie");		
		$descriere_check=$validare->valideazaDescriere($_POST["descriere_cat"]);
		
		if($_GET["adauga"]!="producator")
		{
			$discount_check=$validare->valideazaDiscount($_POST["discount"]);		
			$limite_preturi_check=$validare->valideazaLimitePreturi($_POST["limite_preturi"]);
		}
		
		$link_cat=(!empty($_POST["link_cat"]))?prepareLink($_POST["link_cat"]):prepareLink($_POST["nume_cat"]);
		$link_check=$validare->valideazaLinkCat($link_cat);
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@daca campul categorie a fost completat
		if($validare->getErori()==0)
		{			
			//@aflu ultimul numar de ordine
			$arr_nr_ordine=arrayFromDB(array("MAX(nr_ordine) AS ultimul"), "t_categorii", "WHERE id_parinte='".$id_parinte."'");
			
			//@adaug categoria in bd
			$id_inserat=arrayInsertToDB("t_categorii",
										array("nume_cat", "link_cat", "id_parinte", "producator", "nr_ordine", "descriere_cat", "nr_produse", "discount", "filtre_preturi"),
										array($categorie_check["camp"], $link_check["camp"], $id_parinte, (($_GET["adauga"]=="producator")?1:0), $arr_nr_ordine[0]["ultimul"]+1, nl2br($descriere_check["camp"]), 0, $discount_check["camp"], $limite_preturi_check["camp"]));

			require("../functii/f_admin.php");
			
			if($_POST["do_resize"]==1)
			{				
				//@adaug poza categoriei - resize in thumb + medium
				adaugaPozaCategorie("poza_cat", $id_inserat);
			}
			else 
			{	
				//@adaug poza categoriei - no resize
				adaugaPozaCategorieNoResize("poza_cat_thumb", "poza_cat_medium", $id_inserat);
			}
							 
			header("Location:".URL_ADMIN."adauga_categorie.php?".((isset($_GET["adauga"]) && $_GET["adauga"]=="producator")?"adauga=producator&":"")."cat_adaugata=true&cat=".$id_parinte);						 						  			
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$adauga=isset($_GET["adauga"]) ? $_GET["adauga"] : "";
	$check_gol=array("valid"=>"", "camp"=>"", "eroare"=>"");
	if(!isset($categorie_check)) $categorie_check=$check_gol;
	if(!isset($descriere_check)) $descriere_check=$check_gol;
	if(!isset($discount_check)) $discount_check=$check_gol;
	if(!isset($limite_preturi_check)) $limite_preturi_check=$check_gol;
	if(!isset($link_check)) $link_check=$check_gol;
	$smarty->assign("adauga", $adauga);
	$smarty->assign("form_submit", $form_submit);
	$smarty->assign("url_form", URL_ADMIN."adauga_categorie.php?cat=".$id_parinte."&adauga=".$adauga);
	$smarty->assign("nume_parinte", isset($arr_parinte[0]["nume_cat"]) ? $arr_parinte[0]["nume_cat"] : "");
	$smarty->assign("categorie_check", $categorie_check);
	$smarty->assign("descriere_check", $descriere_check);		
	$smarty->assign("discount_check", $discount_check);
	$smarty->assign("limite_preturi_check", $limite_preturi_check);
	$smarty->assign("link_check", $link_check);
	
	
	$smarty->assign("mesaj", (isset($_GET["cat_adaugata"]) && $_GET["cat_adaugata"]=="true")?"Categoria a fost adaugata !":"");
	
	require_once("right.php");
	require_once("bottom.php");
?>