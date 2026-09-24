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
	$arr_comanda=arrayFromDB("*", "t_comenzi AS a LEFT JOIN t_transport AS b ON a.id_transport=b.id_transport", "WHERE id_comanda='".$id_comanda."'");
	$id_user=$arr_comanda[0]["id_user"];
	
	$arr_date_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$id_user."'");
	
	$main_text="Coletul dvs. a fost expediat azi <b>".date("d.m.Y")."</b> si urmeaza sa ajunga la dvs. maine <b>".date("d.m.Y", strtotime("tomorrow"))."</b>.\r\n";		
	$main_text.="Livrarea se face de regula pana dupa-amiaza, daca se intarzie cu livrarea coletului si pentru mai multe informatii legate de momentul livrarii ";
	$main_text.="coletului dvs. (care depinde de agentii Rocourier din orasul dvs.) vizitati  <a href='http://www.rocourier.ro/index_home.php?inc=retea_lista pe harta'>http://www.rocourier.ro/index_home.php?inc=retea_lista pe harta</a> ";
	$main_text.="pe harta aveti numere de telefon pentru fiecare oras  si puteti lua legatura cu unul dintre agentii Rocourier din orasul dvs.";
	
	//@optiuni
	$opt1="Intrucat comanda dvs. este mai mica de ".TRANSPORT_GRATUIT." ".MONEDA.", taxa de transport pe care o achitati (fiind inclusa in ramburs) este <b>".formateazaNr($arr_comanda[0]["cost"])." ".MONEDA."</b>.";
	$opt2="Intrucat comanda dvs. depaseste <b>".TRANSPORT_GRATUIT." ".MONEDA."</b>, beneficiati de transport gratuit.";
		
	$arr_total_comanda=arrayFromDB(array("SUM(pret_produs * cantitate) AS total_comanda"),
								   "t_produse_comenzi",
								   "WHERE id_comanda='".$id_comanda."'");							   
								   	   
	$total_comanda=formateazaNr($arr_total_comanda[0]["total_comanda"]+(($arr_total_comanda[0]["total_comanda"]>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:$arr_comanda[0]["cost"]));	
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//TRIMITE MAIL CONFIRMARE
	if(isset($_POST["trimite"]))
	{
		$text_mail=nl2br(prepareStringFromDB($_POST["main_text"]));
		
		if(is_numeric($_POST["opt"]))
		{
			$text_mail.="<br /><br />";
			switch($_POST["opt"])
			{
				case 1:
					$text_mail.=$opt1;
					break;
				case 2:
					$text_mail.=$opt2;
					break;
			}
		}
		
		$text_mail.="<br /><br />Taxa ramburs(<i>valoare comanda cu TVA + transport</i>) pe care urmeaza sa o achitati la ridicarea coletului este <b>".$_POST["taxa_ramburs"]."</b> ".MONEDA.".";
		
		if(!empty($_POST["retrimite_proforma"]) && $_POST["retrimite_proforma"]==1)
			$text_mail.="<br /><br /><b>Va retrimitem proforma atasata in format pdf, deoarece comanda dvs. a suferit modificari.</b>";
					
		if(!empty($_POST["mentiuni"]))
			$text_mail.="<br /><br /><b>Mentiuni:</b><br />".nl2br(prepareStringFromDB($_POST["mentiuni"]));
		
		//----------------------------------------------------------------------------------------------------------------------------
		//@trimit comanda pe mailul utilizatorului si pe cea a magazinului + proforma pdf atasata in mail
		require_once("../clase/phpmailer.php");
		
		//----------------------------------------------------------------------------------------------------------------------------
		//@subiect mail
		$subiect="Confirmare comanda ID ".$id_comanda." de pe site-ul ".NUME_DOMENIU_SITE;			
	
		//----------------------------------------------------------------------------------------------------------------------------
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
						<tr><td height=\"1\" class=\"bg_spatiu\"></td></tr>
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
		
		//----------------------------------------------------------------------------------------------------------------------------
		//@trimit mailul
		if($mail->Send())
		{
			//@ca sa nu pastrez data cand s-a dat comanda intr-un camp separat o adaug in comentariu comanda (doar pt comenzile onorate)
			$comentariu_comanda="Data trimitere comanda: ".date(DATA_FORMAT." H:i", $arr_comanda[0]["data_comanda"]).
								((!empty($arr_comanda[0]["comentariu_comanda"]))?"<br /><br />".$arr_comanda[0]["comentariu_comanda"]:"");
			
			//@marchez comanda ca fiind onorata
			arrayUpdateToDB("t_comenzi", 
							array("stare", "data_comanda", "comentariu_comanda", "id_admin"), 
							array("2", time(), $comentariu_comanda, $_SESSION["admin_id_user"]),
							array("id"=>"id_comanda", "valoare"=>$id_comanda), false, true);
			
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
	
	$smarty->assign("main_text", $main_text);
	
	$smarty->assign("total_comanda", $total_comanda);
	
	$smarty->assign("opt1", $opt1);
	$smarty->assign("opt2", $opt2);
	
	$smarty->assign("opt_selectata", (($arr_total_comanda[0]["total_comanda"]>=TRANSPORT_GRATUIT && TRANSPORT_GRATUIT!=0)?0:1));
	
	$smarty->assign("total_comanda", $total_comanda);
	
	require_once("right.php");
	require_once("bottom.php");
?>