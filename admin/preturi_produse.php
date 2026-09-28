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
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	//@modul activat/dezactivat check
	if(!PRETURI_VALUTA)
		die("Aceasta sectiune este dezactivata! <br /><a href='".URL_ADMIN."'>Prima pagina din administrare.</a>");
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/preturi_produse.tpl";	
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@actiune manuala pt convertire preturi
	if(isset($_POST["converteste_preturi"]))
	{
		require_once("../cronjobs/convertire_preturi.php");
		$mesaj="Preturile din catalog au fost convertite in RON la cursul BNR curent folosind preturile in valuta din aceasta sectiune!";
		unset($arr_produse, $nr_produse, $curs_valutar);
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@adauga curs valutar manual
	if(isset($_POST["insereaza_curs_nou"]))
	{
		$usd_in_ron=str_replace(",", ".", $_POST["custom_usd"]);
		$euro_in_ron=str_replace(",", ".", $_POST["custom_euro"]);
		
		if(is_numeric($usd_in_ron) && is_numeric($euro_in_ron))
		{
			$mysqli->query("TRUNCATE t_curs_bnr");
			arrayInsertToDB("t_curs_bnr", array("data", "usd", "euro"), array(date("Ymd"), $usd_in_ron, $euro_in_ron));
			
			$mesaj="A fost adaugat cursul!";
			
			//@redirect pt a actualiza cursul
			unset($_SESSION["curs_valutar"]);
			header("Location:".URL_ADMIN."preturi_produse.php");
		}
		else 
		{
			$mesaj="Cursul USD sau EURO introdus nu este numeric!";
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@actiune modificare produs
	if(isset($_POST["modifica"]) && !empty($_POST["id_produs"]) && is_numeric($_POST["id_produs"]))
	{
		$id_produs=$_POST["id_produs"];
		$pret=str_replace(",", ".", $_POST["pret"]);
		$moneda=$_POST["moneda"];
		$stoc=$_POST["stoc"];
		
		arrayUpdateToDB("t_produse", array("stoc"), array($stoc), array("id"=>"id_produs", "valoare"=>$id_produs));
		$mesaj="Disponibilitatea produsului a fost actualizata!";
		
		if(!empty($pret) && is_numeric($pret))
		{
			$arr_check=arrayFromDB(array("id_produs"), "t_preturi_produse_valuta", "WHERE id_produs='".$id_produs."'");
			
			if(count($arr_check)==0)
			{
				arrayInsertToDB("t_preturi_produse_valuta",
								array("id_produs", "pret_valuta", "moneda"),
								array($id_produs, $pret, $moneda));
								
				$mesaj.="<br />Pretul produsului a fost setat!";	
			}	
			else 
			{		
				arrayUpdateToDB("t_preturi_produse_valuta",
								 array("id_produs", "pret_valuta", "moneda"),
								 array($id_produs, $pret, $moneda),
								 array("id"=>"id_produs", "valoare"=>$id_produs));
								 
				$mesaj.="<br />Pretul produsului a fost actualizat!";			 
			}
		}
		else 
		{
			arrayDeleteFromDB("t_preturi_produse_valuta", array("id_produs"), array($id_produs));
			
			$mesaj.="<br />Pretul produsului fost sters!";
		}
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------	
	//@afiseaza produse din categoria selectata	
	if(isset($_REQUEST["id_cat"]) && !empty($_REQUEST["id_cat"]) && is_numeric($_REQUEST["id_cat"]))
	{    
		//-----------------------------------------------------------------------------------------------------------------------------
		//@paginare
		require_once("../clase/paginare.php");
			
		$id_cat=$_REQUEST["id_cat"];
		
		$paginare=new paginare("pag", 
							   "SELECT COUNT(a.id_produs) AS nr FROM t_produse AS a 
							   		LEFT JOIN t_preturi_produse_valuta AS b ON a.id_produs=b.id_produs							   		
							   	WHERE a.id_cat='".$id_cat."'", 
							    URL_ADMIN."preturi_produse.php?pag=".PATTERN."&id_cat=".$id_cat);
							     
		$paginare_string=$paginare->doPaginare();
		
		$arr_produse=arrayFromDB(array("a.id_produs", "nume_produs", "pret_valuta", "moneda", "a.stoc"),
								 "t_produse AS a LEFT JOIN t_preturi_produse_valuta AS b ON a.id_produs=b.id_produs",
								 "WHERE a.id_cat='".$id_cat."' ORDER BY a.nume_produs ASC LIMIT ".$paginare->getLimitStart().", ".AFISARI_PE_PAG);
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("curs", $arr_curs);
	$smarty->assign("mesaj", $mesaj);
	$smarty->assign("produse", $arr_produse);
	$smarty->assign("id_cat", $id_cat);
	$smarty->assign("paginare", $paginare_string);
	$smarty->assign("pag", $_GET["pag"]);
	
	require_once("right.php");
	require_once("bottom.php");
?>