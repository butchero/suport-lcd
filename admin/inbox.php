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
	require_once("../functii/f_admin.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/inbox.tpl";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@stergere mesaj
	if(isset($_REQUEST["sterge"]) && isset($_GET["id_msg"]) && is_numeric($_GET["id_msg"]) && !empty($_GET["id_msg"]))
	{
		arrayDeleteFromDB("t_mesaje_din_site", array("id_mesaj"), array($_GET["id_msg"]));
		$mesaj="Mesajul a fost sters!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@trimitere mesaj
	if(isset($_POST["raspunde"]) && isset($_GET["id_msg"]) && is_numeric($_GET["id_msg"]) && !empty($_GET["id_msg"]))
	{
		$arr_detalii_mesaj=arrayFromDB("*", "t_mesaje_din_site", "WHERE id_mesaj='".$_GET["id_msg"]."'");
		
		require_once("../clase/phpmailer.php");
		
		//-----------------------------------------------------------------------------------------------------------------------------
		//@subiect mail
		$subiect="Raspuns din partea ".NUME_DOMENIU_SITE;			
	
		//-----------------------------------------------------------------------------------------------------------------------------
		//@instantiez clasa phpmailer
		$mail=new PHPMailer();
		
		//@setez limba pt erori
		$mail->SetLanguage("ro", URL_BASE_ABS."clase/phpmailer_lang/");
		
		$mail->From=$_POST["din_partea"];
		$mail->FromName=NUME_DOMENIU_SITE;
		
		//@mail catre contactant
		$mail->AddAddress($arr_detalii_mesaj[0]["email"]);
		
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
							<td style=\"padding:10px\">
								<p>".prepareStringFromDB($_POST["raspuns"])."</p>	
							</td>
						</tr>						
						<tr><td height=\"1\" class=\"bg_spatiu\" style=\"padding:0px\"></td></tr>	
						<tr>
							<td style=\"padding:10px\">
								<b>Mesajul original trimis de dvs:</b> 
								<br /><br />
								\"".$arr_detalii_mesaj[0]["mesaj"]."\"
							</td>
						</tr>
					</table>";
	                 
	    $mail->Subject=$subiect;
	    $mail->IsHTML(true);
	        
		$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");
					
		//-----------------------------------------------------------------------------------------------------------------------------
		//@trimit mailul
		if($mail->Send())
			$mesaj="Raspunsul a fost trimis! Este recomandat sa stergeti mesajul pentru a evita un alt raspuns din greseala pe viitor.";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@afisare mesaj
	if(isset($_GET["id_mesaj"]) && is_numeric($_GET["id_mesaj"]) && !empty($_GET["id_mesaj"]) && !isset($_REQUEST["sterge"]))
	{
		$arr_detalii_mesaj=arrayFromDB("*", "t_mesaje_din_site", "WHERE id_mesaj='".$_GET["id_mesaj"]."'");
		
		if(count($arr_detalii_mesaj)==1)
		{
			$arr_detalii_mesaj[0]["data_mesaj"]=date(DATA_FORMAT, $arr_detalii_mesaj[0]["data_mesaj"]);
			$detalii_mesaj=$arr_detalii_mesaj[0];
		
			arrayUpdateToDB("t_mesaje_din_site", array("citit"), array("1"), array("id"=>"id_mesaj", "valoare"=>$_GET["id_mesaj"]));
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//@filtrare inbox
	if(isset($_REQUEST["tip_contact"]) && is_numeric($_REQUEST["tip_contact"]))
	{
		$tip_contact=$_REQUEST["tip_contact"];
		$sql_where="AND tip='".$tip_contact."'";
	}
	
	if(isset($_REQUEST["ordonare"]) && ($_REQUEST["ordonare"]=="asc" || $_REQUEST["ordonare"]=="desc"))
	{
		$ordonare=$_REQUEST["ordonare"];
		$sql_order="ORDER BY id_mesaj ".$ordonare;
	}
	else 
		$sql_order="ORDER BY id_mesaj DESC";
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("../clase/paginare.php");

	$paginare=new paginare("pag", 
						   "SELECT COUNT(id_mesaj) AS nr FROM t_mesaje_din_site", 
						    URL_ADMIN."inbox.php?pag=".PATTERN."&ordonare=".$ordonare."&tip_contact=".$tip_contact); 
	$paginare_string=$paginare->doPaginare();
	$nr_rezultate=$paginare->getNrRezultate();
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@selectez toate mesajele primite
	$arr_temp_mesaje=arrayFromDB("*", "t_mesaje_din_site", "WHERE 1 ".$sql_where." ".$sql_order." LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	
	foreach($arr_temp_mesaje as $key=>$value)
	{
		$arr_mesaje[$key]["id_mesaj"]=$value["id_mesaj"];
		$arr_mesaje[$key]["nume"]=$value["nume"];
		$arr_mesaje[$key]["nume"]=$value["nume"];	
		$arr_mesaje[$key]["telefon"]=$value["telefon"];
		$arr_mesaje[$key]["email"]=$value["email"];
		$arr_mesaje[$key]["tip"]=$arr_tip_mesaje_din_site[$value["tip"]];
		$arr_mesaje[$key]["data"]=date(DATA_FORMAT, $value["data_mesaj"]);
		$arr_mesaje[$key]["citit"]=$value["citit"];
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("detalii_mesaj", $detalii_mesaj);
	$smarty->assign("din_partea", $arr_departamente[0]["email"]);
	$smarty->assign("mesaje", $arr_mesaje);
	$smarty->assign("paginare", $paginare_string);
	$smarty->assign("tip_contact", $tip_contact);
	$smarty->assign("ordonare", $ordonare);

	require_once("right.php");
	require_once("bottom.php");
?>