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
	require_once("../functii/f_catalog.php");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@restrictionare acces pt subadmini
	restrictioneazaAccesSubadmini();
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/newsletter.tpl";
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@limita trimitere newsletter
	$limita_send=100;
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@actiune pentru stergerea unui produs din newsletter
	if(isset($_GET["actiune"]) && $_GET["actiune"]=="sterge" && is_numeric($_GET["id_produs"]) && !empty($_GET["id_produs"]))
	{
		arrayDeleteFromDB("t_newsletter_config", array("id_produs"), array($_GET["id_produs"]));
		$mesaj="Produsul a fost sters din newsletter!";
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@actiune pentru stergerea unui produs din newsletter
	if(isset($_POST["salveaza_newsletter"]))
	{
		$arr_newsletter_header=arrayFromDB("*", "t_newsletter_header");
		
		if(count($arr_newsletter_header)==0)
		{
			arrayInsertToDB("t_newsletter_header", array("titlu_newsletter", "text_newsletter"), array($_POST["titlu_newsletter"], $_POST["newsletter"]));			
		}
		else 
		{
			arrayUpdateToDB("t_newsletter_header",
							 array("titlu_newsletter", "text_newsletter"),
							 array($_POST["titlu_newsletter"], $_POST["newsletter"]),
							 array("id"=>"id", "valoare"=>$arr_newsletter_header[0]["id"]));			
		}
		$mesaj="Newsletterul a fost salvat!";
	}
	
	//
	if(isset($_POST["trimite_newsletter"]))
	{
		preg_match("/.*? ([0-9]+) - ([0-9]+)/", $_POST["trimite_newsletter"], $matches);

		$limita_send_start=$matches[1]-1;
		
		$_SESSION["butoane_dezactivate"][]=$matches[1];
		
		$sql_limit_abonati="LIMIT ".$limita_send_start.", ".$limita_send;
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@nr abonati
	if(!isset($sql_limit_abonati))
		$sql_limit_abonati="";
	$arr_abonati=arrayFromDB("*", "t_newsletter", "ORDER BY id_newsletter ASC ".$sql_limit_abonati);
	$nr_abonati=count(arrayFromDB("*", "t_newsletter"));
	
	$nr_pasi=ceil($nr_abonati/$limita_send);
	
	for($i=0;$i<$nr_pasi;$i++)
	{
		$butoane_send[$i]["nume_buton"]=(($i*$limita_send)+1)." - ".(($i*$limita_send)+$limita_send);		
		
		if(is_array($_SESSION["butoane_dezactivate"]) && in_array(($i*$limita_send)+1, $_SESSION["butoane_dezactivate"]))
			$butoane_send[$i]["status"]="disabled";
		else	
			$butoane_send[$i]["status"]="";
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@titlu & text newsletter
	$arr_newsletter_header=arrayFromDB("*", "t_newsletter_header");
	$titlu_newsletter=isset($arr_newsletter_header[0]["titlu_newsletter"]) ? $arr_newsletter_header[0]["titlu_newsletter"] : "";
	$text_newsletter=isset($arr_newsletter_header[0]["text_newsletter"]) ? $arr_newsletter_header[0]["text_newsletter"] : "";
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@chilipirul zilei
	if(CHILIPIR)
	{
		$arr_chilipir=arrayFromDB(array("b.id_produs", "b.nume_produs",  "b.pret", "a.pret_curent", "a.pret_chilipir", "c.link_cat"),
								  "t_chilipirul_zilei AS a INNER JOIN t_produse AS b ON a.id_produs=b.id_produs 
								  						   LEFT JOIN t_categorii AS c ON b.id_cat=c.id_cat",
								  "WHERE a.data_chilipir='".date("Ymd")."'");

		if(count($arr_chilipir)==1)
		{			
			$adresa_poza_chilipir=getPozaPrincipalaProdus($arr_chilipir[0]["id_produs"]);
			
			$smarty->assign("nume_chilipir", $arr_chilipir[0]["nume_produs"]);
			$smarty->assign("pret_chilipir", formateazaNr($arr_chilipir[0]["pret"]*TVA));
			$smarty->assign("pret_curent", formateazaNr($arr_chilipir[0]["pret_curent"]*TVA));
			$smarty->assign("poza_chilipir", "cid:poza_chilipir.jpg");
			$smarty->assign("poza_chilipir_afisare", $adresa_poza_chilipir);
			$smarty->assign("link_chilipir", getLinkProdus($arr_chilipir[0]["link_cat"], $arr_chilipir[0]["nume_produs"], $arr_chilipir[0]["id_produs"]));
			
			//@am nevoie de adresa absoluta pt a trimite poza atasament
			$poza_chilipir_abs=str_replace(URL_BASE, URL_BASE_ABS, $adresa_poza_chilipir);
			
			//@calcul ore ramase pana expira oferta
			$timestamp1=strtotime(date("Ymd"));
			$timestamp2=time();
			
			$timp_expirare_chilipir=((($timestamp2-$timestamp1)/(60*60))*100)/24;
			
			$smarty->assign("timp_consumat", number_format($timp_expirare_chilipir, 0));
			$smarty->assign("timp_total", 100);
		}
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@produse newsletter
	$arr_produse_newsletter=array();
	$arr_produse_newsletter_detalii=array();
	$arr_newsletter=arrayFromDB(array("id_produs"), "t_newsletter_config", "ORDER BY id ASC");
	
	foreach($arr_newsletter as $key=>$value)
		$arr_id_produse_newsletter[]=$value["id_produs"];
	
	if(count($arr_newsletter)>0)
	{
		$sql_where="AND t_produse.id_produs IN (".implode(",", $arr_id_produse_newsletter).")";
		
		//---------------------------------------------------------------------------------------------------------------------------------
		//@select produse adaugate in newsletter
		$arr_produse_newsletter=arrayFromDB(array("id_produs",
												  "t_produse.id_cat",
												  "id_prod",
												  "nume_produs",
												  "pret",
												  "pret_vechi",
												  "stoc",
												  "t_categorii.link_cat",
												  "t_producatori.nume_cat",
												  "t_producatori.id_cat"),
											 "t_produse LEFT JOIN t_categorii ON t_produse.id_cat=t_categorii.id_cat 
											   		    LEFT JOIN t_categorii AS t_producatori ON t_produse.id_prod=t_producatori.id_cat",
									 		 "WHERE 1 ".(isset($sql_where) ? $sql_where : "")." ORDER BY t_produse.id_produs ASC");		
	}
	
	$nr_produse=count($arr_produse_newsletter);
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//LOOP PRODUSE AFLATE LA OFERTA SPECIALA
	for($i=0;$i<$nr_produse;$i++)
	{
		//---------------------------------------------------------------------------------------------------------------------------------
		//DETALII PRODUS
		
		//---------------------------------------------------------------------------------------------------------------------------------
		//@poza principala
		$adresa_poza=getPozaPrincipalaProdus($arr_produse_newsletter[$i]["id_produs"]);	
										
		//---------------------------------------------------------------------------------------------------------------------------------
		//@array asociativ cu toate detaliile produsului
		$arr_produse_newsletter_detalii[$i]=array("id_produs"=>$arr_produse_newsletter[$i]["id_produs"],										   
									   			  "nume_produs"=>stringLimit($arr_produse_newsletter[$i]["nume_produs"], 40),
									   			  "nume_producator"=>$arr_produse_newsletter[$i]["nume_cat"],
											      "adresa_poza_produs_afisare"=>$adresa_poza,											      
											      "adresa_poza_produs"=>(strpos($adresa_poza, "fara_imagine")===false)?str_replace(URL_BASE."poze_produse/".$arr_produse_newsletter[$i]["id_produs"]."/medii/", "cid:".$i."_", $adresa_poza):"cid:".$i."_fara_imagine.jpg",
											      "adresa_poza_produs_abs"=>str_replace(URL_BASE, URL_BASE_ABS, $adresa_poza),
											      "stoc"=>ucfirst($arr_stoc[$arr_produse_newsletter[$i]["stoc"]-1]["stoc"]),
										  	      "stoc_poza"=>$arr_stoc[$arr_produse_newsletter[$i]["stoc"]-1]["poza"],
											      "pret_produs"=>formateazaNr($arr_produse_newsletter[$i]["pret"]*TVA),
											      "pret_vechi"=>(!empty($arr_produse_newsletter[$i]["pret_vechi"]) && $arr_produse_newsletter[$i]["pret_vechi"]!=0)?formateazaNr($arr_produse_newsletter[$i]["pret_vechi"]*TVA):"",
											      "popup_js"=>$popup_js,
											      "link_produs"=>getLinkProdus($arr_produse_newsletter[$i]["link_cat"], $arr_produse_newsletter[$i]["nume_produs"], $arr_produse_newsletter[$i]["id_produs"]),
											      "link_cat"=>URL_BASE.$arr_produse_newsletter[$i]["link_cat"]);
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("nr_abonati", $nr_abonati);
	$smarty->assign("titlu_newsletter", $titlu_newsletter);
	$smarty->assign("text_newsletter", $text_newsletter);
	$smarty->assign("produse_newsletter", $arr_produse_newsletter_detalii);
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@actiune trimitere newsletter
	if(isset($_POST["trimite_newsletter"]))
	{
		require_once("../clase/phpmailer.php");
		
		//@vars
		$subiect=$titlu_newsletter;			
	
		//---------------------------------------------------------------------------------------------------------------------------------
		//@instantiez clasa phpmailer
		$mail=new PHPMailer();
		
		$mail->From="no-reply@".NUME_DOMENIU_SITE;
		$mail->FromName=NUME_DOMENIU_SITE;		
		
		//@url intern pt poze
		$smarty->assign("URL_POZA", "cid:");
		$smarty->assign("URL_POZA_ADMIN", "cid:");
		
		//@corpul emailului luat din tpl dupa assignuri
		$email_body=$smarty->fetch("admin/preview_newsletter.tpl");
                     
	    $mail->Subject=$subiect;
	    $mail->IsHTML(true);
	     
	    //@sigla  
		$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img/sigla.jpg", "sigla", "sigla.jpg", "base64", "image/jpeg");
		
		//@alte elemente de grafica
		$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img_admin/colt_up_newsletter.gif", "colt_up_newsletter.gif", "colt_up_newsletter.gif", "base64", "image/gif");
		$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img_admin/margine_newsletter.gif", "margine_newsletter.gif", "margine_newsletter.gif", "base64", "image/gif");
		$mail->AddEmbeddedImage(DIR_TEMPLATE_ABS."img_admin/colt_down_newsletter.gif", "colt_down_newsletter.gif", "colt_down_newsletter.gif", "base64", "image/gif");
		
		//@poza chilipir
		$mail->AddEmbeddedImage($poza_chilipir_abs ,"poza_chilipir.jpg", "poza_chilipir.jpg", "base64", "image/jpeg");
		
		//@pozele produselor din newsletter
		for($i=0;$i<$nr_produse;$i++)
		{
			//@extrag numele pozei
			preg_match("/\/([^\/]+).jpg/", $arr_produse_newsletter_detalii[$i]["adresa_poza_produs_abs"], $matches);
			$mail->AddEmbeddedImage($arr_produse_newsletter_detalii[$i]["adresa_poza_produs_abs"], $i."_".$matches[1].".jpg", $i."_".$matches[1].".jpg", "base64", "image/jpeg");
		}
		
		//---------------------------------------------------------------------------------------------------------------------------------
		//@loop prin abonatii la newsletter si trimit newsletter-ul, nu trimit cu bcc pt ca tb sa trimit link-ul criptat de dezabonare
		foreach($arr_abonati as $key=>$value)
		{
			$mail->AddAddress($value["email"]);
			$mail->Body=$email_body.'<div style="width:600px">
										<p align="right"><a href="'.URL_BASE.'no-newsletter.php?hash='.md5($value["email"].$value["id_newsletter"].$value["data_inregistrarii"]).'" class="link_dezabonare">
											Daca nu mai doriti sa primiti acest newsletter click pe acest link.</a> &nbsp; 
										</p>
									 </div>';
			//@trimite mail
			$mail->Send();
		    $mail->ClearAddresses();
		    
		    //@incrementez contor la abonat
		   	arrayUpdateToDB("t_newsletter", array("contor"), array("contor+1"), array("id"=>"id_newsletter", "valoare"=>$value["id_newsletter"]), true);
		}
	    
	    $mesaj="Newsletterul fost trimis cu succes!";
	    $mail->ClearAttachments();
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	if(!isset($mesaj)) $mesaj="";
	if(!isset($butoane_send) || !is_array($butoane_send)) $butoane_send=array();
	if(!isset($arr_produse_newsletter) || !is_array($arr_produse_newsletter)) $arr_produse_newsletter=array();
	if(!isset($arr_produse_newsletter_detalii) || !is_array($arr_produse_newsletter_detalii)) $arr_produse_newsletter_detalii=array();
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("butoane_send", $butoane_send);
	
	require_once("right.php");
	require_once("bottom.php");
?>