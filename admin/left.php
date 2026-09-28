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
	//----------------------------------------------------------------------------------------------------------------------------
	//@get un copil oarecare(nod) al categoriei
	$ultimul_nivel=false;
	$este_producator=false;
	$descriere_cat="";
	$arr_radacina=array();
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@toate categoriile
	$arr_toate_cat=arrayFromDB("*", "t_categorii", "WHERE producator='0' ORDER BY nr_ordine ASC");	
	$arr_toate_cat_dupa_id=array();
	
	foreach($arr_toate_cat as $value)
		$arr_toate_cat_dupa_id[$value["id_cat"]]=array("id_cat"=>$value["id_cat"], "nume_cat"=>$value["nume_cat"], "link_cat"=>$value["link_cat"], "id_parinte"=>$value["id_parinte"], "producator"=>$value["producator"], "nr_ordine"=>$value["nr_ordine"], "descriere_cat"=>$value["descriere_cat"], "nr_produse"=>$value["nr_produse"], "activ"=>$value["activ"], "discount"=>$value["discount"], "filtre_preturi"=>$value["filtre_preturi"]);
	
	if(!empty($_GET["cat"]) && is_numeric($_GET["cat"]))
	{
		$arr_cat=arrayFromDB("*", "t_categorii", "WHERE id_cat='".$_GET["cat"]."'");
				
		$id_cat=$arr_cat[0]["id_cat"];
		$nume_cat=prepareStringFromDB($arr_cat[0]["nume_cat"]);
		$link_cat=$arr_cat[0]["link_cat"];
		$descriere_cat=prepareStringFromDB($arr_cat[0]["descriere_cat"]);		

		//@verific daca categoria este producator sau nu
		($arr_cat[0]["producator"]==1)?$este_producator=true:$este_producator=false;

		$arr_copii=arrayFromDB("*", "t_categorii", "WHERE id_parinte='".$id_cat."' LIMIT 0, 1");		
		
		if(empty($arr_copii[0]["id_cat"]))
		{
			$nod=$id_cat;
			$ultimul_nivel=true;
		}
		else 
		{
			$nod=$arr_copii[0]["id_cat"];
		}
	}
	else
	{
		$nod=0;
		$id_cat=0;
	}

	//----------------------------------------------------------------------------------------------------------------------------
	//@generare menu categorii
	$meniuri=new arbore($nod, 0, $arr_toate_cat);
	$arr_meniuri=$meniuri->getMeniuri();
	$arr_parinti=$meniuri->getParintiGasiti();
	
	//@daca ma aflu pe ultimul nivel adaug 'id_cat' la parinti
	($ultimul_nivel)?$arr_parinti[]=$id_cat:"";

	if(count($arr_parinti)>0)
	{
		$arr_temp=arrayFromDB(array("id_cat", "nume_cat", "link_cat"), "t_categorii", "WHERE id_cat IN (".implode(",", $arr_parinti).")");
		$nr_parinti=count($arr_temp);
		
		for($i=0;$i<$nr_parinti;$i++)
		{		
			$arr_radacina[$i]=array("id_radacina"=>$arr_temp[$i]["id_cat"],
									"nume_radacina"=>prepareStringFromDB($arr_temp[$i]["nume_cat"]),
									"link_radacina"=>URL_ADMIN."catalog.php?cat=".$arr_temp[$i]["id_cat"]);
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@toate categoriile - (in fisierele "editeaza_categorie.php", "preturi_produse.php", "grupeaza_filtre.php" se repeta codul acesta - tb scos pe viitor pt a mari viteza de executie
	$toate_categoriile=new arboreComplet(0, 0, $arr_toate_cat);
	$arr_categ=$toate_categoriile->getArboreComplet();	
	$nr_toate_categoriile=count($arr_categ);
	
	for($i=0;$i<$nr_toate_categoriile;$i++)
		$toate_cat[$arr_categ[$i]["id_cat"]]=$arr_categ[$i]["indent"].(($arr_categ[$i]["nivel"]>0)?"&raquo; ":"").$arr_categ[$i]["nume_cat"]." (".$arr_categ[$i]["nr_produse"].")";
	
	//---------------------------------------------------------------------------------------------------------------------------
	//@stocuri
	$arr_stocuri=arrayFromDBtoCombo("t_stoc", "id_stoc", "stoc");	
	
	//---------------------------------------------------------------------------------------------------------------------------
	//@producatori
	$arr_producatori=arrayFromDB("*", "t_categorii", "WHERE producator='1' ORDER BY nr_ordine ASC");
	$nr_producatori=count($arr_producatori);
	
	for($i=0;$i<$nr_producatori;$i++)
	{
		$producatori[$i]=array("nume_cat"=>strtoupper($arr_producatori[$i]["nume_cat"]),
							   "link_cat"=>URL_BASE.strtolower($arr_producatori[$i]["link_cat"]),
							   "nr_produse"=>$arr_producatori[$i]["nr_produse"],
							   "activ"=>$arr_producatori[$i]["activ"]);
							   
		$toti_producatorii[$arr_producatori[$i]["id_cat"]]=$arr_producatori[$i]["nume_cat"];
		$toti_producatorii_links[$arr_producatori[$i]["id_cat"]]=$arr_producatori[$i]["link_cat"];					   							   
	}
	
	//---------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@afisare left menu (categorii)
	$smarty->assign("left_menu", $arr_meniuri);
	
	//@categoria selectata (pentru a fi evidentiata grafic in menu)
	$smarty->assign("cat_selectata", $id_cat);
			
	//@toate cat
	$smarty->assign("toate_cat", $toate_cat);
	
	//@stocuri
	$smarty->assign("stocuri", $arr_stocuri);
	
	//@producatori
	$smarty->assign("producatori", $toti_producatorii);
	
	//@descriere cat
	$smarty->assign("descriere_cat", $descriere_cat);
?>