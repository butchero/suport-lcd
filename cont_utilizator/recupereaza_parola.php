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
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri clase
	require_once("../clase/valideazaRecParola.php");
	require_once("../clase/phpmailer.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("../init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/recupereaza_parola.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Recupereaza parola cont";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune recuperare parola
	if(isset($_POST["adresa_email"]))
	{
		//----------------------------------------------------------------------------------------------------------------------
		//@instantiez clasa validariGenerale
		$validare=new valideazaRecParola();
			
		$email_check=$validare->valideazaEmailUser($_POST["adresa_email"]);
		
		//@validare finalizata
		if($validare->getErori()==0)
		{
			//@vars
			$subiect="Recuperare parola pentru contul ".NUME_DOMENIU_SITE;		
			$parola=strRandom(8);	//parola noua
		
			//------------------------------------------------------------------------------------------------------------------
			//@instantiez clasa phpmailer
			$mail=new PHPMailer();
			
			$mail->From="no-reply@".NUME_DOMENIU_SITE;
			$mail->FromName=NUME_DOMENIU_SITE;
			$mail->AddAddress($_POST["adresa_email"]);
			
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
										In urma cererii dvs. parola pentru ".NUME_DOMENIU_SITE." a fost resetata si este urmatoarea:
										<br /><br />
										Username: ".$email_check["username"]." <br />
										Parola: <b>".$parola."</b>
									</p>
									<p align=\"center\"><a href=\"".URL_BASE."cont\">Click aici pentru a va loga.</a></p>
									<p>Va recomandam sa va schimbati aceasta parola temporara cu prima ocazie!</p>
								</td>
							</tr>
						</table>";
	                     
		    $mail->Subject=$subiect;
		    $mail->IsHTML(true);
		        
			$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");						
			
			if($mail->Send())
			{
				$mesaj="Parola a fost trimisa pe e-mail cu succes !";
				arrayUpdateToDB("t_useri", array("parola"), array(md5($parola)), array("id"=>"email", "valoare"=>$_POST["adresa_email"]));
			}
			else 
			{
				$mesaj="Parola nu putut fi trimisa ! Va rugam sa incercati mai tarziu.";
			}
		}
	}
	
	//-----------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("mesaj", $mesaj);

	//@erori formular recuperare parola
	$smarty->assign("email_check", $email_check);
	
	require_once("../right.php");
	require_once("../bottom.php");
?>