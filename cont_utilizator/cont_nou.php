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
	require_once("../clase/valideazaUser.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/cont_nou.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Creeaza cont nou";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@toate judetele
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet");

	//--------------------------------------------------------------------------------------------------------------------------
	//@tab selectat
	$tab_selectat="creeaza_cont_nou";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@actiune creeaza cont
	if(isset($_POST["creeaza_cont"]) || isset($_POST["username"]))
	{
		//@instantiez clasa valideazaUser
		$validare=new valideazaUser();
		
		//@validari campuri
		$user_check=$validare->valideazaUserName($_POST["username"]);
		$parola_check=$validare->valideazaParola($_POST["parola"], $_POST["parola_verificare"]);
		$nume_check=$validare->valideazaCamp($_POST["nume"], "nume");
		$prenume_check=$validare->valideazaCamp($_POST["prenume"], "prenume");
		$cnp_check=$validare->valideazaCNP($_POST["cnp"]);
		$email_check=$validare->valideazaEmail($_POST["email"], $_POST["email_verificare"]);
		$adresa_check=$validare->valideazaCamp($_POST["adresa"], "adresa");
		$cod_postal_check=$validare->valideazaCodPostal($_POST["cod_postal"]);
		$localitate_check=$validare->valideazaCamp($_POST["localitate"], "localitate");
		$judet_check=$validare->valideazaJudet($_POST["judet"]);
		$telefon_check=$validare->valideazaTelefon($_POST["telefon"]);
		$telefon_mobil_check=$validare->valideazaTelefon($_POST["telefon_mobil"]);
		$termeni_conditii_check=$validare->valideazaTermeniConditii($_POST["termeni_conditii"]);
			
		//@validare campuri societate
		if(isset($_POST["sunt_societate"]) && $_POST["sunt_societate"]==1)
		{
			$societate_check=$validare->valideazaCamp($_POST["societate"], "societate");
			$cod_fiscal_check=$validare->valideazaCamp($_POST["cod_fiscal"], "cod fiscal");
			$nr_reg_comert_check=$validare->valideazaCamp($_POST["nr_reg_comert"], "nr reg comert");
			$banca_check=$validare->valideazaCamp($_POST["banca"], "banca");
			$cod_iban_check=$validare->valideazaCamp($_POST["cod_iban"], "cod iban");
		}
			
		//@validare finalizata
		if($validare->getErori()==0)
		{
			$data_inregistrarii=time();
			
			//@inregistrare utilizator
			$insert_user=arrayInsertToDB("t_useri",
										 array("username", "parola", "email", "nume", "prenume", "cnp", "adresa", "cod_postal", "localitate",
										 	   "id_jud", "telefon", "telefon_mobil", "fax", "societate", "cod_fiscal", "nr_reg_comert", "banca", "cod_iban", "data_inregistrarii"),
										 array($_POST["username"], md5($_POST["parola"]), $_POST["email"], $_POST["nume"], $_POST["prenume"],
										 	   $_POST["cnp"], $_POST["adresa"], $_POST["cod_postal"], $_POST["localitate"], $_POST["judet"],
										 	   $_POST["telefon"], $_POST["telefon_mobil"], $_POST["fax"], $_POST["societate"], $_POST["cod_fiscal"], $_POST["nr_reg_comert"],
										 	   $_POST["banca"], $_POST["cod_iban"], $data_inregistrarii));
			
			//@creez directorul in care vor fi stocate proformele							 	   
			@mkdir(URL_BASE_ABS."proforme/".md5($data_inregistrarii.$insert_user), 0777);
										 	     
			//@tab selectat
			$tab_selectat="validare_finalizata";
		}
			
		//--------------------------------------------------------------------------------------------------------------------------
		//ASIGNARE VARIABILE PHP->SMARTY (erori)
		
		$smarty->assign("user_check", $user_check);
		$smarty->assign("parola_check", $parola_check);
		$smarty->assign("parola_verificare", $_POST["parola_verificare"]);
		$smarty->assign("nume_check", $nume_check);
		$smarty->assign("prenume_check", $prenume_check);
		$smarty->assign("cnp_check", $cnp_check);
		$smarty->assign("email_check", $email_check);
		$smarty->assign("email_verificare", $_POST["email_verificare"]);
		$smarty->assign("adresa_check", $adresa_check);
		$smarty->assign("cod_postal_check", $cod_postal_check);
		$smarty->assign("localitate_check", $localitate_check);
		$smarty->assign("judet_check", $judet_check);
		$smarty->assign("telefon_check", $telefon_check);
		$smarty->assign("telefon_mobil_check", $telefon_mobil_check);
		$smarty->assign("fax_check", array("camp"=>$_POST["fax"]));
		$smarty->assign("sunt_societate", $_POST["sunt_societate"]);		
		$smarty->assign("societate_check", $societate_check);
		$smarty->assign("cod_fiscal_check", $cod_fiscal_check);
		$smarty->assign("nr_reg_comert_check", $nr_reg_comert_check);
		$smarty->assign("banca_check", $banca_check);
		$smarty->assign("cod_iban_check", $cod_iban_check);	
		$smarty->assign("termeni_conditii_check", $termeni_conditii_check);
		
		//@1 daca formular a fost trimis spre validare	
		$smarty->assign("form_submit", 1);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@asignare taburi->smarty
	$smarty->assign("tab_selectat", $tab_selectat);
	
	//@asignare judete->smarty
	$smarty->assign("judete", $arr_judete);
	
	require_once("../right.php");
	require_once("../bottom.php");
?>