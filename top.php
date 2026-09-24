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
	session_name("shop");
	session_start();	
	@ini_set("session.gc_maxlifetime", "18000"); //sesiunea expira in 5h
	
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
	require_once("conectare.php");
	require_once("configurare.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("functii/f_securitate.php");	
	require_once("functii/f_bd.php");
	require_once("functii/f_links.php");
	require_once("functii/f_generale.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("init.php");
	
	$_SESSION["tva"]=TVA;
	
	//@include-uri clase
	require_once("clase/arbore.php");	
	require_once("clase/cursValutar.php");	
	require_once("clase/autentificareUser.php");
	
	//@cursul valutar pt ziua curenta
	$curs=new cursValutar();
	$arr_curs=$curs->getCurs();
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	require_once("smarty_connect.php");
	
	//@afisare moneda
	$smarty->assign("MONEDA", MONEDA);
	
	//@altele
	$smarty->assign("TVA", TVA);
	$smarty->assign("TRANSPORT_GRATUIT", TRANSPORT_GRATUIT);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@user logat
	if(!empty($_SESSION["username"]) && !empty($_SESSION["parola"]) && $_SESSION["id_sesiune"]==session_id())
	{
		$smarty->assign("username", $_SESSION["username"]);
		$smarty->assign("nume_utilizator", $_SESSION["nume_utilizator"]);
	}
	else 
	{
		if(isset($_COOKIE[COOKIE_NAME."_cookie"]))
		{
			$cookie_arr=explode(PATTERN, $_COOKIE[COOKIE_NAME."_cookie"]);
			
			$autentificare=new autentificareUser($cookie_arr[0], $cookie_arr[1], true);		
			$autentificare->tryAutentificare();	
			
			$smarty->assign("username", $_SESSION["username"]);
			$smarty->assign("nume_utilizator", $_SESSION["nume_utilizator"]);		
		}
	}

	//--------------------------------------------------------------------------------------------------------------------------
	//@chilipirul zilei
	if(CHILIPIR)
	{
		require_once("functii/f_catalog.php");
		
		$arr_chilipir=arrayFromDB(array("b.id_produs", "b.nume_produs",  "b.pret", "a.pret_curent", "a.pret_chilipir", "c.link_cat"),
								  "t_chilipirul_zilei AS a INNER JOIN t_produse AS b ON a.id_produs=b.id_produs 
								  						   LEFT JOIN t_categorii AS c ON b.id_cat=c.id_cat",
								  "WHERE a.data_chilipir='".date("Ymd")."'");

		if(count($arr_chilipir)==1)
		{			
			$smarty->assign("nume_chilipir", $arr_chilipir[0]["nume_produs"]);
			$smarty->assign("pret_chilipir", formateazaNr($arr_chilipir[0]["pret"]*TVA));
			$smarty->assign("pret_curent", formateazaNr($arr_chilipir[0]["pret_curent"]*TVA));
			$smarty->assign("poza_chilipir", getPozaPrincipalaProdus($arr_chilipir[0]["id_produs"]));
			$smarty->assign("link_chilipir", getLinkProdus($arr_chilipir[0]["link_cat"], $arr_chilipir[0]["nume_produs"], $arr_chilipir[0]["id_produs"]));
			
			//@calcul ore ramase pana expira oferta
			$timestamp1=strtotime(date("Ymd"));
			$timestamp2=time();
			
			$timp_expirare_chilipir=((($timestamp2-$timestamp1)/(60*60))*100)/24;
			
			$smarty->assign("timp_consumat", number_format($timp_expirare_chilipir, 0));
			$smarty->assign("timp_total", 100);
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@categorii secundare
	$smarty->assign("CAT_SECUNDARE", (CAT_SECUNDARE)?1:0);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@navigare prin detalii
	$smarty->assign("NAVIGARE_DIN_DETALII", (NAVIGARE_DIN_DETALII)?1:0);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@taburi meniu
	if($_SERVER["REQUEST_URI"]==BASE_NAME)
		$tab_menu=1;
	elseif($_SERVER["REQUEST_URI"]==BASE_NAME."intrebari-frecvente")	
		$tab_menu=2;
	elseif($_SERVER["REQUEST_URI"]==BASE_NAME."despre-noi")
		$tab_menu=3;
	elseif($_SERVER["REQUEST_URI"]==BASE_NAME."termeni-si-conditii")
		$tab_menu=4;
	elseif($_SERVER["REQUEST_URI"]==BASE_NAME."contact")
		$tab_menu=5;
		
	$smarty->assign("tab_menu", $tab_menu);
?>