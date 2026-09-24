<?
	/*
	 *****************************************************************************
	 *****************************************************************************
	 **                                                                         **
	 **          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2007       		**
	 **                                                                         **
	 *****************************************************************************
	 *****************************************************************************
	*/
	session_name("shop");
	session_start();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("conectare.php");
	require_once("configurare.php");	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("functii/f_securitate.php");
	require_once("functii/f_bd.php");
	require_once("functii/f_catalog.php");
	require_once("functii/f_generale.php");
	require_once("functii/f_links.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri clase
	require_once("clase/validariGenerale.php");
	require_once("clase/phpmailer.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	require_once("smarty_connect.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@security check
	(!is_numeric($_REQUEST["id_produs"]))?die("Produsul nu exista!"):$id_produs=$_REQUEST["id_produs"];
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@select detalii produs
	$arr_produs=arrayFromDB("*", "t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat", "WHERE t_produse.id_produs='".$id_produs."'");
	
	//--------------------------------------------------------------------------------------------------------------------------						  
	//@security check
	(count($arr_produs)!=1)?die("Produsul nu exista!"):"";	
	
	$arr_produs_detalii=array("id_produs"=>$arr_produs[0]["id_produs"],
							  "nume_produs"=>$arr_produs[0]["nume_produs"],
							  "adresa_poza_produs"=>getPozaPrincipalaMicaProdus($id_produs),
							  "link_produs"=>getLinkProdus($arr_produs[0]["link_cat"], $arr_produs[0]["nume_produs"], $arr_produs[0]["id_produs"]));
	 
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune recomanda produs
	if(isset($_POST["trimite"]) || isset($_POST["adresa_email"]))
	{
		//@instantiez clasa validariGenerale
		$validare=new validariGenerale();
				
		$nume_check=$validare->valideazaCamp($_POST["nume"], "nume");		
		$email_check=$validare->valideazaEmail($_POST["adresa_email"]);
		$email_destinatar_check=$validare->valideazaEmail($_POST["adresa_email_destinatar"]);		
		$cod_verificare_check=$validare->valideazaCodVerificare($_POST["cod_verificare"], $_SESSION["cod_verificare"]);
			
		//@validare finalizata
		if($validare->getErori()==0)
		{
			//@vars
			$subiect="Recomandare de la ".$_POST["nume"];			
		
			//------------------------------------------------------------------------------------------------------------------
			//@instantiez clasa phpmailer
			$mail=new PHPMailer();
			
			$mail->From="no-reply@".NUME_DOMENIU_SITE;
			$mail->FromName=NUME_DOMENIU_SITE;
			$mail->AddAddress($_POST["adresa_email_destinatar"]);
			
			$mail->Body=$mail_css_style. //$mail_css_style e definita in config
						"<table width=\"400\" class=\"margine\">
							<tr>
								<td align=\"left\">
									<a href=\"".URL_BASE."\"><img src=\"cid:sigla\" alt=\"".NUME_MAGAZIN."\" border=\"0\"></a>																	
								</td>
							</tr>
							<tr><td height=\"1\" class=\"bg_spatiu\"></td></tr>
							<tr><td style=\"padding-top:10px\"><h1>".$subiect."</h1></td></tr>
							<tr>
								<td style=\"padding-top:10px\">
									<p>Buna ziua,</p>
									<p>
										Ati primit acest mail deoarece <b>".$_POST["nume"]."</b> v-a recomandat produsul:
										<table style=\"margin-top:10px\" class=\"margine\">
											<tr>
												<td width=\"2\" bgcolor=\"FFCC01\"></td>
												<td>
													<a href=\"".$arr_produs_detalii["link_produs"]."\">
														<img src=\"cid:poza_produs\" alt=\"Click pentru a vizualiza produsul\" border=\"0\">
													</a>	
												</td>
												<td>
													<a href=\"".$arr_produs_detalii["link_produs"]."\">
														".$arr_produs_detalii["nume_produs"]."
													</a>	
												</td>
											</tr>
										</table>
										<table style=\"margin-top:10px\" class=\"margine\">
											<tr><td>Email-ul lui <b>".$_POST["nume"]."</b>: ".$_POST["adresa_email"]."</td></tr>
											<tr><td><i>".prepareStringFromDB($_POST["mesaj_suplimentar"])."</i></td></tr>
										</table>									
									</p>
								</td>
							</tr>
						</table>";
	                     
		    $mail->Subject=$subiect;
		    $mail->IsHTML(true);
		        
			$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");
			
			//@poza principala (adresa absoluta)
			if(file_exists(URL_BASE_ABS."poze_produse/".$id_produs."/mici/0.jpg"))
				$adresa_poza=URL_BASE_ABS."poze_produse/".$id_produs."/mici/0.jpg";
			else $adresa_poza=DIR_TEMPLATE_ABS."img/fara_imagine_mica.jpg";	
			
			$mail->AddEmbeddedImage($adresa_poza, "poza_produs", "poza_produs.jpg", "base64", "image/jpeg");
			
			if($mail->Send())
			{
				$mesaj="Recomandarea fost trimisa cu succes !";
			}
			else 
			{
				$mesaj="Recomandare nu a fost trimisa ! Va rugam sa incercati mai tarziu.";
			}
			
			//------------------------------------------------------------------------------------------------------------------
			//@sterg adresele si atasamentele
			unset($nume_check, $email_check, $email_destinatar_check, $cod_verificare_check, $_POST["mesaj_suplimentar"]);
		    $mail->ClearAddresses();
		    $mail->ClearAttachments();
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@cod afisat pe poza
	$_SESSION["cod_verificare"]=strRandom(4);					  
   
    //--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("mesaj", $mesaj);
	
	//@erori formular de trimitere recomandare
	$smarty->assign("nume_check", $nume_check);
	$smarty->assign("email_check", $email_check);
	$smarty->assign("email_destinatar_check", $email_destinatar_check);
	$smarty->assign("mesaj_suplimentar", prepareStringFromDB($_POST["mesaj_suplimentar"]));
	$smarty->assign("cod_verificare_check", $cod_verificare_check);
	$smarty->assign("mesaj", $mesaj);
	
	//@produs detalii
	$smarty->assign("produs", $arr_produs_detalii);

	$smarty->assign("NUME_FIRMA", NUME_FIRMA);
	
	$smarty->display("recomanda_produs.tpl");
?>