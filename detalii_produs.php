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
	require_once("functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page=($_GET["id_produs"]==$arr_chilipir[0]["id_produs"] && CHILIPIR)?"detalii_produs_chilipir.tpl":"detalii_produs.tpl";
	
	//@security check
	(!is_numeric($_GET["id_produs"]))?die("Produsul nu exista!"):$id_produs=$_GET["id_produs"];
	
	//--------------------------------------------------------------------------------------------------------------------------
	$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat='".$id_cat."' ORDER BY id_filtru ASC");
	$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$id_produs."'");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@verific daca produsul exista in bd, in caz contrar -> eroare 404 customizata
	if(count($arr_produs)!=1)
	{
		header("HTTP/1.0 404 Not Found");
		$display_page="404.tpl";
		
		require_once("right.php");
		require_once("bottom.php");
		
		exit;
	}
		
	//--------------------------------------------------------------------------------------------------------------------------
	//DETALII PRODUS
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@tab selectat
	$tab_selectat="descriere_produs";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@variabile mai des folosite
	$id_produs=$arr_produs[0]["id_produs"];
	$nume_produs=prepareStringFromDB($arr_produs[0]["nume_produs"]);
	$id_producator=$arr_produs[0]["id_prod"];
	$id_cat=$arr_produs[0]["id_cat"];
	$id_stoc=$arr_produs[0]["stoc"];
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@poza principala
	$adresa_poza=getPozaPrincipalaMareProdus($id_produs, $nume_produs);

	//--------------------------------------------------------------------------------------------------------------------------
	//CARACTERISTICI
	$val_carac=explode(";", $arr_produs[0]["caracteristici"]);
	
	$arr_filtre=arrayFromDB("*",
						    "t_filtre AS a LEFT JOIN t_relatii_cat_filtre AS b ON a.id_filtru=b.id_filtru
										   LEFT JOIN t_categorii_filtre AS c ON b.id_cat_filtru=c.id_cat_filtru",
							"WHERE a.id_cat='".$id_cat."' ORDER BY a.id_filtru ASC");
							
	$nr_filtre=count($arr_filtre);
		
	for($j=0;$j<$nr_filtre;$j++)
	{
		$caracteristici[$j]=array("id_filtru"=>$arr_filtre[$j]["id_filtru"],
								  "id_grup"=>$arr_filtre[$j]["id_cat_filtru"],
								  "id_relatie"=>$arr_filtre[$j]["id_relatie"],
								  "nume_grup"=>$arr_filtre[$j]["nume_cat_filtru"],
								  "nume_carac"=>$arr_filtre[$j]["nume_filtru"],
								  "val_carac"=>(empty($val_carac[$j+1]))?"-":$val_carac[$j+1],
								  "nr_ordine"=>$arr_filtre[$j]["nr_ordine"]);					
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//sortare caracteristici dupa nr_ordine
	if(count($caracteristici)>0)
	{
		foreach($caracteristici as $key=>$value)
		{			
			$arr_id_grup[$key]=$value["id_grup"];
			$arr_nr_ordine[$key]=$value["nr_ordine"];
		}
		
		array_multisort($arr_id_grup, SORT_ASC, $arr_nr_ordine, SORT_ASC, $caracteristici);	
	}
	
	for($j=0;$j<$nr_filtre;$j++)
	{
		if(strtolower($caracteristici[$j]["nume_carac"])=="diagonala")
		{
			$diagonala=$caracteristici[$j]["val_carac"];
			continue;
		}
		$temp[]=array("id_filtru"=>$caracteristici[$j]["id_filtru"],
					  "nume_grup"=>($caracteristici[$j]["nume_grup"]!=$caracteristici[$j-1]["nume_grup"])?$caracteristici[$j]["nume_grup"]:"",
					  "nume_carac"=>$caracteristici[$j]["nume_carac"],
					  "val_carac"=>$caracteristici[$j]["val_carac"]);					
	}
	
	$caracteristici=$temp;
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@galerie produs			
	$arr_galerie=genereazaGalerie($id_produs);
	
	$poze_sec_mici=$arr_galerie["mici"];
	$poze_sec_mari=$arr_galerie["mari"];		
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@link produs
	$link_produs=getLinkProdus($link_cat, $nume_produs, $id_produs);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@producator
	$arr_producator=arrayFromDB(array("id_cat", "nume_cat", "link_cat"), "t_categorii", "WHERE id_cat='".$id_producator."'");
	$nume_producator=$arr_producator[0]["nume_cat"];
	$link_producator=URL_BASE.$arr_producator[0]["link_cat"];
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@poza producator
	$poza_producator=getPozaMareProducator($id_producator);		
	
	//--------------------------------------------------------------------------------------------------------------------------					  
	//@rating produs					  
	require_once("clase/produsRating.php");
						  
	$rating=new produsRating($id_produs);
	$nr_comentarii=$rating->getNrComentarii();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@stoc
	$arr_stoc=arrayFromDB("*", "t_stoc", "WHERE id_stoc='".$id_stoc."'");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@categorii secundare asociate produsului
	(CAT_SECUNDARE)?$arr_cat_sec=getCategoriiSecundare($id_produs):"";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@array asociativ cu toate detaliile produsului
	$arr_produs_detalii=array("id_produs"=>$id_produs,										   
							  "nume_produs"=>$nume_produs,
							  "id_cat"=>$id_cat,	
							  "adresa_poza_produs"=>$adresa_poza,
							  "id_stoc"=>$id_stoc,
							  "stoc"=>ucfirst($arr_stoc[0]["stoc"]),							  
							  "tip"=>$arr_produs[0]["tip"],
							  "poze_sec_mici"=>$poze_sec_mici,
							  "poze_sec_medii"=>$poze_sec_mari,
							  "pret_produs"=>formateazaNr($arr_produs[0]["pret"]*TVA),
							  "pret_vechi"=>(!empty($arr_produs[0]["pret_vechi"]) && $arr_produs[0]["pret_vechi"]!=0)?formateazaNr($arr_produs[0]["pret_vechi"]*TVA):"",
							  "reducere"=>calculeazaReducere($arr_produs[0]["pret_vechi"]*TVA, $arr_produs[0]["pret"]*TVA),
							  "link_produs"=>$link_produs,
							  "link_producator"=>$link_producator,
							  "link_comentarii"=>$link_produs."/comentarii",
							  "link_alerta_pret"=>$link_produs."/alerta-pret",
							  "link_alerta_stoc"=>$link_produs."/alerta-stoc",
							  "link_cum_cumpar"=>$link_produs."/cum-cumpar",
							  "caracteristici"=>$caracteristici,
							  "descriere_produs"=>nl2br(prepareStringFromDB($arr_produs[0]["descriere_produs"])),
							  "producator"=>$nume_producator,
							  "poza_producator"=>$poza_producator,
							  "rating"=>array("1"=>round($rating->getRating()), "2"=>RATING_MAX-round($rating->getRating())),
							  "nr_comentarii"=>$nr_comentarii,
							  "cat_sec"=>$arr_cat_sec,
							  "nr_cat_sec"=>count($arr_cat_sec));
	/*
	$arr_radacina[]=array("nume_radacina"=>stringLimit($nume_produs, 35, ".."),
						  "link_radacina"=>$link_produs);*/							    	

	//--------------------------------------------------------------------------------------------------------------------------
	//@fisiere produs
	$arr_fisiere=citesteDir(URL_BASE_ABS."poze_produse/".$id_produs."/", true);
	
	//--------------------------------------------------------------------------------------------------------------------------					  
	//MODULE ADITIONALE PENTRU DETALII PRODUS

	//--------------------------------------------------------------------------------------------------------------------------
	//@navigare din detalii
	if(NAVIGARE_DIN_DETALII)
	{
		$arr_produse_nav=arrayFromDB("*", "t_produse AS a LEFT JOIN t_categorii AS b ON a.id_cat=b.id_cat", "WHERE a.id_cat='".$id_cat."' ORDER BY pret ASC");
		
		//@loop prin toate produsele categoriei
		foreach($arr_produse_nav as $k=>$v)
		{
			$arr_produse_nav_temp[$v["id_produs"]]=$v["nume_produse"];
			
			//@identific pozitia pe care se afla produsul
			if($v["id_produs"]==$id_produs)
				$cheie_curenta=$k;
		}
		
		//@inapoi
		$inapoi=$cheie_curenta-1;

		if(!empty($arr_produse_nav[$inapoi]["id_produs"]) && is_numeric($arr_produse_nav[$inapoi]["id_produs"]))
		{
			$arr_navigare_inapoi=array("nume_produs"=>$arr_produse_nav[$inapoi]["nume_produs"],
									   "link_produs"=>getLinkProdus($arr_produse_nav[$inapoi]["link_cat"], $arr_produse_nav[$inapoi]["nume_produs"], $arr_produse_nav[$inapoi]["id_produs"]),
									   "poza_produs"=>getPozaPrincipalaMicaProdus($arr_produse_nav[$inapoi]["id_produs"]));
		}

		//@inainte
		$inainte=$cheie_curenta+1;
		
		if(!empty($arr_produse_nav[$inainte]["id_produs"]) && is_numeric($arr_produse_nav[$inainte]["id_produs"]))
		{
			$arr_navigare_inainte=array("nume_produs"=>$arr_produse_nav[$inainte]["nume_produs"],
									    "link_produs"=>getLinkProdus($arr_produse_nav[$inainte]["link_cat"], $arr_produse_nav[$inainte]["nume_produs"], $arr_produse_nav[$inainte]["id_produs"]),
									    "poza_produs"=>getPozaPrincipalaMicaProdus($arr_produse_nav[$inainte]["id_produs"]));
		}

		$poza_mic_produs_curent=getPozaPrincipalaMicaProdus($id_produs);	
	}
		
	//--------------------------------------------------------------------------------------------------------------------------					  
	//@comentarii produs
	if(isset($_GET["mod"]) && $_GET["mod"]=="comentarii")
	{				
		require_once("detalii_produs_modul_comentarii.php");
	}		
	//--------------------------------------------------------------------------------------------------------------------------					  
	//@alerta pret
	elseif(isset($_GET["mod"]) && $_GET["mod"]=="alerta_pret")
	{				
		require_once("detalii_produs_modul_alerta_pret.php");
	}
	//--------------------------------------------------------------------------------------------------------------------------					  
	//@alerta disponibilitate
	elseif(isset($_GET["mod"]) && $_GET["mod"]=="alerta_stoc")
	{				
		require_once("detalii_produs_modul_alerta_stoc.php");
	}
	//--------------------------------------------------------------------------------------------------------------------------					  
	//@cum cumpar
	elseif(isset($_GET["mod"]) && $_GET["mod"]=="cum_cumpar")
	{	
		$tab_selectat="cum_cumpar";
	}
	//--------------------------------------------------------------------------------------------------------------------------					  
	//@cine a cumparat produsul asta a cumparat si x si y
	else 
	{
		require_once("detalii_produs_modul_alte_cumparaturi.php");
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@telefon comenzi
	$smarty->assign("TELEFON_COMENZI", TELEFON_COMENZI); //definita in top	
	
	//@afisare produs
	$smarty->assign("produs", $arr_produs_detalii);
	
	//@taburi
	$smarty->assign("tab_selectat", $tab_selectat);
	
	//@alte produse - $arr_alte_produse_detalii definita in "detalii_produs_modul_alte_cumparaturi.php"
	$smarty->assign("alte_produse", $arr_alte_produse_detalii);
							
	//@comentarii produs - $arr_comentarii definita in "detalii_produs_modul_comentarii.php"
	$smarty->assign("comentarii", $arr_comentarii);
			
	//@afisare paginare - $paginare_string_comentarii definita in "detalii_produs_modul_comentarii.php"
	$smarty->assign("paginare_comentarii", $paginare_string_comentarii);
	
	//@combobox rating - $arr_rating definita in "detalii_produs_modul_comentarii.php"
	$smarty->assign("rating", $arr_rating);
	
	//@diagonala
	$smarty->assign("diagonala", $diagonala);
	
	//@procente voturi
	$smarty->assign("procente", $rating->getProcente());
	
	//@nr comentarii ale utilizatorului logat pt acest produs
	$smarty->assign("nr_user_comentarii", $nr_user_comentarii);
	
	//@confirmare pt adaugarea unui "comentariu/rating" sau a unei "alerte"
	$smarty->assign("insert_ok", $insert_ok);
	
	//@erori setare alerta		
	$smarty->assign("email_check", $email_check);
	$smarty->assign("pretul_dorit_check", $pretul_dorit_check);
	$smarty->assign("cod_verificare_check", $cod_verificare_check);
	$smarty->assign("alerta_check", $alerta_check);
	
	//@afisare comanda minima
	$smarty->assign("comanda_minima", (COMANDA_MINIMA!=0)?formateazaNr(COMANDA_MINIMA):"");
	
	//@fisiere produs
	$smarty->assign("fisiere", (!empty($arr_fisiere))?$arr_fisiere:"");
	
	//@produse navigare inainte/inapoi
	$smarty->assign("navigare_inapoi", $arr_navigare_inapoi);
	$smarty->assign("navigare_inainte", $arr_navigare_inainte);
	$smarty->assign("poza_produs_curent", $poza_mic_produs_curent);
	
	require_once("right.php");
	require_once("bottom.php");
?>