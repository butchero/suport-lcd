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
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/comenzi_noi.tpl";	

	//---------------------------------------------------------------------------------------------------------------------------------
	//@mesaj anulare comanda
	if(isset($_GET["comanda_anulata"]) && $_GET["comanda_anulata"]=="true" && isset($_GET["id_comanda"]) && is_numeric($_GET["id_comanda"]))
		$mesaj="Comanda cu ID-ul ".$_GET["id_comanda"]." a fost anulata!";
		
	if(isset($_GET["comanda_asteptare"]) && $_GET["comanda_asteptare"]=="true" && isset($_GET["id_comanda"]) && is_numeric($_GET["id_comanda"]))
		$mesaj="Comanda cu ID-ul ".$_GET["id_comanda"]." a fost pusa in asteptare!";	
		
	if(isset($_SESSION["mesaj"]) && !empty($_SESSION["mesaj"]))
		$mesaj=$_SESSION["mesaj"];		
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@merge comenzi
	if(isset($_GET["id_comanda"]) && is_numeric($_GET["id_comanda"]) && isset($_GET["id_comanda_merge"]) && empty($mesaj))
	{
		$id_comanda=$_GET["id_comanda"];
		$id_comanda_merge=$_GET["id_comanda_merge"];
		
		$arr_comanda=arrayFromDB("*", "t_comenzi", "WHERE id_comanda='".$id_comanda."'");
		
		$arr_ids1=arrayFromDBtoCombo("t_produse_comenzi", "id_produs", "id_produs", "WHERE id_comanda='".$id_comanda."'");
		$arr_ids2=arrayFromDBtoCombo("t_produse_comenzi", "id_produs", "id_produs", "WHERE id_comanda='".$id_comanda_merge."'");
		
		//@verificari
		if(!is_numeric($id_comanda_merge))
			$mesaje[]="ID comanda \"merge\" nu este numeric!";
		else 	
			$arr_comanda_merge=arrayFromDB("*", "t_comenzi", "WHERE id_comanda='".$id_comanda_merge."'");	

		if(count($arr_comanda_merge)==0)
			$mesaje[]="Comanda cu id-ul \"".$id_comanda."\" cu care doriti sa faceti \"merge\" nu exista!";	
			
		if($arr_comanda_merge[0]["stare"]==2 || $arr_comanda_merge[0]["stare"]==3)
			$mesaje[]="Comanda cu care doriti sa faceti \"merge\" trebuie sa fie neonorata!";
			
		if($arr_comanda[0]["stare"]==2 || $arr_comanda[0]["stare"]==3)
			$mesaje[]="Comanda careia doriti sa-i faceti \"lipirea\" trebuie sa fie neonorata!";	
			
		if($arr_comanda[0]["id_user"]!=$arr_comanda_merge[0]["id_user"])
			$mesaje[]="Comenzile trebuie sa apartina aceluiasi user pentru a realiza operatiunea de \"merge\"!";
			
		if($id_comanda==$id_comanda_merge)
			$mesaje[]="Nu puteti realiza \"merge\" cu aceeasi comanda!";	
			
		if(count(array_intersect($arr_ids1, $arr_ids2))!=0)
			$mesaje[]="Nu puteti realiza \"merge\" daca aveti acelasi produs in ambele comenzi! Stergeti produsele comune dintr-o comanda mai intai.";
	
		//-----------------------------------------------------------------------------------------------------------------------------		
		//merge si regenerare pdf	
		if(count($mesaje)==0)
		{
			arrayUpdateToDB("t_produse_comenzi", array("id_comanda"), array($id_comanda), array("id"=>"id_comanda", "valoare"=>$id_comanda_merge));
			$arr_total_comanda_noua=arrayFromDB(array("SUM(pret_produs * cantitate) AS total_comanda"), "t_produse_comenzi", "WHERE id_comanda='".$id_comanda."'");
			arrayUpdateToDB("t_comenzi", array("total_comanda", "comentariu_comanda"), array($arr_total_comanda_noua[0]["total_comanda"] * TVA, $arr_comanda[0]["comentariu_comanda"]."<br />".$arr_comanda_merge[0]["comentariu_comanda"]), array("id"=>"id_comanda", "valoare"=>$id_comanda));
			arrayDeleteFromDB("t_comenzi", array("id_comanda"), array($id_comanda_merge));
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@date user
			$arr_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$arr_comanda[0]["id_user"]."'");
			
			@unlink(URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$arr_user[0]["id_user"])."/proforma_".$id_comanda_merge.".pdf");
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@toate judetele
			$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet");
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@regenerez proforma pdf
			require_once("../cont_utilizator/proforma.php");
			
			$pdf=new PDF("P", "mm", "A4");
			$pdf->AliasNbPages();
			$pdf->AddPage();
									
			//-------------------------------------------------------------------------------------------------------------------------
			//@date cumparator			
			if($arr_comanda[0]["tip_factura"]==1) //facturare pe persoana juridica
			{
				$pdf->cumparator=$arr_user[0]["societate"];
				$pdf->nr_reg_comert=$arr_user[0]["nr_reg_comert"];
				$pdf->cui=$arr_user[0]["cod_fiscal"];
				$pdf->contul=$arr_user[0]["cod_iban"];
				$pdf->banca=$arr_user[0]["banca"];
				$pdf->tip_facturare=1;
			}
			else //facturare pe persoana fizica
			{	
				$pdf->cumparator=$arr_user[0]["nume"]." ".$arr_user[0]["prenume"];
				$pdf->nr_reg_comert="-";
				$pdf->cui="CNP: ".$arr_user[0]["cnp"];
				$pdf->contul="-";
				$pdf->banca="-";
				$pdf->tip_facturare=0;
			}
			
			$pdf->adresa=$arr_user[0]["localitate"]." ".$arr_user[0]["adresa"];
			$pdf->judetul=$arr_judete[$arr_user[0]["id_jud"]];
			
			//@info client
			$pdf->nume_prenume=$arr_user[0]["nume"]." ".$arr_user[0]["prenume"];
			$pdf->societate=$arr_user[0]["societate"];
			$pdf->telefon=$arr_user[0]["telefon"];
			$pdf->fax=$arr_user[0]["fax"];
			$pdf->email=$arr_user[0]["email"];
			$pdf->cod_postal=$arr_user[0]["cod_postal"];
			$pdf->localitate=$arr_user[0]["localitate"];
			
			$user_adresa_livrare=unserialize($arr_comanda[0]["alta_adresa_livrare"]);
			
			$pdf->alta_adresa=array("adresa"=>$user_adresa_livrare["adresa"], 
									"cod_postal"=>$user_adresa_livrare["cod_postal"],
									"localitate"=>$user_adresa_livrare["localitate"],
									"judet"=>$arr_judete[$user_adresa_livrare["id_jud"]]);

			$pdf->comentariu_comanda=$arr_comanda[0]["comentariu_comanda"];
						
			//-------------------------------------------------------------------------------------------------------------------------
			//@adaug produsele
			$arr_produse=arrayFromDB("*", "t_produse_comenzi", "WHERE id_comanda='".$id_comanda."'");
			
			foreach($arr_produse as $key=>$value)
			{
				$pdf->adaugaProdus($value["nume_produs"], $value["cantitate"], $value["pret_produs"], $value["id_produs"]); //(nume_produs, cantitate, pret_unitar_fara_tva)
			}
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@adaug transportul
			$arr_transport=arrayFromDB("*", "t_transport", "WHERE id_transport='".$arr_comanda[0]["id_transport"]."'");
				
			$transport_cost=$arr_transport[0]["cost"];
			$transport=$arr_transport[0]["nume_transport"];
			
			$pdf->transport=$transport;
			$pdf->transport_cost=$transport_cost;
				
			$pdf->genereazaHeaderProforma();	
			$pdf->genereazaTabel();
			$pdf->genereazaInfoClient();
		
			//-------------------------------------------------------------------------------------------------------------------------
			//@incerc sa creez directorul criptat unde vor fi stocate proformele userului(daca nu s-a creat de prima data)
			@mkdir(URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$arr_user[0]["id_user"]), 0777);
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@salvez proforma
			$proforma_pdf=URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$arr_user[0]["id_user"])."/proforma_".$id_comanda.".pdf";
			$pdf->Output($proforma_pdf);
			
			$mesaj="Comanda [".$id_comanda_merge."] a fuzionat cu comanda [".$id_comanda."]!";
		}
		else
		{		
			$mesaj=implode("<br />", $mesaje);	
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@cautare	
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
		
		if(!empty($_REQUEST["tip_factura"]))
		{
			$sql_where.=" AND t_comenzi.tip_factura='".$tip_factura."'";
			$link_sufix.="&tip_factura=".$tip_factura;
		}
		
		if(!empty($_REQUEST["judet"]))
		{
			$sql_where.=" AND t_useri.id_jud='".$judet."'";
			$link_sufix.="&judet=".$judet;
		}
		
		//@copy paste pana am timp de o solutie mai buna
		if(!isset($_REQUEST["de_la"]) && !isset($_REQUEST["pana_la"])) 
		{
			$arr_de_la=arrayFromDB(array("MIN(data_comanda) AS de_la"), "t_comenzi", "WHERE stare='0' OR stare='1'");
			$de_la=date("Ymd", (empty($arr_de_la[0]["de_la"]))?time():$arr_de_la[0]["de_la"]);
			
			$arr_pana_la=arrayFromDB(array("MAX(data_comanda) AS pana_la"), "t_comenzi", "WHERE stare='0' OR stare='1'");
			$pana_la=date("Ymd", (empty($arr_de_la[0]["pana_la"]))?time():$arr_de_la[0]["pana_la"]);
		}
		else 
		{
			$de_la=$_REQUEST["de_la"];
			$pana_la=$_REQUEST["pana_la"];
		}
	
		$timestamp_de_la=strtotime($de_la);
		$timestamp_pana_la=strtotime($pana_la)+(60*60*24)-1; //formula asta inseamna (pana_la) + 23h 59min 59sec;
		
		if($timestamp_de_la > $timestamp_pana_la)
		{
			$mesaj="Perioada este invalida!";
		}
		else 
		{
			if($timestamp_de_la == $timestamp_pana_la)
				$timestamp_pana_la=$timestamp_de_la+(60*60*24)-1;
			
			$sql_where.=" AND data_comanda BETWEEN ".$timestamp_de_la." AND ".$timestamp_pana_la;
			$link_sufix.="&de_la=".$de_la."&pana_la=".$pana_la."&cauta";
		}
	}
	
	if(!isset($_REQUEST["de_la"]) && !isset($_REQUEST["pana_la"]) && !isset($_REQUEST["cauta"])) 
	{
		$arr_de_la=arrayFromDB(array("MIN(data_comanda) AS de_la"), "t_comenzi", "WHERE stare='0' OR stare='1'");
		$de_la=date("Ymd", (empty($arr_de_la[0]["de_la"]))?time():$arr_de_la[0]["de_la"]);
		
		$arr_pana_la=arrayFromDB(array("MAX(data_comanda) AS pana_la"), "t_comenzi", "WHERE stare='0' OR stare='1'");
		$pana_la=date("Ymd", (empty($arr_de_la[0]["pana_la"]))?time():$arr_de_la[0]["pana_la"]);
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@judete
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet", "ORDER BY judet ASC");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@metode de plata
	$arr_metode_plata=arrayFromDBtoCombo("t_metode_plata", "id_metoda_plata", "metoda_plata");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtrare comenzi noi
	if(!isset($sql_where))
		$sql_where="";
	if(!isset($link_sufix))
		$link_sufix="";

	if(isset($_REQUEST["stare"]) && $_REQUEST["stare"]=="asteptare")
	{
		$sql_where.=" AND stare='4'";
		$link_sufix.="&stare=asteptare";
	}
	else 
	{
		$sql_where.=" AND (stare='0' OR stare='1')";
	}
	
	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_comanda) AS nr FROM t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user WHERE 1 ".$sql_where, 
						    URL_ADMIN."comenzi_noi.php?pag=".PATTERN.$link_sufix); 
	$paginare_string=$paginare->doPaginare();
	$nr_rezultate=$paginare->getNrRezultate(); 
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectare tranzactii (comenzi)
	$arr_tranzactii=arrayFromDB("*",
							    "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user
							    		   LEFT JOIN t_transport ON t_comenzi.id_transport=t_transport.id_transport",
							    "WHERE 1 ".$sql_where." ORDER BY id_comanda ASC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	$j=0;	
	if(is_array($arr_tranzactii))
	{				    
		foreach($arr_tranzactii as $key=>$value)
		{
			//-------------------------------------------------------------------------------------------------------------------------					   
			//@nr comenzi onorate, anulate
			$arr_comenzi_anulate=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='3' AND id_user='".$value["id_user"]."'");
			$arr_comenzi_onorate=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='2' AND id_user='".$value["id_user"]."'");		
			$arr_comenzi_noi=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE (stare='0' OR stare='1') AND id_user='".$value["id_user"]."'");
			
			$alta_adresa_livrare="";
			if(!empty($value["alta_adresa_livrare"]))
			{
				$alta_adresa=unserialize($value["alta_adresa_livrare"]);
				
				foreach($alta_adresa as $k=>$v)
				{
					if($k=="id_jud")
						$alta_adresa_livrare.="Judet: <b>".$arr_judete[$v]."</b><br />";
					else
						$alta_adresa_livrare.=ucwords(str_replace("_", " ", $k)).": <b>".$v."</b><br />";
				}	
			}
			
			//-------------------------------------------------------------------------------------------------------------------------
			//@date client
			$arr_date_client=array("username"=>$value["username"],
								   "email"=>$value["email"],
								   "nume"=>$value["nume"]." ".$value["prenume"], 
								   "cnp"=>$value["cnp"],
								   "adresa"=>$value["adresa"],
								   "cod_postal"=>$value["cod_postal"],
								   "localitate"=>$value["localitate"],
								   "judet"=>$arr_judete[$value["id_jud"]],
								   "telefon"=>$value["telefon"],
								   "telefon_mobil"=>$value["telefon_mobil"],
								   "fax"=>$value["fax"],
								   "societate"=>$value["societate"],
								   "cod_fiscal"=>$value["cod_fiscal"],
								   "nr_reg_comert"=>$value["nr_reg_comert"],
								   "banca"=>$value["banca"],
								   "cod_iban"=>$value["cod_iban"],
								   "tip_factura"=>($value["tip_factura"]==0)?"pers. fizica":"pers. juridica",
								   "alta_adresa"=>$alta_adresa_livrare,
								   "comentariu_comanda"=>$value["comentariu_comanda"],
								   "nr_comenzi_anulate"=>$arr_comenzi_anulate[0]["nr"],
								   "nr_comenzi_onorate"=>$arr_comenzi_onorate[0]["nr"],
								   "nr_comenzi_noi"=>$arr_comenzi_noi[0]["nr"]);											   	
								   
			//-------------------------------------------------------------------------------------------------------------------------
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
			$comenzi[$j]=array("date_client"=>$arr_date_client,
							   "id_comanda"=>$value["id_comanda"],
							   "data_comenzii"=>date(DATA_FORMAT." H:i", $value["data_comanda"]),
							   "produse"=>$produse_comanda,
							   "total_comanda"=>formateazaNr($value["total_comanda"]),
							   "proforma"=>$dir_proforme."proforma_".$value["id_comanda"].".pdf",
							   "transport"=>$value["nume_transport"]." - ".formateazaNr(($value["total_comanda"]>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$value["cost"])." ".MONEDA,
							   "stare_comanda"=>$stare_comanda[$value["stare"]],
							   "stare"=>$value["stare"],
							   "nota_admin"=>$value["nota_admin"],
							   "metoda_plata"=>$arr_metode_plata[$value["id_metoda_plata"]],
							   "achitata"=>($value["comanda_achitata"]==1)?"DA":"NU");			
				
			unset($arr_produse_comanda, $produse_comanda);				
			$j++;		
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@patch pt redirect corect in cazul cand se onoreaza o comanda si nu exista rezultate pe pagina respectiva
	if(isset($_GET["pag"]) && is_numeric($_GET["pag"]) && $_GET["pag"]>1 && $j==0)
	{
		header("Location:".str_replace("pag=".$_GET["pag"], "pag=".($_GET["pag"]-1), $_SERVER["REQUEST_URI"]));
		exit;
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@total cumparaturi din perioada data
	$arr_total_cumparaturi=arrayFromDB(array("SUM(total_comanda) AS total"), "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user", "WHERE 1 ".$sql_where);
	
	//@nr comenzi care au beneficiat de transport gratuit si nr comenzi cu transport platit
	if(TRANSPORT_GRATUIT>0)
	{
		$arr_comenzi_fara_transport=arrayFromDB(array("COUNT(id_comanda) AS nr_comenzi"), "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user", "WHERE total_comanda >= ".TRANSPORT_GRATUIT." ".$sql_where);
		$arr_comenzi_cu_transport=arrayFromDB(array("COUNT(id_comanda) AS nr_comenzi"), "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user", "WHERE total_comanda < ".TRANSPORT_GRATUIT." ".$sql_where);
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@stergere mesaj (onorare comanda) din sesiune
	unset($_SESSION["mesaj"]);
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
		
	//@afisare erori/mesaje
	if(!isset($mesaj)) $mesaj="";
	if(!isset($nume)) $nume="";
	if(!isset($prenume)) $prenume="";
	if(!isset($societate)) $societate="";
	if(!isset($user_client)) $user_client="";
	if(!isset($tip_factura)) $tip_factura="";
	if(!isset($judet)) $judet="";
	if(!isset($comenzi) || !is_array($comenzi)) $comenzi=array();
	if(!isset($arr_comenzi_cu_transport[0])) $arr_comenzi_cu_transport=array(array("nr_comenzi"=>0));
	if(!isset($arr_comenzi_fara_transport[0])) $arr_comenzi_fara_transport=array(array("nr_comenzi"=>0));
	$smarty->assign("mesaj", $mesaj);

	//@status
	$smarty->assign("status", isset($_REQUEST["stare"]) ? $_REQUEST["stare"] : "");
	
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
	
	//@nr comenzi cu transport gratuit si nr comenzi cu transport platit
	$smarty->assign("nr_comenzi_cu_transport", $arr_comenzi_cu_transport[0]["nr_comenzi"]);
	$smarty->assign("nr_comenzi_fara_transport", $arr_comenzi_fara_transport[0]["nr_comenzi"]);
	
	//@stari comenzi (combobox)
	$smarty->assign("stare_comanda", $stare_comanda);
	
	//@afisare tranzactii (comenzi)
	$smarty->assign("comenzi", $comenzi);
	
	//@nr rezultate - comenzi neonorate
	$smarty->assign("nr_rezultate", $nr_rezultate);
	
	//@total_cumparaturi
	$smarty->assign("total_cumparaturi", formateazaNr($arr_total_cumparaturi[0]["total"]));
	
	//@afisare paginare
	$smarty->assign("paginare", $paginare_string);
	
	//@pagina
	$smarty->assign("pag", isset($_GET["pag"]) ? $_GET["pag"] : 1);
	
	require_once("right.php");
	require_once("bottom.php");
?>