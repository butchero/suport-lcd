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
	require_once("functii/f_securitate.php");
	require_once("functii/f_bd.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri clase
	require_once("clase/validariGenerale.php");

	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	require_once("smarty_connect.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@validare email
	$validare=new validariGenerale();				  
	$email_check=$validare->valideazaEmail($_GET["email"]);
	
	if($validare->getErori()==0)
	{
		$arr_email=arrayFromDB(array("email"), "t_newsletter", "WHERE email='".prepareStringToDB($_GET["email"])."'");
		
		if(count($arr_email)==0)
		{
			$id_abonat=arrayInsertToDB("t_newsletter", array("email", "contor", "data_inregistrarii"), array($_GET["email"], 0, time()));
			$mesaj="Ati fost abonat cu succes la newsletter ! Va multumim pentru interes.";
		}
		else $mesaj="Sunteti deja abonat la newsletter ! <br /><br /> Va multumim pentru interes";
		
	}
	else $mesaj=$email_check["eroare"];
	
   
    //--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("mesaj", $mesaj);
	
	//@atribui nume firma la tpl pt ca nu mai am "bottom.php"
	$smarty->assign("NUME_FIRMA", NUME_FIRMA);
				
	//--------------------------------------------------------------------------------------------------------------------------
	//AFISEAZA PAGINA
	$smarty->display("newsletter.tpl");
?>