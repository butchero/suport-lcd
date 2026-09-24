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
	require("../functii/f_admin.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/editeaza_categorie.tpl";
	
	$form_submit=0;
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@check id_categorie
	$id_cat=$_GET["cat"];
	
	$arr_cat_de_editat=arrayFromDB("*", "t_categorii", "WHERE id_cat='".$id_cat."'");
	
	if(count($arr_cat_de_editat)!=1)
		die("Categoria de editat nu exista!");

	$id_parinte=$arr_cat_de_editat[0]["id_parinte"];
	$nr_produse=$arr_cat_de_editat[0]["nr_produse"];
	$producator=$arr_cat_de_editat[0]["producator"];
	$discount=$arr_cat_de_editat[0]["discount"];
	
	$_POST["nume_cat"]=trim($_POST["nume_cat"]);
	$_POST["link_cat"]=trim($_POST["link_cat"]);
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune stergere poza categorie
	if($_GET["actiune"]=="sterge_poza")
	{	
		@unlink(URL_BASE_ABS."poze_categorii/".$id_cat.".jpg");
		@unlink(URL_BASE_ABS."poze_categorii/mici/".$id_cat.".jpg");
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiunea pentru modificarea unei categorii existente
	if(isset($_POST["modifica_categorie"]) || !empty($_POST["nume_cat"]))
	{
		$form_submit=1;		
		
		require_once("../clase/valideazaCategorie.php");
						
		$validare=new valideazaCategorie();
		$categorie_check=$validare->valideazaCamp($_POST["nume_cat"], "categorie");		
		$descriere_check=$validare->valideazaDescriere($_POST["descriere_cat"]);
		
		if($producator==0)
		{
			$discount_check=$validare->valideazaDiscount($_POST["discount"]);		
			$limite_preturi_check=$validare->valideazaLimitePreturi($_POST["limite_preturi"]);
		}
		
		$link_cat=(!empty($_POST["link_cat"]))?prepareLink($_POST["link_cat"]):prepareLink($_POST["nume_cat"]);
		$link_check=$validare->valideazaLinkCat($link_cat, $id_cat);					    
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@daca campul categorie a fost completat
		if($validare->getErori()==0)
		{			
			if($_POST["do_resize"]==1)
			{				
				//@adaug poza categoriei - resize in thumb + medium
				adaugaPozaCategorie("poza_cat", $id_cat);
			}
			else 
			{	
				//@adaug poza categoriei - no resize
				adaugaPozaCategorieNoResize("poza_cat_thumb", "poza_cat_medium", $id_cat);
			}
			
			//@daca categoria a fost mutata actualizez nr_produse corespunzator cu mutarea
			if($_POST["cat_parinte"]!=$id_parinte)
			{
				$arbore=new arbore($id_cat, 0, $arr_toate_cat);
				$arr_parinti_vechi=$arbore->getParintiGasiti();
				$nr_parinti_vechi=count($arr_parinti_vechi);
				
				for($i=0;$i<$nr_parinti_vechi;$i++)
					arrayUpdateToDB("t_categorii", array("nr_produse"), array("nr_produse-".$nr_produse), array("id"=>"id_cat", "valoare"=>$arr_parinti_vechi[$i]), true);					 		

				$arbore=new arbore($_POST["cat_parinte"], 0, $arr_toate_cat);
				$parinti_noi=$arbore->getParintiGasiti();
				$parinti_noi[]=$_POST["cat_parinte"];
				$nr_parinti_noi=count($parinti_noi);
				
				for($i=0;$i<$nr_parinti_noi;$i++)
					arrayUpdateToDB("t_categorii", array("nr_produse"), array("nr_produse+".$nr_produse), array("id"=>"id_cat", "valoare"=>$parinti_noi[$i]), true);					
			}
			
			//@update in bd
			arrayUpdateToDB("t_categorii",
							array("nume_cat", "link_cat", "id_parinte", "descriere_cat", "activ", "discount", "filtre_preturi"),
							array($categorie_check["camp"], $link_cat, $_POST["cat_parinte"], nl2br($descriere_check["camp"]), ($producator==1)?1:$_POST["activ"], $discount_check["camp"], $limite_preturi_check["camp"]),
							array("id"=>"id_cat", "valoare"=>$id_cat));
							 
			header("Location:".URL_ADMIN."editeaza_categorie.php?cat=".$id_cat."&cat_modificata=true");						 						  
			
		}
	}
	else //datele initiala ale categoriei
	{		
		$categorie_check=array("valid"=>1,
						       "camp"=>$arr_cat_de_editat[0]["nume_cat"],
						       "eroare"=>"");
						       
		$link_check=array("valid"=>1,
						  "camp"=>$arr_cat_de_editat[0]["link_cat"],
						  "eroare"=>"");	

		$descriere_check=array("valid"=>1,
							   "camp"=>inverse_nl2br($arr_cat_de_editat[0]["descriere_cat"]),
							   "eroare"=>"");	

		$discount_check=array("valid"=>1,
							  "camp"=>$arr_cat_de_editat[0]["discount"],
							  "eroare"=>"");	
							  
		$limite_preturi_check=array("valid"=>1,
							   		"camp"=>$arr_cat_de_editat[0]["filtre_preturi"],
							   		"eroare"=>"");					  						   		   				
	}
	
	if(file_exists(URL_BASE_ABS."poze_categorii/".$id_cat.".jpg"))
		$poza_cat=URL_BASE."poze_categorii/".$id_cat.".jpg";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("edit", ($arr_cat_de_editat[0]["producator"]==1)?"producatori":"");
	$smarty->assign("form_submit", $form_submit);
		
	$smarty->assign("nume_cat", $arr_cat_de_editat[0]["nume_cat"]);
	$smarty->assign("categorie_check", $categorie_check);	
	$smarty->assign("link_check", $link_check);
	$smarty->assign("descriere_check", $descriere_check);
	$smarty->assign("discount_check", $discount_check);
	$smarty->assign("limite_preturi_check", $limite_preturi_check);
	
	$smarty->assign("id_cat", $id_cat);
	$smarty->assign("id_parinte", $arr_cat_de_editat[0]["id_parinte"]);
	$smarty->assign("activ", $arr_cat_de_editat[0]["activ"]);
	$smarty->assign("poza_cat", $poza_cat);
	$smarty->assign("mesaj", ($_GET["cat_modificata"]=="true")?"Categoria a fost modificata!":"");
	
	//@timestamp pt poze sa nu le ia din cache
	$smarty->assign("timestamp", time());
	
	require_once("right.php");
	require_once("bottom.php");
?>