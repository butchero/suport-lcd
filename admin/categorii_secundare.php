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
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@modul activat/dezactivat check
	if(!CAT_SECUNDARE)
		die("Aceasta sectiune este dezactivata! <br /><a href='".URL_ADMIN."'>Prima pagina din administrare.</a>");	
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/categorii_secundare.tpl";	
		
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@actiune adaugare categorie/subcategorie noua
	if(isset($_POST["adauga_cat_sec"]) && !empty($_POST["cat_sec_noua"]) && isset($_POST["id_cat_sec"]) && is_numeric($_POST["id_cat_sec"]))
	{
		$id_cat_parinte=$_POST["id_cat_sec"];
		$arr_cat_parinte=arrayFromDB("*", "t_categorii_secundare", "WHERE id_cat_sec='".$id_cat_parinte."'");

		if($arr_cat_parinte[0]["id_parinte"]==0 || $id_cat_parinte==0)
		{
			//@contruiesc link cat secundara
			$link_cat_sec=prepareLink($_POST["cat_sec_noua"]);
			
			//@verific daca mai exista un link in bd
			$arr_link_cat_sec=arrayFromDB(array("link_cat_sec"), "t_categorii_secundare", "WHERE link_cat_sec='".prepareStringToDB($link_cat_sec)."'");
			
			if(count($arr_link_cat_sec)==0)
			{
				$arr_max_nr_ordine=arrayFromDB(array("MAX(nr_ordine) AS nr_ordine"), "t_categorii_secundare", "WHERE id_parinte='".$id_cat_parinte."'");
				
				arrayInsertToDB("t_categorii_secundare",
								 array("nume_cat_sec", "link_cat_sec", "id_parinte", "nr_ordine"),
								 array($_POST["cat_sec_noua"], $link_cat_sec, $id_cat_parinte, $arr_max_nr_ordine[0]["nr_ordine"]+1));	
				$mesaj="Categoria/subcategoria secundara ".$_POST["cat_sec_noua"]." a fost adaugata cu succes!";
			}
			else 
			{
				$mesaj="Exista deja o categorie cu acest nume!";
			}
		}
		else 
		{
			$mesaj="Pentru a adauga o categorie secundara noua alegeti radacina sau o categorie secundara principala!";
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@actiune stergere categorie/subcategorie existenta
	if(isset($_POST["sterge_cat_sec"]) && isset($_POST["id_cat_sec"]) && is_numeric($_POST["id_cat_sec"]))
	{
		$id_cat_de_sters=$_POST["id_cat_sec"];
		$arr_cat_parinte=arrayFromDB("*", "t_categorii_secundare", "WHERE id_cat_sec='".$id_cat_de_sters."'");

		if($id_cat_de_sters!=0)
		{			
			//@daca e subcategorie sterg direct categoria si produsele asociate ei
			if($arr_cat_parinte[0]["id_parinte"]!=0) 
			{
				arrayDeleteFromDB("t_categorii_secundare", array("id_cat_sec"), array($id_cat_de_sters));	
				arrayDeleteFromDB("t_relatii_cat_sec_produse", array("id_cat_sec"), array($id_cat_de_sters));
			}			
			else //@daca e categorie principala aflu copii si dupa aia sterg produsele de peste tot :P
			{
				arrayDeleteFromDB("t_categorii_secundare", array("id_cat_sec"), array($id_cat_de_sters));
				arrayDeleteFromDB("t_relatii_cat_sec_produse", array("id_cat_sec"), array($id_cat_de_sters));
				
				$arr_copii=arrayFromDB("*", "t_categorii_secundare", "WHERE id_parinte='".$id_cat_de_sters."'");				
				
				foreach($arr_copii as $k=>$v)
				{
					arrayDeleteFromDB("t_categorii_secundare", array("id_cat_sec"), array($v["id_cat_sec"]));	
					arrayDeleteFromDB("t_relatii_cat_sec_produse", array("id_cat_sec"), array($v["id_cat_sec"]));	
				}
			}
			
			$mesaj="Categoria/subcat. secundara ".$arr_cat_parinte[0]["nume_cat_sec"]." a fost stearsa cu succes!";
		}
		else 
		{
			$mesaj="Trebuie sa selectati o categorie!";
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@actiune editare categorie
	if(isset($_POST["id_cat_de_edit"]) && is_numeric($_POST["id_cat_de_edit"]))
	{
		$id_cat_de_edit=$_POST["id_cat_de_edit"];
	
		$arr_cat_de_editat=arrayFromDB("*", "t_categorii_secundare", "WHERE id_cat_sec='".$id_cat_de_edit."'");			
		$cat_de_editat=$arr_cat_de_editat[0]["nume_cat_sec"];
		
		if(isset($_POST["modifica_cat_sec"]))
		{
			$cat_de_editat=trim($_POST["cat_sec_existenta"]);
			
			//@contruiesc link cat secundara
			$link_cat_sec=prepareLink($cat_de_editat);
			
			//@verific daca mai exista un link in bd
			$arr_link_cat_sec=arrayFromDB(array("link_cat_sec"),
										  "t_categorii_secundare",
										  "WHERE link_cat_sec='".prepareStringToDB($link_cat_sec)."' AND id_cat_sec!='".$id_cat_de_edit."'");
			
			if(count($arr_link_cat_sec)==0)
			{						
				arrayUpdateToDB("t_categorii_secundare",
								 array("nume_cat_sec", "link_cat_sec"),
								 array($cat_de_editat, $link_cat_sec),
								 array("id"=>"id_cat_sec", "valoare"=>$id_cat_de_edit));	
				$mesaj="Categoria/subcat. secundara ".$cat_de_editat." a fost modificata cu succes!";
			}
			else 
			{
				$mesaj="Exista deja o categorie cu acest nume!";
			}
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@toate categoriile/subcategoriile secundare
	require_once("../module_secundare/categorii_secundare.php");
			
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("id_cat_parinte", $id_cat_parinte);
	$smarty->assign("id_cat_de_edit", $id_cat_de_edit);
	$smarty->assign("cat_de_editat", $cat_de_editat);

	
	require_once("right.php");
	require_once("bottom.php");
?>