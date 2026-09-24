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
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");
	require_once("../init.php");	
	require_once("../functii/f_bd.php");
	
	if(!PRETURI_VALUTA)
		die("Modulul convertire preturi din valuta in RON este dezactivat din config.php!");
	
	$arr_curs_valutar=arrayFromDB(array("usd", "euro"), "t_curs_bnr", "ORDER BY id_curs DESC LIMIT 0, 1");
	
	$curs_valutar["usd"]=str_replace(",", ".", $arr_curs_valutar[0]["usd"]);
	$curs_valutar["euro"]=str_replace(",", ".", $arr_curs_valutar[0]["euro"]);
	
	$arr_produse=arrayFromDB("*", "t_preturi_produse_valuta");
	$nr_produse=count($arr_produse);
	
	//@updatez produsele cu pretul din tabelul cu t_preturi_produse_valuta si setez pret_vechi pe 0
	for($i=0;$i<$nr_produse;$i++)
		arrayUpdateToDB("t_produse", 
						array("pret", "pret_vechi"), array($arr_produse[$i]["pret_valuta"]*$curs_valutar[$arr_produse[$i]["moneda"]], 0),
						array("id"=>"id_produs", "valoare"=>$arr_produse[$i]["id_produs"]));
?>