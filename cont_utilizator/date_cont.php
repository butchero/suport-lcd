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
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="cont_utilizator/date_cont.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Date cont";
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@toate judetele
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@modificate date cont
	if(isset($_POST["modifica_cont"]) || isset($_POST["nume"]))
	{
		//@instantiez clasa valideazaUser
		$validare=new valideazaUser();
		
		//@validari campuri
		$user_check=array("camp"=>$_POST["username"], "valid"=>1);
		(!empty($_POST["parola"]))?$parola_check=$validare->valideazaParola($_POST["parola"], $_POST["parola_verificare"]):"";
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
			
		//@validare campuri societate
		if(isset($_POST["sunt_societate"]) && $_POST["sunt_societate"]==1)
		{
			$societate_check=$validare->valideazaCamp($_POST["societate"], "societate");
			$cod_fiscal_check=$validare->valideazaCamp($_POST["cod_fiscal"], "cod fiscal");
			$nr_reg_comert_check=$validare->valideazaCamp($_POST["nr_reg_comert"], "nr reg comert");
			$banca_check=$validare->valideazaCamp($_POST["banca"], "banca");
			$cod_iban_check=$validare->valideazaCamp($_POST["cod_iban"], "cod iban");
		}
		else 
		{
			unset($_POST["societate"], $_POST["cod_fiscal"], $_POST["nr_reg_comert"], $_POST["banca"], $_POST["cod_iban"]);
		}
			
		//@validare finalizata
		if($validare->getErori()==0)
		{
			if(empty($_POST["parola"]))
			{
				$insert_user=arrayUpdateToDB("t_useri",
											 array("email", "nume", "prenume", "cnp", "adresa", "cod_postal", "localitate",
											 	   "id_jud", "telefon", "telefon_mobil", "fax", "societate", "cod_fiscal", "nr_reg_comert", "banca", "cod_iban"),
											 array($_POST["email"], $_POST["nume"], $_POST["prenume"],
											 	   $_POST["cnp"], $_POST["adresa"], $_POST["cod_postal"], $_POST["localitate"], $_POST["judet"],
											 	   $_POST["telefon"], $_POST["telefon_mobil"], $_POST["fax"], $_POST["societate"], $_POST["cod_fiscal"], $_POST["nr_reg_comert"],
											 	   $_POST["banca"], $_POST["cod_iban"]),
											 array("id"=>"id_user", "valoare"=>$_SESSION["id_user"]));
			}
			else 
			{
				$insert_user=arrayUpdateToDB("t_useri",
											 array("parola", "email", "nume", "prenume", "cnp", "adresa", "cod_postal", "localitate",
											 	   "id_jud", "telefon", "telefon_mobil", "fax", "societate", "cod_fiscal", "nr_reg_comert", "banca", "cod_iban"),
											 array(md5($_POST["parola"]), $_POST["email"], $_POST["nume"], $_POST["prenume"],
											 	   $_POST["cnp"], $_POST["adresa"], $_POST["cod_postal"], $_POST["localitate"], $_POST["judet"],
											 	   $_POST["telefon"], $_POST["telefon_mobil"], $_POST["fax"], $_POST["societate"], $_POST["cod_fiscal"], $_POST["nr_reg_comert"],
											 	   $_POST["banca"], $_POST["cod_iban"]),
											 array("id"=>"id_user", "valoare"=>$_SESSION["id_user"]));
			}
		}
						
		//@1 daca formular a fost trimis spre validare	
		$smarty->assign("form_submit", 1);
	}
	else 
	{
		$date_cont=arrayFromDB("*", "t_useri", "WHERE id_user='".$_SESSION["id_user"]."'");
		
		//@bd->formular
		$user_check=array("camp"=>$date_cont[0]["username"], "valid"=>1);
		$nume_check=array("camp"=>$date_cont[0]["nume"], "valid"=>1);
		$prenume_check=array("camp"=>$date_cont[0]["prenume"], "valid"=>1);
		$cnp_check=array("camp"=>$date_cont[0]["cnp"], "valid"=>1);
		$email_check=array("camp"=>$date_cont[0]["email"], "valid"=>1);
		$_POST["email_verificare"]=$date_cont[0]["email"];
		$adresa_check=array("camp"=>$date_cont[0]["adresa"], "valid"=>1);
		$cod_postal_check=array("camp"=>$date_cont[0]["cod_postal"], "valid"=>1);
		$localitate_check=array("camp"=>$date_cont[0]["localitate"], "valid"=>1);
		$judet_check=array("camp"=>$date_cont[0]["id_jud"], "valid"=>1);
		$telefon_check=array("camp"=>$date_cont[0]["telefon"], "valid"=>1);
		$telefon_mobil_check=array("camp"=>$date_cont[0]["telefon_mobil"], "valid"=>1);
		$_POST["fax"]=(empty($date_cont[0]["fax"]))?"":$date_cont[0]["fax"];		
		
		if(!empty($date_cont[0]["societate"]))
		{
			$_POST["sunt_societate"]=1;
		}
				
		if(isset($_POST["sunt_societate"]) && $_POST["sunt_societate"]==1)
		{
			$societate_check=array("camp"=>$date_cont[0]["societate"], "valid"=>1);
			$cod_fiscal_check=array("camp"=>$date_cont[0]["cod_fiscal"], "valid"=>1);
			$nr_reg_comert_check=array("camp"=>$date_cont[0]["nr_reg_comert"], "valid"=>1);
			$banca_check=array("camp"=>$date_cont[0]["banca"], "valid"=>1);;
			$cod_iban_check=array("camp"=>$date_cont[0]["cod_iban"], "valid"=>1);
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY (erori/mesaje)
	
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
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@asignare judete->smarty
	$smarty->assign("judete", $arr_judete);
	
	require_once("../right.php");
	require_once("../bottom.php");
?>