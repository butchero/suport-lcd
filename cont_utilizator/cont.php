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
	require_once("../top.php");
	require_once("../left.php");	
	require_once("../clase/autentificareUser.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/cont.tpl";
		
	//@verificare sesiune, daca este deja logat
	if(!empty($_SESSION["username"]) && !empty($_SESSION["parola"]) && $_SESSION["id_sesiune"]==session_id())
	{		
		$autentificare_sesiune=new autentificareUser($_SESSION["username"], $_SESSION["parola"], true);
		$autentificare_sesiune->tryAutentificare();
		
		if($autentificare_sesiune->getErori()==0)
		{
			header("Location:".URL_BASE."contul-meu");
			exit;
		}
	}
		
	//@login
	if(!empty($_POST["username"]) || !empty($_POST["login"]))
	{
		$autentificare=new autentificareUser($_POST["username"], $_POST["parola"]);		
		$acces_check=$autentificare->tryAutentificare((isset($_POST["remember_me"]))?true:false);
		
		if($autentificare->getErori()==0)
		{
			header("Location:".URL_BASE."contul-meu");			
			exit;
		}
		else 
		{
			$smarty->assign("acces_check", $acces_check);		
		}
	}
	
	
	require_once("../right.php");
	require_once("../bottom.php");
?>