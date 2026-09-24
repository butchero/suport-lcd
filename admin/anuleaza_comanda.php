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
	session_name("admin");
	session_start();
	
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");	
	require_once("../functii/f_bd.php");
	require_once("../functii/f_admin.php");	
	require_once("../init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@basic check
	if(!is_numeric($_GET["id_comanda"]))
		die("Comanda invalida!");
	
	$id_comanda=$_GET["id_comanda"];	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@construiesc link-ul de redirectare
	$url_redirect=URL_ADMIN."comenzi_noi.php?comanda_anulata=true&id_comanda=".$id_comanda.((!empty($_GET["stare"]))?"&stare=".$_GET["stare"]:"");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ANULEAZA COMANDA
	arrayUpdateToDB("t_comenzi", array("stare", "nota_admin", "id_admin"), array("3", $_POST["nota_admin"], $_SESSION["admin_id_user"]), array("id"=>"id_comanda", "valoare"=>$id_comanda));
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@date cumparator
	$arr_cumparator=arrayFromDB("*",
								"t_comenzi INNER JOIN t_useri ON t_comenzi.id_user=t_useri.id_user",
								"WHERE t_comenzi.id_comanda='".$id_comanda."'");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//MAIL NOTIFICARE UTILIZATOR
	require_once("../clase/phpmailer.php");
	
	$mail=new PHPMailer();
	
	//@setez limba pt erori
	$mail->SetLanguage("ro", URL_BASE_ABS."clase/phpmailer_lang/");
	
	//@subiect mail
	$subiect="Comanda dvs. cu ID-ul ".$id_comanda." a fost anulata";	
	
	$mail->From="no-reply@".NUME_DOMENIU_SITE;
	$mail->FromName=NUME_DOMENIU_SITE;
	
	//@mail catre cumparator
	$mail->AddAddress($arr_cumparator[0]["email"]);
	
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
							<p>Comanda dumeavoastra cu ID-ul <b>".$id_comanda."</b> a fost anulata!</p>
							<p>Motiv anulare: ".((!empty($_POST["nota_admin"]))?nl2br($_POST["nota_admin"]):"-")."</p>
							<p>Va multumim pentru interesul dvs. si va mai asteptam pe site.</p>
						</td>
					</tr>
				</table>";
                 
    $mail->Subject=$subiect;
    $mail->IsHTML(true);
        
	$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");
		
	//------------------------------------------------------------------------------------------------------------------
	//@trimit mailul
	$mail->Send();
	
	header("Location:".$url_redirect);
?>