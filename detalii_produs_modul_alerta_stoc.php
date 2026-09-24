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
	require_once("clase/valideazaAlertaStoc.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@tab selectat
	$tab_selectat="alerta_stoc";

	$insert_ok=0;
	
	//@formular trimis spre validare 1/0
	$form_submit=0; //netrimis
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune setare alerta
	if(isset($_POST["seteaza_alerta"]) || isset($_POST["adresa_email"]))
	{
		//@instantiez clasa valideazaAlerta
		$validare=new valideazaAlertaStoc();
				
		$email_check=$validare->valideazaEmail($_POST["adresa_email"]);		
		$cod_verificare_check=$validare->valideazaCodVerificare($_POST["cod_verificare"], $_SESSION["cod_verificare"]);
		$alerta_check=$validare->verificaAlerta($id_produs, $_POST["adresa_email"], $id_stoc);
		
		//@validare finalizata
		if($validare->getErori()==0)
		{
			$id_alerta=arrayInsertToDB("t_alerte_stoc",
									   array("id_produs", "adresa_email"),
									   array($id_produs, $_POST["adresa_email"]));
			
			(is_numeric($id_alerta))?$insert_ok=1:"";
			
			//@golesc campurile
			unset($email_check, $pretul_dorit_check, $cod_verificare_check);
		}
		else
		{
			//@1 daca formularul a fost trimis spre validare si nu a trecut de toate verificarile
			$form_submit=1;
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@cod afisat pe poza
	$_SESSION["cod_verificare"]=strRandom(4);
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("form_submit", $form_submit);
?>