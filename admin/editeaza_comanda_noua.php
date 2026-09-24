<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2008       		   **
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
	$display_page="admin/editeaza_comanda_noua.tpl";	
	
	if(isset($_GET["id_comanda"]) && is_numeric($_GET["id_comanda"]) && !empty($_GET["id_comanda"]))
	{
		$id_comanda=$_GET["id_comanda"];	
		
		$arr_comanda_check=arrayFromDB("*", "t_comenzi", "WHERE id_comanda='".$id_comanda."' AND (stare='0' OR stare='1' OR stare='4')");
		
		if(count($arr_comanda_check)!=1)
			header("Location:".URL_ADMIN."comenzi_noi.php?pag=".$_GET["pag"]);
			
		$discount=(!empty($arr_comanda_check[0]["discount_flag"]))?1:0;	
	}
	else die("Comanda selectata nu este valida!");	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez listele de discount
	$arr_liste_discount=arrayFromDB("*", "t_liste_discount", "ORDER BY id_lista ASC");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@liste combobox
	foreach($arr_liste_discount as $key=>$value)
		$liste_combobox[$value["id_lista"]]=$value["nume_lista"];
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare comanda
	if(isset($_POST["modifica"]))
	{
		$arr_chilipir=arrayFromDB(array("id_produs"), "t_chilipirul_zilei", "WHERE data_chilipir='".date("Ymd")."'");
		$id_produs_chilipir=$arr_chilipir[0]["id_produs"];
		
		$discount=(isset($_POST["discount"]))?1:0;	
				
		if(isset($_POST["lista_discount"]) && is_numeric($_POST["lista_discount"]) && !empty($_POST["lista_discount"]) && $discount==1)
		{
			$arr_lista_discounturi=arrayFromDB("*", "t_liste_discount_categorii", "WHERE id_lista='".$_POST["lista_discount"]."'");
			
			foreach($arr_lista_discounturi as $key=>$value)
				arrayUpdateToDB("t_categorii", array("discount"), array($value["discount"]), array("id"=>"id_cat", "valoare"=>$value["id_cat"]));
	
			arrayUpdateToDB("t_liste_discount", array("ultima_lista_folosita"), array("0"));
			arrayUpdateToDB("t_liste_discount", array("ultima_lista_folosita"), array("1"), array("id"=>"id_lista", "valoare"=>$_POST["lista_discount"]));
		}
				
		$arr_produse_comanda=arrayFromDB("*",
								 		 "t_produse_comenzi LEFT JOIN t_produse ON t_produse_comenzi.id_produs=t_produse.id_produs
								 		 					LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
								 		 "WHERE id_comanda='".$id_comanda."' ORDER BY id ASC");
		
		$nr_produse_comanda=count($arr_produse_comanda);
								 		 
		for($i=0;$i<$nr_produse_comanda;$i++)
		{
			if(is_numeric($_POST["cantitati"][$i]))
			{
				if($_POST["cantitati"][$i]==0)
				{
					arrayDeleteFromDB("t_produse_comenzi", array("id"), array($arr_produse_comanda[$i]["id"]));
				}
				else 
				{
					if(!empty($arr_produse_comanda[$i]["discount"]) && $discount==1 && $id_produs_chilipir!=$arr_produse_comanda[$i]["id_produs"])
					{
						arrayUpdateToDB("t_produse_comenzi", 
										 array("cantitate", "pret_produs"),
										 array($_POST["cantitati"][$i], $arr_produse_comanda[$i]["pret"]-(($arr_produse_comanda[$i]["pret"] * $arr_produse_comanda[$i]["discount"])/100)),
										 array("id"=>"id", "valoare"=>$arr_produse_comanda[$i]["id"]));
					}
					else 
					{
						arrayUpdateToDB("t_produse_comenzi", 
										 array("cantitate", "pret_produs"),
										 array($_POST["cantitati"][$i], $arr_produse_comanda[$i]["pret"]),
										 array("id"=>"id", "valoare"=>$arr_produse_comanda[$i]["id"]));	
					}										
				}
			}
		}

		if(isset($_POST["id_produs_nou"]) && is_numeric($_POST["id_produs_nou"]) && !empty($_POST["id_produs_nou"]))
		{
			$arr_produs_nou=arrayFromDB("*", "t_produse", "WHERE id_produs='".$_POST["id_produs_nou"]."'");
			$arr_produs_nou_check=arrayFromDB("*", "t_produse_comenzi", "WHERE id_produs='".$_POST["id_produs_nou"]."' AND id_comanda='".$id_comanda."'");
			
			if(count($arr_produs_nou)==1 && count($arr_produs_nou_check)==0)
			{
				arrayInsertToDB("t_produse_comenzi",
								 array("id_comanda", "id_produs", "pret_produs", "nume_produs", "cantitate"),
								 array($id_comanda, $arr_produs_nou[0]["id_produs"], $arr_produs_nou[0]["pret"], $arr_produs_nou[0]["nume_produs"], 1));				
				
				$mesaj="Produsul nou a fost adagat!<br />";				 
			}
			else 
			{
				$mesaj="Produsul nou nu a fost adaugat deoarece ID-ul introdus nu este valid!<br />";
			}
		}
		
		$arr_total_comanda=arrayFromDB(array("SUM(pret_produs * cantitate) AS total_comanda"), "t_produse_comenzi", "WHERE id_comanda='".$id_comanda."'");
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@update total comanda, discount, comanda
		arrayUpdateToDB("t_comenzi",
						 array("total_comanda", "discount_flag", "id_transport"), array($arr_total_comanda[0]["total_comanda"] * TVA, $discount, $_POST["transport"]),
						 array("id"=>"id_comanda", "valoare"=>$id_comanda));			
		
		$arr_comanda=arrayFromDB("*", "t_comenzi", "WHERE id_comanda='".$id_comanda."'");
		$arr_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$arr_comanda[0]["id_user"]."'");
		$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet");
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@regenerez proforma pdf
		require_once("../cont_utilizator/proforma.php");
		
		$pdf=new PDF("P", "mm", "A4");
		$pdf->AliasNbPages();
		$pdf->AddPage();
								
		//-----------------------------------------------------------------------------------------------------------------------------
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
		$pdf->telefon_mobil=$arr_user[0]["telefon_mobil"];
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
					
		//-----------------------------------------------------------------------------------------------------------------------------
		//@adaug produsele
		$arr_produse=arrayFromDB("*",
								 "t_produse_comenzi AS a LEFT JOIN t_produse AS b ON a.id_produs=b.id_produs
								 						 LEFT JOIN t_categorii AS c on b.id_cat=c.id_cat",
								 "WHERE id_comanda='".$id_comanda."'");
		
		foreach($arr_produse as $key=>$value)
		{
			$nume_produs=$value["nume_produs"];
			$pret_produs=$value["pret"];
			
			//@adaug produs in pdf
			$pdf->adaugaProdus($nume_produs, $value["cantitate"], $pret_produs, $value["id_produs"]); //(nume_produs, cantitate, pret_unitar_fara_tva, id_produs)
			
			//@adaug discount produs in pdf
			if(!empty($value["discount"]) && $value["discount"]!=0 && $discount==1) //am facut verificare cu !=0, pt ca 0.000 nu e considerat empty()
			{
				$nume_produs=$value["nume_produs"]." - Discount ".$value["discount"]."%";
				$pret_produs=-(($value["pret"] * $value["discount"])/100);
				$pdf->adaugaProdus($nume_produs, $value["cantitate"], $pret_produs, $value["id_produs"]); //(nume_produs, cantitate, pret_unitar_fara_tva, id_produs)
			}
		}
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@adaug transportul
		$arr_transport=arrayFromDB("*", "t_transport", "WHERE id_transport='".$arr_comanda[0]["id_transport"]."'");
			
		$transport_cost=$arr_transport[0]["cost"];
		$transport=$arr_transport[0]["nume_transport"];
		
		$pdf->transport=$transport;
		$pdf->transport_cost=$transport_cost;
			
		$pdf->genereazaHeaderProforma();	
		$pdf->genereazaTabel();
		$pdf->genereazaInfoClient();
	
		//-----------------------------------------------------------------------------------------------------------------------------
		//@incerc sa creez directorul criptat unde vor fi stocate proformele userului(daca nu s-a creat de prima data)
		@mkdir(URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$arr_user[0]["id_user"]), 0777);
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@salvez proforma
		$proforma_pdf=URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$arr_user[0]["id_user"])."/proforma_".$id_comanda.".pdf";
		$pdf->Output($proforma_pdf);
		
		//@salvez factura fiscala - tziganie copy/paste pt a termina mai rpd
		require_once("factura_fiscala.php");		
		
		$mesaj.="Comanda a fost modificata cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectare tranzactie (comanda)
	$arr_tranzactii=arrayFromDB("*",
							    "t_comenzi LEFT JOIN t_useri ON t_comenzi.id_user=t_useri.id_user
							    		   LEFT JOIN t_transport ON t_comenzi.id_transport=t_transport.id_transport",
							    "WHERE t_comenzi.id_comanda='".$id_comanda."'");					    
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectare produse cumparate asociate comenzii
	$arr_produse_comanda=arrayFromDB("*",
							 		 "t_produse_comenzi LEFT JOIN t_produse ON t_produse_comenzi.id_produs=t_produse.id_produs
							 		 					LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat",
							 		 "WHERE id_comanda='".$arr_tranzactii[0]["id_comanda"]."' ORDER BY id ASC");

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
	$dir_proforme=URL_BASE."proforme/".md5($arr_tranzactii[0]["data_inregistrarii"].$arr_tranzactii[0]["id_user"])."/";
	
	//@array cu data comenzii si produsele cumparate
	$comenzi[]=array("id_comanda"=>$arr_tranzactii[0]["id_comanda"],
					 "data_comenzii"=>date(DATA_FORMAT." H:i", $arr_tranzactii[0]["data_comanda"]),
					 "produse"=>$produse_comanda,
					 "total_comanda"=>formateazaNr($arr_tranzactii[0]["total_comanda"]),
					 "proforma"=>$dir_proforme."proforma_".$arr_tranzactii[0]["id_comanda"].".pdf",
					 "id_transport"=>$arr_tranzactii[0]["id_transport"],
					 "transport"=>$arr_tranzactii[0]["nume_transport"]." - ".formateazaNr(($arr_tranzactii[0]["total_comanda"]>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$arr_tranzactii[0]["cost"])." ".MONEDA,
					 "stare_comanda"=>$stare_comanda[$arr_tranzactii[0]["stare"]],
					 "stare"=>$arr_tranzactii[0]["stare"]);			
			
	//@transport combo
	$transport=arrayFromDBtoCombo("t_transport", "id_transport", "nume_transport");
			 				 
	//---------------------------------------------------------------------------------------------------------------------------------
	//@adresa factura fiscala	
	if(file_exists(URL_BASE_ABS."proforme/".md5($arr_tranzactii[0]["data_inregistrarii"].$arr_tranzactii[0]["id_user"])."/factura_fiscala_".$id_comanda.".pdf"))
		$adresa_factura_fiscala_pdf=URL_BASE."proforme/".md5($arr_tranzactii[0]["data_inregistrarii"].$arr_tranzactii[0]["id_user"])."/factura_fiscala_".$id_comanda.".pdf?".time();
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
		
	//@afisare erori/mesaje
	$smarty->assign("mesaj", $mesaj);

	//@afisare tranzactii (comenzi)
	$smarty->assign("comenzi", $comenzi);
	
	//@discount comanda (daca e setat = 1, daca nu = 0)
	$smarty->assign("discount", $discount);
	
	//@liste discount
	$smarty->assign("liste_combobox", $liste_combobox);
	
	//@transport
	$smarty->assign("transport", $transport);	
	
	//@adresa factura fiscala
	$smarty->assign("factura_fiscala", $adresa_factura_fiscala_pdf);
	
	//@pagina
	$smarty->assign("pag", $_GET["pag"]);
	
	//@status
	$smarty->assign("status", $_GET["stare"]);
	
	require_once("right.php");
	require_once("bottom.php");
?>