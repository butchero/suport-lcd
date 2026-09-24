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
		$output.="<div style='background-image:url(".DIR_TEMPLATE."img/cupon_mandat_postal_verso.gif);width:900px;height:401px;position:absolute'>
					 
				  </div>";	
				  
		$output.="</body></html>";		  			

		//@afiseaza ouput 
		print $output;
	}
?>
