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
	session_name("shop");
	session_start();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("conectare.php");
	require_once("configurare.php");	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("functii/f_securitate.php");
	require_once("functii/f_bd.php");
	require_once("functii/f_catalog.php");
	require_once("functii/f_generale.php");
	require_once("functii/f_links.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri clase
	require_once("clase/validariGenerale.php");
	require_once("clase/phpmailer.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	require_once("smarty_connect.php");
		 
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune recomanda produs
	if(isset($_POST["trimite"]) || isset($_POST["adresa_email"]))
	{
		//@instantiez clasa validariGenerale
		$validare=new validariGenerale();
				
		$nume_check=$validare->valideazaCamp($_POST["nume"], "nume");
		$telefon_check=$validare->valideazaTelefon($_POST["telefon"]);		
		$email_check=$validare->valideazaEmail($_POST["adresa_email"]);		
		$propunere_check=$validare->valideazaCamp($_POST["propunere"], "propunere", 150);	
		$cod_verificare_check=$validare->valideazaCodVerificare($_POST["cod_verificare"], $_SESSION["cod_verificare"]);
			
		//@validare finalizata
		if($validare->getErori()==0)
		{
			$id_insert=arrayInsertToDB("t_mesaje_din_site",
							 			array("nume", "telefon", "email", "mesaj", "tip", "data_mesaj", "citit"),
							 			array($_POST["nume"], $_POST["telefon"], $_POST["adresa_email"], nl2br($_POST["propunere"]), 0, time(), 0));
			
			if(is_numeric($id_insert) && !empty($id_insert))
				$mesaj="Propunerea fost trimisa cu succes! <br /> Va multumim pentru interesul acordat.";
			else 
				$mesaj="Propunerea nu a fost trimisa! Va rugam sa incercati mai tarziu.";
			
			//------------------------------------------------------------------------------------------------------------------
			//@sterg vars
			unset($nume_check, $telefon_check, $email_check, $propunere_check, $cod_verificare_check);
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@cod afisat pe poza
	$_SESSION["cod_verificare"]=strRandom(4);					  
   
    //--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY	
	$smarty->assign("mesaj", $mesaj);
	
	//@erori formular de trimitere recomandare
	$smarty->assign("nume_check", $nume_check);
	$smarty->assign("telefon_check", $telefon_check);
	$smarty->assign("email_check", $email_check);
	$smarty->assign("propunere_check", $propunere_check);	
	$smarty->assign("cod_verificare_check", $cod_verificare_check);
	$smarty->assign("mesaj", $mesaj);
	
	//@produs detalii
	$smarty->assign("produs", $arr_produs_detalii);

	$smarty->assign("NUME_FIRMA", NUME_FIRMA);
	
	$smarty->display("propune_produs.tpl");
?>