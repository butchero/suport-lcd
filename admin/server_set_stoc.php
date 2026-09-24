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
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@proceseaza requestul ajax
	if(is_numeric($_GET["id_produs"]) && is_numeric($_GET["id_stoc"]))
	{
		$arr_produs=arrayFromDB(array("cod_produs"), "t_produse", "WHERE id_produs='".$_GET["id_produs"]."'");
		$arr_stoc=arrayFromDB("*", "t_stoc", "WHERE id_stoc='".$_GET["id_stoc"]."'");
		
		//@verificare
		if(count($arr_produs)==0 || count($arr_stoc)==0)
			die("Eroare actualizare stoc");
		
		arrayUpdateToDB("t_produse",
						 array("stoc"), array($_GET["id_stoc"]),
						 array("id"=>"cod_produs", "valoare"=>$arr_produs[0]["cod_produs"]));	
		//----------------------------------------------------------------------------------------------------------------------
		//@actualizare stoc gsmaccesorii				  
		if(!empty($arr_produs[0]["cod_produs"]) && file_exists(URL_BASE_ABS."admin/module/gsmnet_preturi_disponibilitati_sincronizare.php"))
		{
			require_once(URL_BASE_ABS."admin/module/conectare_db_gsmaccesorii.php");
			
			arrayUpdateToDB("t_produse",
							array("stoc"), array($_GET["id_stoc"]),
							array("id"=>"cod_produs", "valoare"=>$arr_produs[0]["cod_produs"]));
		}
						 
		print "Stoc produs actualizat cu '".$arr_stoc[0]["stoc"]."'";
	}
	else print "Eroare actualizare stoc";	
?>