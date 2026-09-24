<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2008       		   **
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
	require_once("../functii/f_catalog.php");
	require_once("../functii/f_generale.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@proceseaza requestul
	if(is_numeric($_GET["id_comanda"]) && !empty($_GET["id_comanda"]))
	{
		require_once("date_posta_romana.php");
		 
		$output.='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
		$output.="<html>
				  	<head>
						<title>Buletin de expeditie</title>
						<style type='text/css'>
							@media print {
							   .no_print { display: none; }
							}
							body {
								margin-left:5px;
								margin-top:5px;
								margin-right:0px;
								margin-bottom:0px;
							}
							table, td, p, span, input, div {
								font-size:11px;
								font-family:verdana;
								font-weight:bold;
							}
							input {
								border:0px;
								padding:0px;
								margin:0px;
								height:13px;
								color:#000000;
							}
						</style>
					 </head>
				  <body>
				  <div class='no_print' style='padding-bottom:15px'>
						<input type='button' value='PRINT' onClick='window.print()' style='background-color:#000000;color:#FFFFFF;border:1px solid #F2F2F2;height:18px'>
						".$mesaj."
				  </div>";	
		
		//@output buletin
		$output.="<div style='background-image:url(".DIR_TEMPLATE."img/buletin_de_expeditie.gif);width:602px;height:856px;display:block;position:absolute'>
					 <div style='position:absolute;top:80px;left:171px'><input type='text' value='RAMBURS' size='10'></div>
					 <div style='position:absolute;top:110px;left:132px'><input type='text' value='RAMBURS' size='10'></div>
					 <div style='position:absolute;top:110px;left:390px'><input type='text' value='CARTE' size='10'></div>
					 <div style='position:absolute;top:148px;left:130px'><input type='text' value='".formateazaNr($valoare_lei)."' size='10'></div>
					 <div style='position:absolute;top:174px;left:137px'><input type='text' value='".formateazaNr($ramburs_lei)."' size='10'></div>
					 <div style='position:absolute;top:215px;left:115px'><input type='text' value='".$destinatar."' size='30'></div>
					 <div style='position:absolute;top:215px;left:462px'><input type='text' value='".$telefon."' size='15'></div>
					 <div style='position:absolute;top:238px;left:75px'><input type='text' value='".$strada."' size='25'></div>
					 <div style='position:absolute;top:238px;left:300px'><input type='text' value='".$nr."' size='3'></div>
					 <div style='position:absolute;top:238px;left:380px'><input type='text' value='".$bloc."' size='1'></div>
					 <div style='position:absolute;top:238px;left:445px'><input type='text' value='".$scara."' size='1'></div>
					 <div style='position:absolute;top:238px;left:498px'><input type='text' value='".$etaj."' size='1'></div>
					 <div style='position:absolute;top:238px;left:560px'><input type='text' value='".$apartament."' size='1'></div>
					 <div style='position:absolute;top:263px;left:120px'><input type='text' value='".$cod_postal."' size='10'></div>
					 <div style='position:absolute;top:263px;left:340px'><input type='text' value='".$localitate."' size='20'></div>
					 <div style='position:absolute;top:305px;left:100px'><input type='text' value='".$localitate."' size='15'></div>
					 <div style='position:absolute;top:338px;left:115px'><input type='text' value='".$expeditor."' size='15'></div>
					 <div style='position:absolute;top:338px;left:396px'><input type='text' value='".$telefon_exp."' size='12'></div>
					 <div style='position:absolute;top:361px;left:72px'><input type='text' value='".$strada_exp."' size='13'></div>
					 <div style='position:absolute;top:361px;left:192px'><input type='text' value='".$nr_strada_exp."' size='1'></div>
					 <div style='position:absolute;top:361px;left:238px'><input type='text' value='".$bloc_exp."' size='1'></div>
					 <div style='position:absolute;top:361px;left:285px'><input type='text' value='".$scara_exp."' size='1'></div>
					 <div style='position:absolute;top:361px;left:330px'><input type='text' value='".$et_exp."' size='1'></div>
					 <div style='position:absolute;top:361px;left:384px'><input type='text' value='".$ap_exp."' size='1'></div>
					 <div style='position:absolute;top:361px;left:449px'><input type='text' value='".$sector_exp."' size='1'></div>
					 <div style='position:absolute;top:383px;left:113px'><input type='text' value='".$cod_postal_exp."' size='5'></div>
					 <div style='position:absolute;top:383px;left:237px'><input type='text' value='".$localitate_exp."' size='15'></div>
					 <div style='position:absolute;top:383px;left:400px'><input type='text' value='".$judet_exp."' size='9'></div>
					 <div style='position:absolute;top:405px;left:90px'><input type='text' value='".$mail_exp."' size='50'></div>
					 <div style='position:absolute;top:492px;left:120px'><input type='text' value='".$destinatar."' size='45'></div>
					 <div style='position:absolute;top:492px;left:482px'><input type='text' value='".$telefon."' size='12'></div>
					 <div style='position:absolute;top:526px;left:72px'><input type='text' value='".$strada."' size='45'></div>
					 <div style='position:absolute;top:526px;left:408px'><input type='text' value='".$bloc."' size='2'></div>
					 <div style='position:absolute;top:526px;left:456px'><input type='text' value='".$scara."' size='1'></div>
					 <div style='position:absolute;top:526px;left:501px'><input type='text' value='".$etaj."' size='2'></div>
					 <div style='position:absolute;top:526px;left:558px'><input type='text' value='".$apartament."' size='2'></div>
					 <div style='position:absolute;top:550px;left:290px'><input type='text' value='COLET CARTE' size='45'></div>
					 <div style='position:absolute;top:585px;left:140px'><input type='text' value='' size='12'></div>
					 <div style='position:absolute;top:585px;left:270px'><input type='text' value='".formateazaNr($valoare_lei)."' size='10'></div>
					 <div style='position:absolute;top:585px;left:478px'><input type='text' value='".formateazaNr($ramburs_lei)."' size='6'></div>
					 <div style='position:absolute;top:610px;left:118px'><input type='text' value='".$expeditor."' size='25'></div>
					 <div style='position:absolute;top:636px;left:70px'><input type='text' value='".$strada_exp."' size='25'></div>
					 <div style='position:absolute;top:636px;left:282px'><input type='text' value='".$nr_strada_exp."' size='2'></div>
					 <div style='position:absolute;top:636px;left:342px'><input type='text' value='".$cod_postal_exp."' size='5'></div>
					 <div style='position:absolute;top:636px;left:470px'><input type='text' value='".$localitate_exp."' size='15'></div>
				  </div>";	
			
				  
		$output.="</body></html>";		

		//@afiseaza ouput 
		print $output;
	}
?>
