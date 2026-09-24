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
	require_once("../functii/f_catalog.php");
	require_once("../functii/f_links.php");
	require_once("../functii/f_admin.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@restrictionare acces pt subadmini
	restrictioneazaAccesSubadmini();;
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/comenzi.tpl";	
	
	//@basic check	
	if($_GET["stare"]=="onorate")
		$stare=2;
	elseif($_GET["stare"]=="anulate")
		$stare=3;
	else die("Pagina cu tipul de comenzi specificate nu exista!");		
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@cautare
	$form_submit=0;
	
	if(isset($_REQUEST["cauta"]))
	{		
		$nume=$_REQUEST["nume"];
		$prenume=$_REQUEST["prenume"];
		$societate=$_REQUEST["societate"];
		$user_client=$_REQUEST["user_client"];
		$tip_factura=$_REQUEST["tip_factura"];
		$judet=$_REQUEST["judet"];
		
		if(isset($_REQUEST["astazi"]))
		{
			$_REQUEST["de_la"]=date("Ymd");
			$_REQUEST["pana_la"]=date("Ymd");
		}

		if(!empty($_REQUEST["nume"]))
		{
			$sql_where.=" AND nume LIKE '%".prepareStringToDB($nume)."%'";
			$link_sufix.="&nume=".$nume;
		}
			
		if(!empty($_REQUEST["prenume"]))
		{
			$sql_where.=" AND prenume LIKE '%".prepareStringToDB($prenume)."%'";
			$link_sufix.="&prenume=".$prenume;
		}
		
		if(!empty($_REQUEST["societate"]))
		{
			$sql_where.=" AND societate LIKE '%".prepareStringToDB($societate)."%'";
			$link_sufix.="&societate=".$societate;
		}
		
		if(!empty($_REQUEST["user_client"]))
		{
			$sql_where.=" AND username LIKE '%".prepareStringToDB($user_client)."%'";
			$link_sufix.="&user_client=".$user_client;
		}	
		
		if($_REQUEST["tip_factura"]!="")
		{
			$sql_where.=" AND t_comenzi.tip_factura='".$tip_factura."'";
			$link_sufix.="&tip_factura=".$tip_factura;
		}
		
		if(!empty($_REQUEST["judet"]))
		{
			$sql_where.=" AND t_useri.id_jud='".$judet."'";
			$link_sufix.="&judet=".$judet;
		}
			
		if(!empty($_REQUEST["de_la"]) && !empty($_REQUEST["pana_la"]))
		{
			$de_la=$_REQUEST["de_la"];
			$pana_la=$_REQUEST["pana_la"];
		
			$timestamp_de_la=strtotime($de_la);
			$timestamp_pana_la=strtotime($pana_la)+(60*60*24)-1; //formula asta inseamna (pana_la) + 23h 59min 59sec;
			
			if($timestamp_de_la>$timestamp_pana_la)
			{
				$mesaj="Perioada este invalida!";
			}
			else 
			{
				if($timestamp_de_la==$timestamp_pana_la)
					$timestamp_pana_la=$timestamp_de_la+(60*60*24)-1;
				
				$sql_where.=" AND data_comanda BETWEEN ".$timestamp_de_la." AND ".$timestamp_pana_la;
				$link_sufix.="&de_la=".$de_la."&pana_la=".$pana_la;
			}
		}
		
		$link_sufix.="&cauta";		
		$form_submit=1;
	}
	
	if(!isset($_REQUEST["de_la"]) && !isset($_REQUEST["pana_la"])) 
	{
		$arr_de_la=arrayFromDB(array("MIN(data_comanda) AS de_la"), "t_comenzi", "WHERE stare='".$stare."'");
		$de_la=date("Ymd", (empty($arr_de_la[0]["de_la"]))?time():$arr_de_la[0]["de_la"]);
		
		$arr_pana_la=arrayFromDB(array("MAX(data_comanda) AS pana_la"), "t_comenzi", "WHERE stare='".$stare."'");
		$pana_la=date("Ymd", (empty($arr_de_la[0]["pana_la"]))?time():$arr_de_la[0]["pana_la"]);
	}

	//--------------------------------------------------------------------------------------------------------------------------
	//@judete
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet", "ORDER BY judet ASC");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@metode de plata
	$arr_metode_plata=arrayFromDBtoCombo("t_metode_plata", "id_metoda_plata", "metoda_plata");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@admini
	$arr_admini=arrayFromDBtoCombo("t_admin", "id_admin", "username");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");
	
	$sql_where.=" AND stare='".$stare."'";
	
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_comanda) AS nr FROM t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user WHERE 1 ".$sql_where, 
						    URL_ADMIN."comenzi.php?pag=".PATTERN.$link_sufix."&stare=".$_GET["stare"]); 
	$paginare_string=$paginare->doPaginare();
	$nr_rezultate=$paginare->getNrRezultate(); 
	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@selectare tranzactii (comenzi)
	$arr_tranzactii=arrayFromDB("*",
							    "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user
							    		   LEFT JOIN t_transport ON t_comenzi.id_transport=t_transport.id_transport",
							    "WHERE 1 ".$sql_where." ORDER BY data_comanda DESC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	$j=0;	
	if(is_array($arr_tranzactii))
	{				    
		foreach($arr_tranzactii as $key=>$value)
		{
			//------------------------------------------------------------------------------------------------------------------
			//@selectare produse cumparate asociate comenzii
			$arr_produse_comanda=arrayFromDB("*",
									 		 "t_produse_comenzi LEFT JOIN t_produse ON t_produse_comenzi.id_produs=t_produse.id_produs
									 		 					LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
									 		 "WHERE id_comanda='".$value["id_comanda"]."' ORDER BY id ASC");

			$nr_produse_comanda=count($arr_produse_comanda);
									 		 		
			for($i=0;$i<$nr_produse_comanda;$i++)
			{											
				//@produsele cumparate
				$produse_comanda[$i]=array("link_produs"=>getLinkProdus($arr_produse_comanda[$i]["link_cat"], $arr_produse_comanda[$i]["nume_produs"], $arr_produse_comanda[$i]["id_produs"]),
										   "cod_produs"=>$arr_produse_comanda[$i]["cod_produs"],
										   "nume_produs"=>$arr_produse_comanda[$i]["nume_produs"],	
										   "poza_produs"=>getPozaPrincipalaMicaProdus($arr_produse_comanda[$i]["id_produs"]),								   		  
								   		   "cantitate"=>$arr_produse_comanda[$i]["cantitate"],
								   		   "pret_unitar"=>formateazaNr($arr_produse_comanda[$i]["pret_produs"]),
								   		   "pret_total"=>formateazaNr($arr_produse_comanda[$i]["pret_produs"]*$arr_produse_comanda[$i]["cantitate"]*TVA));
			}
		
			//@dir proforme pdf
			$dir_proforme=URL_BASE."proforme/".md5($value["data_inregistrarii"].$value["id_user"])."/";
			
			//@array cu data comenzii si produsele cumparate
			$comenzi[$j]=array("id_comanda"=>$value["id_comanda"],
							   "data_comenzii"=>date(DATA_FORMAT." H:i", $value["data_comanda"]),
							   "produse"=>$produse_comanda,
							   "total_comanda"=>formateazaNr($value["total_comanda"]),
							   "proforma"=>$dir_proforme."proforma_".$value["id_comanda"].".pdf",
							   "transport"=>$value["nume_transport"]." - ".formateazaNr(($value["total_comanda"]>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$value["cost"])." ".MONEDA,
							   "stare_comanda"=>$stare_comanda[$value["stare"]],
							   "stare"=>$value["stare"],
							   "nota_admin"=>$value["nota_admin"],
							   "admin"=>$arr_admini[$value["id_admin"]],
							   "metoda_plata"=>$arr_metode_plata[$value["id_metoda_plata"]],
							   "achitata"=>($value["comanda_achitata"]==1)?"DA":"NU");			
				
			unset($arr_produse_comanda, $produse_comanda);				
			$j++;		
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@total cumparaturi din perioada data
	$arr_total_cumparaturi=arrayFromDB(array("SUM(total_comanda) AS total"), "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user", "WHERE 1 ".$sql_where);
	
	//@nr comenzi care au beneficiat de transport gratuit si nr comenzi cu transport platit
	if(TRANSPORT_GRATUIT>0)
	{
		$arr_comenzi_fara_transport=arrayFromDB(array("COUNT(id_comanda) AS nr_comenzi"), "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user", "WHERE total_comanda >= ".TRANSPORT_GRATUIT." ".$sql_where);
		$arr_comenzi_cu_transport=arrayFromDB(array("COUNT(id_comanda) AS nr_comenzi"), "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user", "WHERE total_comanda < ".TRANSPORT_GRATUIT." ".$sql_where);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
		
	//@afisare erori/mesaje
	$smarty->assign("mesaj", $mesaj);

	//@nume cautare
	$smarty->assign("nume", $nume);
	
	//@prenume cautare
	$smarty->assign("prenume", $prenume);
	
	//@societate cautare
	$smarty->assign("societate", $societate);
	
	//@judete cautare
	$smarty->assign("judete", $arr_judete);
	
	//@user cautare
	$smarty->assign("user_client", $user_client);
	
	//@tip factura cautare
	$smarty->assign("tip_factura", $tip_factura);
	
	//@judet cautare
	$smarty->assign("judet", $judet);
	
	//@perioada start (de forma YYYYMMDD pt form)
	$smarty->assign("de_la", $de_la);

	//@perioada end (de forma YYYYMMDD pt form)
	$smarty->assign("pana_la", $pana_la);

	$smarty->assign("de_la_formatat", @date(DATA_FORMAT, strtotime($de_la)));
	$smarty->assign("pana_la_formatat", @date(DATA_FORMAT, strtotime($pana_la)));
	
	//@nr comenzi cu transport gratuit si nr comenzi cu transport platit
	$smarty->assign("nr_comenzi_cu_transport", $arr_comenzi_cu_transport[0]["nr_comenzi"]);
	$smarty->assign("nr_comenzi_fara_transport", $arr_comenzi_fara_transport[0]["nr_comenzi"]);
	
	//@stari comenzi (combobox)
	$smarty->assign("stare_comanda", $stare_comanda);
	
	//@afisare tranzactii (comenzi)
	$smarty->assign("comenzi", $comenzi);
	
	//@nr rezultate - comenzi neonorate
	$smarty->assign("nr_rezultate", $nr_rezultate);
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	//@pagina
	$smarty->assign("pag", $_GET["pag"]);
	
	//@total_cumparaturi
	$smarty->assign("total_cumparaturi", formateazaNr($arr_total_cumparaturi[0]["total"]));
	
	//@tip comanda
	$smarty->assign("stare_comanda", $_GET["stare"]);
	
	//@form submit
	$smarty->assign("form_submit", $form_submit);
	
	require_once("right.php");
	require_once("bottom.php");
?>