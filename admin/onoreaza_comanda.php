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
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/onoreaza_comanda.tpl";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@basic check
	if(!is_numeric($_GET["id_comanda"]))
		die("Comanda invalida!");
		
	$id_comanda=$_GET["id_comanda"];	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@date user
	$arr_user=arrayFromDB(array("id_user"), "t_comenzi", "WHERE id_comanda='".$id_comanda."'");
	$id_user=$arr_user[0]["id_user"];
	
	$arr_date_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$id_user."'");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//TRIMITE MAIL CONFIRMARE
	if(isset($_POST["trimite"]))
	{
		$text_mail=nl2br(prepareStringFromDB($_POST["main_text"]));
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@trimit comanda pe mailul utilizatorului si pe cea a magazinului + proforma pdf atasata in mail
		require_once("../clase/phpmailer.php");
		
		//@subiect mail
		$subiect="Confirmare comanda ID ".$id_comanda." de pe site-ul ".NUME_DOMENIU_SITE;			
	
		//-----------------------------------------------------------------------------------------------------------------------------
		//@instantiez clasa phpmailer
		$mail=new PHPMailer();
		
		//@setez limba pt erori
		$mail->SetLanguage("ro", URL_BASE_ABS."clase/phpmailer_lang/");
		
		$mail->From="no-reply@".NUME_DOMENIU_SITE;
		$mail->FromName=NUME_DOMENIU_SITE;
		
		//@mail catre cumparator
		$mail->AddAddress($arr_date_user[0]["email"]);
		
		$mail->Body=$mail_css_style. //$mail_css_style e definita in config
					"<table width=\"600\" class=\"margine\">
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
								<p>".$text_mail."</p>								
							</td>
						</tr>
					</table>";
	                 
	    $mail->Subject=$subiect;
	    $mail->IsHTML(true);
	        
		$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");
		
		//----------------------------------------------------------------------------------------------------------------------------
		//@atasez proforma pdf daca adminul a bifat retrimitereea acesteia
		if(!empty($_POST["retrimite_proforma"]) && $_POST["retrimite_proforma"]==1)
		{
			$proforma_pdf=URL_BASE_ABS."proforme/".md5($arr_date_user[0]["data_inregistrarii"].$arr_date_user[0]["id_user"])."/proforma_".$id_comanda.".pdf";
			$mail->AddAttachment($proforma_pdf, "proforma_".$id_comanda.".pdf");
		}
			
		//-----------------------------------------------------------------------------------------------------------------------------
		//@trimit mailul
		if($mail->Send())
		{
			//@marchez comanda ca fiind onorata
			arrayUpdateToDB("t_comenzi", array("stare", "id_admin"), array("2", $_SESSION["admin_id_user"]), array("id"=>"id_comanda", "valoare"=>$id_comanda));
			
			$_SESSION["mesaj"]="Comanda cu ID-ul ".$id_comanda." a fost marcata ca onorata!";
			
			print "<script type='text/javascript'>
						window.opener.location.href = window.opener.location.href;
						window.close();
				   </script>";
		}	
		else print "Eroare trimitere e-mail..".$mail->ErrorInfo;	
	}		
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("id_comanda", $id_comanda);
	
	require_once("right.php");
	require_once("bottom.php");
?>
