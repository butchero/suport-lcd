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
	//--------------------------------------------------------------------------------------------------------------------------
	session_name("admin");
	session_start();
	
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");	
	require_once("../functii/f_bd.php");
	require_once("../functii/f_admin.php");	
	require_once("../functii/f_catalog.php");
	
	//@init
	require_once("../init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//PROCESEZ REQUESTUL AJAX - edit in place
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@editare descriere categorie
	if(is_numeric($_GET["id_cat"]) && !empty($_GET["id_cat"]))
	{
		arrayUpdateToDB("t_categorii", array("descriere_cat"), array(nl2br($_POST["content"])), array("id"=>"id_cat", "valoare"=>$_GET["id_cat"]));
		$arr_cat=arrayFromDB("*", "t_categorii", "WHERE id_cat='".$_GET["id_cat"]."'");
		
		//@print raspuns ajax
		print inverse_nl2br($arr_cat[0]["descriere_cat"]);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@editare pret produs
	if(is_numeric($_GET["id_produs"]) && !empty($_GET["id_produs"]))
	{
		$pret=str_replace(",", ".", trim($_POST["content"]));
		
		if(is_numeric($pret) && !empty($pret) && $pret>0)
		{
			arrayUpdateToDB("t_produse", array("pret"), array($pret), array("id"=>"id_produs", "valoare"=>$_GET["id_produs"]));
			$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$_GET["id_produs"]."'");
	
			//------------------------------------------------------------------------------------------------------------------
			//@actualizare pret gsmaccesorii
			if(!empty($arr_produs[0]["cod_produs"]) && file_exists(URL_BASE_ABS."admin/module/gsmnet_preturi_disponibilitati_sincronizare.php"))
			{
				require_once(URL_BASE_ABS."admin/module/conectare_db_gsmaccesorii.php");
				
				arrayUpdateToDB("t_produse",
								array("pret"), array($pret),
								array("id"=>"cod_produs", "valoare"=>$arr_produs[0]["cod_produs"]));
			}
			
			//@print raspuns ajax
			print ($arr_produs[0]["pret"]*TVA);
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@editare nota admin formular retur
	if(is_numeric($_GET["id_formular"]) && !empty($_GET["id_formular"]))
	{
		arrayUpdateToDB("t_formulare_retur", array("nota_admin"), array(nl2br($_POST["content"])), array("id"=>"id_formular", "valoare"=>$_GET["id_formular"]));
		$arr_formular_retur=arrayFromDB("*", "t_formulare_retur", "WHERE id_formular='".$_GET["id_formular"]."'");
		
		//@print raspuns ajax
		print inverse_nl2br($arr_formular_retur[0]["nota_admin"]);
	}
?>