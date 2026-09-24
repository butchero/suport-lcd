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
	session_start();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("conectare.php");
	require_once("configurare.php");	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("functii/f_bd.php");
	require_once("functii/f_securitate.php");
	
	if(isset($_GET["hash"]) && !empty($_GET["hash"]))
	{
		$clean_hash=curataString($_GET["hash"]);
		$arr_check=arrayFromDB("*", "t_newsletter", "WHERE md5(CONCAT(email,id_newsletter,data_inregistrarii))='".$clean_hash."'");
		
		if(count($arr_check)==1)
		{
			arrayDeleteFromDB("t_newsletter", array("id_newsletter"), array($arr_check[0]["id_newsletter"]));
			print "Ati fost dezabonat cu succes de la newsletter!";
		}
		else 
		{
			print "Acest e-mail nu este inregistrat in baza noastra de date!";
		}
	}
?>