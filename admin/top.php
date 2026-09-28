<?
	/*
	 *****************************************************************************
	 *****************************************************************************
	 **                                                                         **
	 **          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2007       		**
	 **                                                                         **
	 *****************************************************************************
	 *****************************************************************************
	*/
	session_name("admin");
	session_start();	
	@ini_set("session.gc_maxlifetime", "18000"); //sesiunea expira in 5h
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@inceput page compress (codul de sfarsit e in 'bottom.php')
	/*
	$do_gzip_compress = FALSE;

	if(strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip'))
	{
		if(extension_loaded('zlib'))
		{
			$do_gzip_compress = TRUE;
			ob_start();
			ob_implicit_flush(0);

			header('Content-Encoding: gzip');
		}
	}
	*/
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@timpul curent in ms
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	//--------------------------------------------------------------------------------------------------------------------------
	//calculare timp executie script (calculul final e in 'bottom.php')
	$timp_start=microtime_float();	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("../functii/f_securitate.php");	
	require_once("../functii/f_bd.php");
	require_once("../functii/f_links.php");
	require_once("../functii/f_generale.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("../init.php");

	//--------------------------------------------------------------------------------------------------------------------------
	$_SESSION["tva"]=TVA;
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri clase
	require_once("../clase/arbore.php");	
	require_once("../clase/cursValutar.php");	
	require_once("../clase/autentificareAdmin.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@cursul valutar pt ziua curenta
	$curs=new cursValutar();
	$arr_curs=$curs->getCurs();
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	require_once("../smarty_connect.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@afisare moneda
	$smarty->assign("MONEDA", MONEDA);
	$smarty->assign("TVA", TVA);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@url relativ admin
	$smarty->assign("URL_ADMIN", URL_ADMIN);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@user logat
	if(!empty($_SESSION["admin_username"]) && !empty($_SESSION["admin_parola"]) && $_SESSION["admin_id_sesiune"]==session_id())
	{
		$smarty->assign("username", $_SESSION["admin_username"]);
		$smarty->assign("ultima_logare", $_SESSION["admin_ultima_logare"]);
		$smarty->assign("super_admin", $_SESSION["admin_super_admin"]);
	}
	else 
	{
		if(isset($_COOKIE[COOKIE_NAME."_cookie_admin"]))
		{
			$cookie_arr=explode(PATTERN, $_COOKIE[COOKIE_NAME."_cookie_admin"]);
			
			$autentificare=new autentificareAdmin($cookie_arr[0], $cookie_arr[1], true);		
			$autentificare->tryAutentificare();	
			
			$smarty->assign("username", $_SESSION["admin_username"]);	
			$smarty->assign("ultima_logare", $_SESSION["admin_ultima_logare"]);
			$smarty->assign("super_admin", $_SESSION["admin_super_admin"]);
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@comenzi neonorate, in asteptare, onorate, anulate, nr_utilizatori, nr_comentarii, nr_produse, subadmini, nr_mesaje, nr_retururi
	$arr_comenzi_stats=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='0' OR stare='1'");
	$smarty->assign("nr_comenzi_neonorate", $arr_comenzi_stats[0]["nr"]);

	$arr_comenzi_stats=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='2'");
	$smarty->assign("nr_comenzi_onorate", $arr_comenzi_stats[0]["nr"]);
	
	$arr_comenzi_stats=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='3'");
	$smarty->assign("nr_comenzi_anulate", $arr_comenzi_stats[0]["nr"]);
	
	$arr_comenzi_stats=arrayFromDB(array("COUNT(id_comanda) AS nr"), "t_comenzi", "WHERE stare='4'");
	$smarty->assign("nr_comenzi_in_asteptare", $arr_comenzi_stats[0]["nr"]);
	
	$arr_utilizatori_stats=arrayFromDB(array("COUNT(id_user) AS nr"), "t_useri");
	$smarty->assign("nr_utilizatori", $arr_utilizatori_stats[0]["nr"]);
	
	$arr_comentarii_stats=arrayFromDB(array("COUNT(id_comentariu) AS nr"), "t_comentarii", "WHERE activ='0'");
	$smarty->assign("nr_comentarii", $arr_comentarii_stats[0]["nr"]);
	
	$arr_produse_stats=arrayFromDB(array("COUNT(id_produs) AS nr"), "t_produse");
	$smarty->assign("nr_produse", $arr_produse_stats[0]["nr"]);
	
	$arr_subadmini_stats=arrayFromDB(array("COUNT(id_admin) AS nr"), "t_admin", "WHERE super_admin='0'");
	$smarty->assign("nr_subadmini", $arr_subadmini_stats[0]["nr"]);
	
	$arr_mesaje_stats=arrayFromDB(array("COUNT(id_mesaj) AS nr"), "t_mesaje_din_site", "WHERE citit='0'");
	$smarty->assign("nr_mesaje_necitite", $arr_mesaje_stats[0]["nr"]);
	
	$arr_mesaje_stats=arrayFromDB(array("COUNT(id_mesaj) AS nr"), "t_mesaje_din_site");
	$smarty->assign("nr_mesaje", $arr_mesaje_stats[0]["nr"]);
	
	$arr_retururi_stats=arrayFromDB(array("COUNT(id_formular) AS nr"), "t_formulare_retur");
	$smarty->assign("nr_retururi", $arr_retururi_stats[0]["nr"]);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@admin/subadmin
	$smarty->assign("super_admin", isset($_SESSION["admin_super_admin"]) ? $_SESSION["admin_super_admin"] : 0);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@diversi parametri :P
	$smarty->assign("CHILIPIR", (CHILIPIR)?1:0);
	$smarty->assign("PRETURI_VALUTA", (PRETURI_VALUTA)?1:0);
	$smarty->assign("CAT_SECUNDARE", (CAT_SECUNDARE)?1:0);
	$smarty->assign("CURS_VALUTAR_AUTOMAT", (CURS_VALUTAR_AUTOMAT)?1:0);
	$smarty->assign("MANIPULARE_PRETURI_PROC", (MANIPULARE_PRETURI_PROC)?1:0);
?>