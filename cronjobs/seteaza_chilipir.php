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
	
	if(!CHILIPIR)
		die("Modulul chilipir este dezactivat din config.php!");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@se presupune ca: chilipirul este setat pentru fiecare zi in avans, fara gauri de genul luni, miercuri...altfel nu mai merge bine cronul :P
	
	$ieri=date("Ymd", strtotime("yesterday"));
	$azi=date("Ymd");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@setez chilipirul curent
	$arr_chilipir=arrayFromDB("*", "t_chilipirul_zilei", "WHERE data_chilipir='".$azi."'");
	
	if(count($arr_chilipir)==1)
	{
		$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$arr_chilipir[0]["id_produs"]."'");
		
		arrayUpdateToDB("t_produse",
						 array("pret", "pret_vechi"),
						 array($arr_chilipir[0]["pret_chilipir"], $arr_produs[0]["pret"]),
						 array("id"=>"id_produs", "valoare"=>$arr_chilipir[0]["id_produs"]));

		//@actualizez pretul curent in t_chilipirul_zilei in caz ca a fost modificat pretul in t_produse intre timp				  
		arrayUpdateToDB("t_chilipirul_zilei",
						 array("pret_curent"), array($arr_produs[0]["pret"]), 
						 array("id"=>"id_produs", "valoare"=>$arr_produs[0]["id_produs"]));
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@setez chilipirul vechi la pret normal
	$arr_chilipir_vechi=arrayFromDB("*", "t_chilipirul_zilei", "WHERE data_chilipir='".$ieri."'");
	
	if(count($arr_chilipir_vechi)==1)
	{
		arrayUpdateToDB("t_produse",
						 array("pret", "pret_vechi"),
						 array($arr_chilipir_vechi[0]["pret_curent"], ""),
						 array("id"=>"id_produs", "valoare"=>$arr_chilipir_vechi[0]["id_produs"]));
	}
?>