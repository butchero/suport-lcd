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
	//@vars
	$ultimul_nivel=false;
	$este_producator=false;
	$nume_cat="";
	$id_cat=0;
	$link_cat="";
	$descriere_cat="";
	$filtre_preturi="";
	$arr_radacina=array();

	//----------------------------------------------------------------------------------------------------------------------------
	//@toate categoriile
	$arr_toate_cat=arrayFromDB("*", "t_categorii", "WHERE producator='0' ORDER BY nr_ordine ASC");	
	$arr_toate_cat_dupa_id=array();
	
	foreach($arr_toate_cat as $value)
		$arr_toate_cat_dupa_id[$value["id_cat"]]=array("id_cat"=>$value["id_cat"], "nume_cat"=>$value["nume_cat"], "link_cat"=>$value["link_cat"], "id_parinte"=>$value["id_parinte"], "producator"=>$value["producator"], "nr_ordine"=>$value["nr_ordine"], "descriere_cat"=>$value["descriere_cat"], "nr_produse"=>$value["nr_produse"], "activ"=>$value["activ"], "discount"=>$value["discount"], "filtre_preturi"=>$value["filtre_preturi"]);
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@categoria selectata
	if(!empty($_GET["cat"]))
	{
		$arr_cat=arrayFromDB("*", "t_categorii", "WHERE link_cat='".prepareStringToDB($_GET["cat"])."' AND activ='1'");
			
		//@verific daca categoria/producatorul exista in bd, in caz contrar -> eroare 404 customizata
		if(count($arr_cat)!=1)				
		{
			header("HTTP/1.0 404 Not Found");
			$display_page="404.tpl";
			
			require_once("right.php");
			require_once("bottom.php");
			
			exit;
		}
		
		//@date categoria selectata
		$id_cat=$arr_cat[0]["id_cat"];
		$nume_cat=$arr_cat[0]["nume_cat"];
		$link_cat=strtolower($arr_cat[0]["link_cat"]);
		$descriere_cat=$arr_cat[0]["descriere_cat"];
		$filtre_preturi=$arr_cat[0]["filtre_preturi"];

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
	}
	
	if($nume_cat=="Mobuler" || $nume_cat=="Serend")
	{
		header("HTTP/1.0 404 Not Found");
		$display_page="404.tpl";
		
		require_once("right.php");
		require_once("bottom.php");
		
		exit;
	}

	//----------------------------------------------------------------------------------------------------------------------------
	//@generare menu categorii
	$meniuri=new arbore($nod, NIVELE_AFISATE, $arr_toate_cat);	
	$arr_meniuri=$meniuri->getMeniuri();
	$arr_parinti=$meniuri->getParintiGasiti();
	
	//@daca ma aflu pe ultimul nivel adaug 'id_cat' la parinti
	($ultimul_nivel)?$arr_parinti[]=$id_cat:"";
	
	//----------------------------------------------------------------------------------------------------------------------------
	//@radacina catalog
	if(count($arr_parinti)>0)
	{
		if($este_producator)
		{
			$arr_radacina[]=array("nume_radacina"=>$nume_cat,
								  "link_radacina"=>URL_BASE.strtolower($link_cat));
		}
		else
		{
			foreach($arr_parinti as $key=>$value)
			{
				$arr_radacina[]=array("nume_radacina"=>$arr_toate_cat_dupa_id[$value]["nume_cat"],
									  "link_radacina"=>URL_BASE.strtolower($arr_toate_cat_dupa_id[$value]["link_cat"]));
			}
		}
	}

	//----------------------------------------------------------------------------------------------------------------------------
	//@generare menu producatorii
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
	
	//----------------------------------------------------------------------------------------------------------------------------	
	//@top cautari
	$arr_cautari=arrayFromDB(array("cautare"), "t_cautari", "ORDER BY contor DESC LIMIT 0, ".AFISARI_TOP_CAUTARI);	
	$nr_cautari=count($arr_cautari);
	
	for($i=0;$i<$nr_cautari;$i++)
	{
		$cautari[$i]=array("cautare"=>ucfirst(stringLimit($arr_cautari[$i]["cautare"], 20, "..")),
						   "link_cautare"=>URL_BASE."cautare/".prepareLink($arr_cautari[$i]["cautare"]));
	}
	
	//----------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@afisare left menu (categorii)
	$smarty->assign("left_menu", $arr_meniuri);
	
	//@nume categoria selectata
	$smarty->assign("nume_cat_selectata", $nume_cat);
	
	//@categoria selectata (pentru a fi evidentiata grafic in menu)
	$smarty->assign("cat_selectata", $id_cat);
	
	//@afisare producatori
	$smarty->assign("producatori", $producatori);
	
	//@afisare top cautari
	$smarty->assign("cautari", $cautari);
		
	//@daca exista descriere pentru categ selectata este afisata (mai mult pt SEO)
	$smarty->assign("descriere_cat", $descriere_cat);
?>