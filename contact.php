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
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri clase
	require_once("clase/validariGenerale.php");
	require_once("clase/phpmailer.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="contact.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Contact ".NUME_FIRMA;
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@text contact
	$arr_text_contact=arrayFromDB(array("text"), "t_texte_site", "WHERE sectiune='contact'");

	//--------------------------------------------------------------------------------------------------------------------------
	//@departamente contact
	foreach($arr_departamente as $key=>$value)
	{
		$departamente[$key]=$value["nume"];
	}
	
	$form_submit=0;
	$check_gol=array("valid"=>"", "camp"=>"", "eroare"=>"");
	$nume_check=$check_gol;
	$email_check=$check_gol;
	$telefon_check=$check_gol;
	$mesaj_check=$check_gol;
	$cod_validare_check=$check_gol;
	$mesaj="";
	$erori="";
	$continut="";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune formular
	if(isset($_POST["trimite_mesaj"]) || isset($_POST["mesaj"]))
	{
		$validare=new validariGenerale();
		
		$nume_check=$validare->valideazaCamp($_POST["nume"], "nume");
		$email_check=$validare->valideazaEmail($_POST["email"]);
		$telefon_check=$validare->valideazaCamp($_POST["telefon"], "telefon");
		$mesaj_check=$validare->valideazaCamp($_POST["mesaj"], "mesaj");
		$cod_validare_check=$validare->valideazaCodVerificare($_POST["cod_verificare"], $_SESSION["cod_verificare"]);		
		
		//----------------------------------------------------------------------------------------------------------------------
		//@validare finalizata
		if($validare->getErori()==0)
		{
			//@salvare in baza de date optionala
			arrayInsertToDB("t_mesaje_din_site",
				 			array("nume", "telefon", "email", "mesaj", "tip", "data_mesaj", "citit"),
				 			array($_POST["nume"], $_POST["telefon"], $_POST["email"], nl2br($_POST["mesaj"]), 1, time(), 0));
			
			//@vars
			$subiect="Formular contact de pe ".NUME_DOMENIU_SITE;	
					
			$continut.="Nume: <b>".$_POST["nume"]."</b><br /><br />";
			$continut.="Email: <b>".$_POST["email"]."</b><br /><br />";
			$continut.="Telefon: <b>".$_POST["telefon"]."</b><br /><br />";
			$continut.="IP: <b>".$_SERVER["REMOTE_ADDR"]."</b><br /><br />";
			$continut.="Mesajul de contact:<br /><br />";
			$continut.=nl2br($_POST["mesaj"]);
		
			//------------------------------------------------------------------------------------------------------------------
			//@instantiez clasa phpmailer
			$mail=new PHPMailer();
						
			$mail->From="no-reply@".NUME_DOMENIU_SITE;
			$mail->FromName=NUME_DOMENIU_SITE;
			$mail->AddReplyTo($_POST["email"], "Reply to");
			$mail->AddAddress($arr_departamente[0]["email"]);	
			$mail->AddAddress("gencomstar_94@yahoo.com");
			$mail->AddAddress("vali.ciuca@gmail.com");
			
			$mail->Body=$mail_css_style. //$mail_css_style e definita in config
						"<table width=\"400\" class=\"margine\">
							<tr>
								<td align=\"left\">
									<a href=\"".URL_BASE."\"><img src=\"cid:sigla\" alt=\"".NUME_DOMENIU_SITE."\" border=\"0\"></a>																	
								</td>
							</tr>
							<tr><td height=\"1\" class=\"bg_spatiu\"></td></tr>
							<tr><td style=\"padding-top:10px\"><h1>".$subiect."</h1></td></tr>
							<tr>
								<td style=\"padding-top:10px\">
									".$continut."
								</td>
							</tr>
						</table>";
	                     
		    $mail->Subject=$subiect;
		    $mail->IsHTML(true);
		    $mail->CharSet="UTF-8";
		        
			$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");						
			
			if($mail->Send())
			{
				$mesaj="Mesajul de contact a fost trimis cu succes! Va multumim pentru interes.";
				unset($nume_check, $email_check, $telefon_check, $mesaj_check, $cod_validare_check);				
			}
			else 
			{
				$mesaj="Mesajul nu a putut fi trimis! Va rugam sa incercati mai tarziu.";
			}
		}	
		else 
		{
			$mesaj="Au fost gasite urmatoarele erori:";
			$form_submit=1;
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@cod afisat pe poza
	$_SESSION["cod_verificare"]=strRandom(4);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@text contact
	$smarty->assign("contact_text", $arr_text_contact[0]["text"]);
	
	//@departamente (editarea acestora se face din configurare.php
	$smarty->assign("departamente", $departamente);
	
	//@erori form
	$smarty->assign("nume_check", $nume_check);
	$smarty->assign("email_check", $email_check);
	$smarty->assign("telefon_check", $telefon_check);
	$smarty->assign("mesaj_check", $mesaj_check);
	$smarty->assign("cod_validare_check", $cod_validare_check);
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("form_submit", $form_submit);
	
	require_once("right.php");
	require_once("bottom.php");
?>