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
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");
	require_once("../init.php");	
	require_once("../clase/phpmailer.php");
	require_once("../functii/f_bd.php");
	require_once("../functii/f_securitate.php");
	require_once("../functii/f_links.php");
	require_once("../functii/f_generale.php");
	
	//@vars
	$subiect="Alerta stoc";

	//--------------------------------------------------------------------------------------------------------------------------
	//@instantiez clasa phpmailer
	$mail=new PHPMailer();
	
	//@setez limba pt erori
	$mail->SetLanguage("ro", URL_BASE_ABS."clase/phpmailer_lang/");
	
	$mail->From="no-reply@".NUME_DOMENIU_SITE;
	$mail->FromName=NUME_DOMENIU_SITE;
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@selectez alertele care indeplinesc criteriul
	$arr_alerte=arrayFromDB(array("id_alerta",
								  "b.id_produs",
								  "adresa_email",
								  "b.pret",
								  "b.nume_produs",
								  "c.link_cat"),
						    "t_alerte_stoc AS a LEFT JOIN t_produse AS b ON a.id_produs=b.id_produs 
						    		  	   		LEFT JOIN t_categorii AS c ON b.id_cat=c.id_cat",
						    "WHERE b.stoc='2'");
	
	$nr_alerte=count($arr_alerte);

	//--------------------------------------------------------------------------------------------------------------------------
	//@contor alerte trimise pe mail cu succes
	$j=0;
	
	//--------------------------------------------------------------------------------------------------------------------------    
	//@loop prin alerte si send
	for($i=0;$i<$nr_alerte;$i++)
	{					 
		$mail->AddAddress($arr_alerte[$i]["adresa_email"], "");
			
		$mail->Body=$mail_css_style. //$mail_css_style e definita in config
					"<table width=\"400\" class=\"margine\">
						<tr>
							<td align=\"left\">
								<a href=\"".URL_BASE."\"><img src=\"cid:sigla\" alt=\"".NUME_FIRMA."\" border=\"0\"></a>																	
							</td>
						</tr>
						<tr><td height=\"1\" class=\"bg_spatiu\" style=\"padding:0px\"></td></tr>
						<tr><td style=\"padding-top:10px\"><h1>".$subiect."</h1></td></tr>
						<tr>
							<td style=\"padding-top:10px\">
								<p>Buna ziua,</p>
								<p>
									Ati primit acest mail deoarece produsul: 
									<br />
									<br />
									<table>	
										<tr>												
											<td valign=\"middle\">
												<table class=\"margine\">
													<tr>
														<td width=\"2\" bgcolor=\"FFCC01\"></td>
														<td>
															<a href=\"".getLinkProdus($arr_alerte[$i]["link_cat"], $arr_alerte[$i]["nume_produs"], $arr_alerte[$i]["id_produs"])."\">
																<img src=\"cid:poza_produs\" alt=\"Click pentru a vizualiza produsul\" border=\"0\">
															</a>
														</td>
													</tr>		
												</table>
											</td>
											<td width=\"5\"></td>
											<td>									
												<a href=\"".getLinkProdus($arr_alerte[$i]["link_cat"], $arr_alerte[$i]["nume_produs"], $arr_alerte[$i]["id_produs"])."\">
													<b>".$arr_alerte[$i]["nume_produs"]."</b>
												</a> 
											</td>
										</tr>	
									</table>
									<br />
									<br />
									este acum pe <font color=\"#489CE3\"><b>stoc</b></font>.									
								</p>
							</td>
						</tr>
					</table>";
	                     
	    $mail->Subject=$subiect;
	    $mail->IsHTML(true);
	        
		$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");
		
		//@poza principala (adresa absoluta)
		if(file_exists(URL_BASE_ABS."poze_produse/".$arr_alerte[$i]["id_produs"]."/mici/0.jpg"))
			$adresa_poza=URL_BASE_ABS."poze_produse/".$arr_alerte[$i]["id_produs"]."/mici/0.jpg";
		else $adresa_poza=DIR_TEMPLATE_ABS."img/fara_imagine_mica.jpg";	
		
		$mail->AddEmbeddedImage($adresa_poza, "poza_produs", "poza_produs.jpg", "base64", "image/jpeg");
		
		if($mail->Send())
		{	
			$j++; //contorizez mailurile trimise
			arrayDeleteFromDB("t_alerte_stoc", array("id_alerta"), array($arr_alerte[$i]["id_alerta"]));	//sterg alerta setata
		}
		else 
		{
			print "Eroare trimitere e-mail..".$mail->ErrorInfo;
		}
		
		//----------------------------------------------------------------------------------------------------------------------
		//@sterg adresele si atasamentele pt urmatorul loop
	    $mail->ClearAddresses();
	    $mail->ClearAttachments();
	    
	}//end loop		
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@log alerte trimise pe mail cu succes
	arrayInsertToDB("t_alerte_trimise", array("numar", "data_cronjob"), array($j, time()));
?>