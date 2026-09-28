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
	require_once("../top.php");
	require_once("../left.php");
	require_once("../right.php");
	require_once("../functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------	
	//@verificare login
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/finalizeaza_comanda.tpl";
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Finalizeaza comanda";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@date user
	$arr_user=arrayFromDB("*",
						  "t_useri LEFT JOIN t_judete ON t_useri.id_jud=t_judete.id_jud",
						  "WHERE id_user='".(isset($_SESSION["id_user"]) ? $_SESSION["id_user"] : 0)."'");

	$user_adresa_livrare["adresa"]=isset($arr_user[0]["adresa"]) ? $arr_user[0]["adresa"] : "";
	$user_adresa_livrare["cod_postal"]=isset($arr_user[0]["cod_postal"]) ? $arr_user[0]["cod_postal"] : "";
	$user_adresa_livrare["localitate"]=isset($arr_user[0]["localitate"]) ? $arr_user[0]["localitate"] : "";
	$user_adresa_livrare["id_jud"]=isset($arr_user[0]["id_jud"]) ? $arr_user[0]["id_jud"] : "";
						   
	//--------------------------------------------------------------------------------------------------------------------------
	//@toate judetele
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet");	

	//--------------------------------------------------------------------------------------------------------------------------
	//@judet user
	$scutit_de_comanda_minima=false;
	
	if(isset($_SESSION["id_user"]) && is_numeric($_SESSION["id_user"]) && !empty($_SESSION["id_user"]))
	{
		$arr_judet_user=arrayFromDB("*", "t_useri INNER JOIN t_judete ON t_useri.id_jud=t_judete.id_jud", "WHERE id_user='".$_SESSION["id_user"]."'");
		$id_judet_user=$arr_judet_user[0]["id_jud"];
		
		if(in_array($id_judet_user, $arr_judete_preferentiale))
			$scutit_de_comanda_minima=true;
	}

	//--------------------------------------------------------------------------------------------------------------------------
	//@metoda plata
	$arr_metode_plata=arrayFromDBtoCombo("t_metode_plata", "id_metoda_plata", "metoda_plata");
	
	//--------------------------------------------------------------------------------------------------------------------------	
	$total_cos=0;
	$erori_cos=false;
	
	//@afisare produse cos curent
	if(is_array($produse) && count($produse)>0)
	{
		foreach($produse as $key=>$value)
		{
			//@poza produs			
			$adresa_poza=getPozaPrincipalaMicaProdus($value["id_produs"]);
			
			//@check against stoc (NU_E_PE_STOC e definita in configurare.php)
			if($cos->getStoc($value["id_produs"])==NU_E_PE_STOC)
			{
				$stoc=0;
				$erori_cos=true;
			}
			else $stoc=1;
			
			$cosul_meu[]=array("id_produs"=>$value["id_produs"],
							   "nume_produs"=>prepareStringFromDB($value["nume_produs"]),
							   "link_produs"=>URL_BASE.$value["link_categorie_produs"]."/".prepareLink($value["nume_produs"])."--".$value["id_produs"],
							   "link_sterge_produs"=>URL_BASE."cosul-meu/sterge-produs/".$value["id_produs"],
							   "poza_produs"=>$adresa_poza,
							   "cantitate"=>$value["cantitate"],
							   "stoc"=>$stoc,
							   "pret_unitar"=>formateazaNr($value["pret_unitar"]),
							   "pret_total"=>formateazaNr($cos->GetSubTotal($value["id_produs"])));				
			
			$total_cos+=$cos->GetSubTotal($value["id_produs"]);				
		}
	}
	else 
	{
		die("Nu aveti nici un produs in cos!");
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@verificari aditionale pentru cos, daca a trecut de javascript
	if($erori_cos)
		die("Pentru a finaliza comanda, trebuie sa stergeti produsele din cos care nu mai sunt pe stoc !");
		
	if($total_cos<COMANDA_MINIMA)
	{
		//@conditii suplimentare (daca utilizatorul a mai comandat inainte si comanda nu a fost onorate, mai poate comanda o data fara sa fie nevoie sa indeplineasca "COMANDA MINIMA"
		$arr_comenzi_anterioare=arrayFromDB("*", "t_comenzi", "WHERE id_user='".$_SESSION["id_user"]."' AND (stare=0 OR stare=1)");
		
		if(count($arr_comenzi_anterioare)==0 && $scutit_de_comanda_minima==false)
			die("Valoarea cosului este mai mica decat comanda minima !");	
	}
	
	//@transport
	if(isset($_SESSION["transport"]) && is_numeric($_SESSION["transport"]))
	{
		$arr_transport=arrayFromDB("*", "t_transport", "WHERE id_transport='".prepareStringToDB($_SESSION["transport"])."'");
				
		$transport_cost=$arr_transport[0]["cost"];
		$transport_nume=$arr_transport[0]["nume_transport"];		
	}
	else 
	{
		die("Nu ati ales metoda de transport!-".$_SESSION["transport"]);
	}	
					
	//-------------------------------------------------------------------------------------------------------------------------
	//@trimite comanda
	if(isset($_POST["trimite_comanda"]) && $_POST["trimite_comanda"])
	{
		$erori=0;
		
		if(isset($_POST["adresa_livrare"]) && $_POST["adresa_livrare"]==1)
		{
			//-----------------------------------------------------------------------------------------------------------------
			//@validare adresa de livrare (daca e bifata)	
			require_once("../clase/valideazaUser.php");
			
			//@instantiez clasa valideazaUser
			$validare=new valideazaUser();
			
			$adresa_check=$validare->valideazaCamp($_POST["adresa"], "adresa");
			$cod_postal_check=$validare->valideazaCodPostal($_POST["cod_postal"]);
			$localitate_check=$validare->valideazaCamp($_POST["localitate"], "localitate");
			$judet_check=$validare->valideazaJudet($_POST["judet"]);
			
			$erori=$validare->getErori();
			
			$user_adresa_livrare["adresa"]=$adresa_check["camp"];
			$user_adresa_livrare["cod_postal"]=$cod_postal_check["camp"];
			$user_adresa_livrare["localitate"]=$localitate_check["camp"];
			$user_adresa_livrare["id_jud"]=$_POST["judet"];
		}
		
		//----------------------------------------------------------------------------------------------------------------------
		//@trimit comanda daca totul e ok :P
		if($erori==0)
		{
			$id_comanda=arrayInsertToDB("t_comenzi",
										array("id_user",
											  "data_comanda",
											  "alta_adresa_livrare",
											  "comentariu_comanda",
											  "tip_factura",
											  "total_comanda",
											  "stare",
											  "id_transport",
											  "id_metoda_plata",
											  "comanda_achitata"),
										array($_SESSION["id_user"],
											  time(),
											  ($_POST["adresa_livrare"]==1)?serialize($user_adresa_livrare):"",
											  $_SESSION["comentariu_comanda"],
											  $_POST["tip_factura"],
											  $total_cos,
											  0,
											  $_SESSION["transport"],
											  $_POST["metoda_plata"],
											  0));
			
			foreach($produse as $key=>$value)
			{							 
				arrayInsertToDB("t_produse_comenzi",
								array("id_comanda", "id_produs", "pret_produs", "nume_produs", "cantitate"),
								array($id_comanda, $value["id_produs"], $value["pret_unitar"], $value["nume_produs"], $value["cantitate"]));

				//@incrementez cantitatea cumparata => bestseller				
				arrayUpdateToDB("t_produse",
								array("bestseller"),
								array("bestseller+".$value["cantitate"]),
								array("id"=>"id_produs", "valoare"=>$value["id_produs"]),
								true);	
			
				//-------------------------------------------------------------------------------------------------------------					
				//@actualizare stoc produse din programul de gestiune
				if(STOCURI_IN_TIMP_REAL)
				{
					//@aflu cod produs -> in mod normal aceasta interogare nu ar fi trebuit executata daca array-ul $produse continea "cod_produs" de la bun inceput
					$arr_cod_produs=arrayFromDB(array("cod_produs"), "t_produse", "WHERE id_produs='".$value["id_produs"]."'");
					
					if(!empty($arr_cod_produs[0]["cod_produs"]))
					{
						//@verific daca produsul exista in tabela de stocuri (mai intai produsul tb introdus printr-un NIR pt a exista in tabela de stocuri)
						($db!=DB_STOCURI)?$mysqli->select_db(DB_STOCURI):"";
						
						$arr_stoc_produs=arrayFromDB("*", "_t_stocuri", "WHERE cod_produs='".$arr_cod_produs[0]["cod_produs"]."'");
						
						if(count($arr_stoc_produs)==1)
							arrayUpdateToDB("_t_stocuri", array("cantitate_curenta"), array("cantitate_curenta-".$value["cantitate"]), array("id"=>"id", "valoare"=>$arr_stoc_produs[0]["id"]), true);
							
						($db!=DB_STOCURI)?$mysqli->select_db($db):"";	
					}
				}							
			}
			
			//-----------------------------------------------------------------------------------------------------------------
			//@generez proforma pdf si o stochez in folderul criptat al utilizatorului (cool stuff huh)
			require_once("proforma.php");
			
			$pdf=new PDF("P", "mm", "A4");
			$pdf->AliasNbPages();
			$pdf->AddPage();
									
			//-----------------------------------------------------------------------------------------------------------------
			//@date cumparator			
			if($_POST["tip_factura"]==1) //facturare pe persoana juridica
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
			$pdf->alta_adresa=array("adresa"=>$user_adresa_livrare["adresa"], 
									"cod_postal"=>$user_adresa_livrare["cod_postal"],
									"localitate"=>$user_adresa_livrare["localitate"],
									"judet"=>$arr_judete[$user_adresa_livrare["id_jud"]]);
			$pdf->comentariu_comanda=$_SESSION["comentariu_comanda"];						
						
			//-----------------------------------------------------------------------------------------------------------------
			//@adaug produsele
			foreach($produse as $key=>$value)
			{
				$pdf->adaugaProdus($value["nume_produs"], $value["cantitate"], $value["pret_unitar"], $value["id_produs"]); //(nume_produs, cantitate, pret_unitar_fara_tva)
			}
			
			//-----------------------------------------------------------------------------------------------------------------
			//@adauga transportul
			$pdf->transport=$transport_nume;
			$pdf->transport_cost=$transport_cost;
				
			$pdf->genereazaHeaderProforma();	
			$pdf->genereazaTabel();
			$pdf->genereazaInfoClient();
		
			//-----------------------------------------------------------------------------------------------------------------
			//@incerc sa creez directorul criptat unde vor fi stocate proformele userului(daca nu s-a creat de prima data)
			@mkdir(URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$_SESSION["id_user"]), 0777);
			
			//-----------------------------------------------------------------------------------------------------------------
			//@salvez proforma
			$proforma_pdf=URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$_SESSION["id_user"])."/proforma_".$id_comanda.".pdf";
			$pdf->Output($proforma_pdf);

			//-----------------------------------------------------------------------------------------------------------------
			//@trimit comanda pe mailul utilizatorului si pe cea a magazinului + proforma pdf atasata in mail
			require_once("../clase/phpmailer.php");
			
			//@subiect mail
			$subiect="Comanda de pe site-ul ".NUME_DOMENIU_SITE." - facuta pe data de ".date(DATA_FORMAT);			
		
			//-----------------------------------------------------------------------------------------------------------------
			//@instantiez clasa phpmailer
			$mail=new PHPMailer();
			
			//@setez limba pt erori
			$mail->SetLanguage("ro", URL_BASE_ABS."clase/phpmailer_lang/");
			
			$mail->From="no-reply@".NUME_DOMENIU_SITE;
			$mail->FromName=NUME_DOMENIU_SITE;
			
			//@mail catre cumparator
			$mail->AddAddress($arr_user[0]["email"]);
			
			//@mail catre departamentul de vanzari
			$mail->AddBCC($arr_departamente[2]["email"]);
			
			$mail->Body=$mail_css_style. //$mail_css_style e definita in config
						"<table width=\"650\" class=\"margine\">
							<tr>
								<td align=\"left\">
									<a href=\"".URL_BASE."\"><img src=\"cid:sigla\" alt=\"".NUME_FIRMA."\" border=\"0\"></a>																	
								</td>
							</tr>
							<tr><td height=\"1\" class=\"bg_spatiu\"></td></tr>
							<tr><td style=\"padding-top:10px\"><h1>".$subiect."</h1></td></tr>
							<tr>
								<td style=\"padding-top:10px\">
									<p>Buna ziua,</p>
									<p>
										Aceasta este comanda dvs:
										<table cellpadding=\"2\" style=\"margin-top:10px\" class=\"margine\" width=\"600\">
										   <tr bgcolor=\"#F2F2F2\">
										   	  <td valign=\"middle\" width=\"340\"><b>Nume produs</b></td>
										   	  <td valign=\"middle\" width=\"90\"><b>Cantitate</b></td>
										   	  <td valign=\"top\" align=\"center\" width=\"110\"><b>Pret unitar <br />(".((TVA == 1)?"cu":"fara")." TVA)</b></td>
										   	  <td valign=\"top\" align=\"center\" width=\"110\"><b>Pret total <br />(cu TVA)</b></td>
										   </tr>";
			
			$total=0;			
			foreach($produse as $key=>$value)
			{			
				$mail->Body.=		  	  "<tr>									  
											  <td valign=\"top\" align=\"left\">".$value["nume_produs"]."</td>
											  <td valign=\"top\" align=\"center\" align=\"center\">".$value["cantitate"]."</td>
											  <td valign=\"top\" align=\"right\"><b>".formateazaNr($value["pret_unitar"])."</b> ".MONEDA."</td>
											  <td valign=\"top\" align=\"right\"><b>".formateazaNr($value["pret_unitar"]*$value["cantitate"]*TVA)."</b> ".MONEDA."</td>
										   </tr>";
				
				$total+=$value["pret_unitar"]*$value["cantitate"]*TVA;
			}
			
			if($transport_nume!="" && is_numeric($transport_cost))
			{
				$mail->Body.=		      "<tr>									  
											  <td colspan=\"3\" align=\"right\"><b>Transport:</b> ".$transport_nume."</td>
											  <td valign=\"top\" align=\"right\"><b>".formateazaNr(($total>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$transport_cost)."</b> ".MONEDA."</td>
										   </tr>";
			}
			
			$mail->Body.=		          "<tr bgcolor=\"#F2F2F2\">									  
											  <td colspan=\"3\" align=\"right\"><b>Total de plata:</b></td>
											  <td valign=\"top\" align=\"right\"><b>".formateazaNr($total+(($total>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$transport_cost))."</b> ".MONEDA."</td>
										   </tr>";
					
			$mail->Body.=				"</table>
										<p><b>Adresa de livrare:</b></p>
										<table style=\"margin-top:10px\" class=\"margine\">
											<tr><td>Adresa: <b>".$user_adresa_livrare["adresa"]."</b></td>
											<tr><td>Cod Postal: <b>".$user_adresa_livrare["cod_postal"]."</b></td></tr>
											<tr><td>Localitate: <b>".$user_adresa_livrare["localitate"]."</b></td></tr>
											<tr><td>Judet: <b>".$arr_judete[$user_adresa_livrare["id_jud"]]."</b></td></tr>
										</table>																			
									</p>
									<p>Atasat aveti si factura proforma in format \"pdf\" (necesita Acrobat Reader pt vizualizare/printare).</p>
									<p>Va multumim pentru comanda si va mai asteptam cu placere pe site-ul nostru!</p>
								</td>
							</tr>
						</table>";
	                     
		    $mail->Subject=$subiect;
		    $mail->IsHTML(true);
		        
			$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");
			
			//------------------------------------------------------------------------------------------------------------------
			//@atasez proforma pdf
			$mail->AddAttachment($proforma_pdf, "proforma_".$id_comanda.".pdf");
			
			//------------------------------------------------------------------------------------------------------------------
			//@trimit mailul
			if(!$mail->Send())
				print "Eroare trimitere e-mail..".$mail->ErrorInfo;
			
			//------------------------------------------------------------------------------------------------------------------	
			//PLATA ONLINE
			$plata_online=false;
			
			if(isset($_POST["metoda_plata"]) && $_POST["metoda_plata"]==2)
			{
				require_once("../plata_online/modul_epayment.php");
				$plata_online=true;
			}	
						
			//------------------------------------------------------------------------------------------------------------------
			//@golesc cosul
			$cos->golesteCos();
			
			//------------------------------------------------------------------------------------------------------------------
			//@afisez pagina de confirmare a comenzii
			if(!$plata_online)
				$display_page="cont_utilizator/comanda_trimisa.tpl";
		}
	}	
		
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
		
	//@date user
	$smarty->assign("user", $arr_user[0]);
	
	//@adresa livrare
	$smarty->assign("user_adresa_livrare", $user_adresa_livrare);
		
	//@afisare cos cumparaturi
	$smarty->assign("cosul_meu", $cosul_meu);
	
	//@erori cos (nu se poate finaliza comanda daca produsul nu e pe stoc)
	$smarty->assign("erori_cos", $erori_cos);
	
	//@afisare total cos
	$smarty->assign("total_cos", formateazaNr($total_cos));
	$smarty->assign("total_cos_value", $total_cos);
		
	//@afisare total cos + transport
	$smarty->assign("total_cos_cu_transport", formateazaNr($total_cos+(($total_cos>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$transport_cost)));
	
	//@metode plata
	$smarty->assign("metode_plata", $arr_metode_plata);
	
	//@afisare comanda minima
	$smarty->assign("comanda_minima", (COMANDA_MINIMA!=0)?formateazaNr(COMANDA_MINIMA):"");
	$smarty->assign("comanda_minima_value", COMANDA_MINIMA);
	
	//@afisare transport	
	$smarty->assign("transport", $transport_nume);
	$smarty->assign("transport_cost", formateazaNr($transport_cost));
	
	//@comentarii comanda
	$smarty->assign("comentariu_comanda", $_SESSION["comentariu_comanda"]);
	
	//@nu afisez cosul din right (sa nu fie confuzie intre cosul afisat pe centru si cel din right)
	$smarty->assign("afiseaza_cos_right", 0);
		
	//@asignare judete->smarty
	$smarty->assign("judete", $arr_judete);

	//@asignare tip facturare
	$smarty->assign("tip_factura", $_POST["tip_factura"]);
	
	//@asignare daca s-a bifat adresa de livrare
	$smarty->assign("adresa_livrare", $_POST["adresa_livrare"]);
	
	//@erori
	$smarty->assign("adresa_check", $adresa_check);
	$smarty->assign("cod_postal_check", $cod_postal_check);
	$smarty->assign("localitate_check", $localitate_check);
	$smarty->assign("judet_check", $judet_check);
	
	require_once("../bottom.php");
?>