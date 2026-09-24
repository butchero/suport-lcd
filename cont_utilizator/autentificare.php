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
	require_once("../clase/autentificareUser.php");
	
	$autentificare_sesiune=new autentificareUser($_SESSION["username"], $_SESSION["parola"], true);
	$autentificare_sesiune->tryAutentificare();
	
	if($_SESSION["admin_acces"]!=PAROLA_ADMIN_USER)
	{
		if($autentificare_sesiune->getErori()!=0)
		{
			header("Location:".URL_BASE);
			exit;
		}
	}
?>