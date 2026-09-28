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
	require_once("../clase/autentificareAdmin.php");
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/login.tpl";
	$mesaj="";
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//@link inapoi pt restul paginilor
	$_SESSION["link_inapoi"]=$_SERVER["REQUEST_URI"];
	
	//-----------------------------------------------------------------------------------------------------------------------------
	//@verificare sesiune, daca este deja logat
	if(!empty($_SESSION["admin_username"]) && !empty($_SESSION["admin_parola"]) && $_SESSION["admin_id_sesiune"]==session_id())
	{		
		$autentificare_sesiune=new autentificareAdmin($_SESSION["admin_username"], $_SESSION["admin_parola"], true);
		$autentificare_sesiune->tryAutentificare();
		
		if($autentificare_sesiune->getErori()==0)
		{
			$display_page="admin/index.tpl"; //daca este autentificat fac display la index
			
			$smarty->assign("username", $_SESSION["admin_username"]);	
			$smarty->assign("ultima_logare", isset($_SESSION["admin_ultima_logare"]) ? $_SESSION["admin_ultima_logare"] : "");
			$smarty->assign("super_admin", isset($_SESSION["admin_super_admin"]) ? $_SESSION["admin_super_admin"] : 0);
			
			//---------------------------------------------------------------------------------------------------------------------
			//@export produse csv dupa disponibilitati
			$arr_disponibilitati=arrayFromDB(array("COUNT(id_stoc) AS nr_produse", "t_stoc.stoc", "t_stoc.id_stoc"),
											 "t_stoc INNER JOIN t_produse ON t_stoc.id_stoc=t_produse.stoc",
											 "GROUP BY t_stoc.id_stoc");
									 
			$smarty->assign("disponibilitati", $arr_disponibilitati);
			
			//---------------------------------------------------------------------------------------------------------------------
			//@produse speciale
			if(isset($_GET["actiune"]) && $_GET["actiune"]=="sterge_oferta_speciala" && is_numeric($_GET["id_produs"]))
			{
				require_once("../functii/f_admin.php");
				stergeProdus($_GET["id_produs"]);
				$mesaj="Oferta speciala a fost stearsa!";
			}
			
			$arr_oferte_speciale=arrayFromDB("*", "t_produse", "WHERE tip='1' ORDER BY id_produs DESC");
			
			$smarty->assign("oferte_speciale", $arr_oferte_speciale);
			
			if(isset($_POST["modifica_preturi"]) && !empty($_POST["procent"]) && is_numeric($_POST["procent"]))
			{
				$modificator=($_POST["tip_manipulare"]==0)?"-":"+";
				$procent=$_POST["procent"];
				
				$arr_produse_de_modificat=arrayFromDB(array("id_produs", "pret", "pret_vechi"), "t_produse");				
				
				foreach($arr_produse_de_modificat as $key=>$value)
				{									
					$valoare1=($value["pret"]*$procent)/100;
					$valoare2=(!empty($value["pret_vechi"]))?(($value["pret_vechi"]*$procent)/100):"";
					
					arrayUpdateToDB("t_produse", array("pret", "pret_vechi"), array("pret".$modificator.$valoare1, "pret_vechi".$modificator.$valoare2), array("id"=>"id_produs", "valoare"=>$value["id_produs"]), true);					
				}
				
				$mesaj="Preturile au fost modificate cu succes!";
			}
		}
	}

	//-----------------------------------------------------------------------------------------------------------------------------
	//@daca nu este logat -> actiune login
	if(!empty($_POST["admin_username"]) || !empty($_POST["admin_login"]))
	{
		$autentificare=new autentificareAdmin(
			isset($_POST["admin_username"]) ? $_POST["admin_username"] : "",
			isset($_POST["admin_parola"]) ? $_POST["admin_parola"] : ""
		);		
		$acces_check=$autentificare->tryAutentificare((isset($_POST["admin_remember_me"]))?true:false);
		
		if($autentificare->getErori()==0)
		{
			header("Location:".URL_ADMIN."index.php");
		}
		else 
		{
			$smarty->assign("acces_check", $acces_check);		
		}
	}
	
	$smarty->assign("mesaj", $mesaj);
	
	require_once("right.php");
	require_once("bottom.php");
?>