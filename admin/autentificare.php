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
	require_once("../clase/autentificareAdmin.php");
	
	$autentificare_sesiune=new autentificareAdmin($_SESSION["admin_username"], $_SESSION["admin_parola"], true);
	$autentificare_sesiune->tryAutentificare();
	
	if($autentificare_sesiune->getErori()!=0)
	{
		header("Location:".URL_ADMIN);
		exit;
	}
?>