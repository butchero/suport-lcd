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
	$display_page="cont_utilizator/formular_de_retur.tpl";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina
	$titlu_pagina="Formular de retur";

	//--------------------------------------------------------------------------------------------------------------------------
	//@judete
	$arr_judete=arrayFromDBtoCombo("t_judete", "id_jud", "judet", "ORDER BY judet ASC");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@text formular de retur
	$arr_texte_pagina=arrayFromDB("*", "t_texte_site", "WHERE sectiune='formular_retur'");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@date retur
	$arr_date_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$_SESSION["id_user"]."'");
	
	$nume_p_contact=$_POST["nume_p_contact"];
	$nr_telefon=$_POST["nr_telefon"];
	
	if(empty($_POST["nr_telefon"]))
		$nr_telefon=$arr_date_user[0]["telefon"].", ".$arr_date_user[0]["telefon_mobil"];
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@produse retur
	$nr_linii=count($_POST["produse"]);
	
	if(isset($_POST["linie_noua"]))
		$nr_linii++;
	if(isset($_POST["sterge_linie"]))	
		$nr_linii--;

	//--------------------------------------------------------------------------------------------------------------------------
	//@contor erori
	$erori=0;	
		
	for($i=0;$i<$nr_linii;$i++)
	{
		$arr_produse[$i]=array("cantitate"=>$_POST["cantitati"][$i],
							   "produs"=>$_POST["produse"][$i],
							   "descriere"=>$_POST["descrieri"][$i]);
							   
		if(empty($_POST["cantitati"][$i]) || empty($_POST["produse"][$i]) || empty($_POST["descrieri"][$i]))		
			$erori++;			   
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@date client
	if(isset($_POST["trimite_formular"]))
	{
		foreach($_POST as $key=>$value)
		{
			if(empty($value))
			{
				$erori++;				
				break;
			}
		}
		
		if($erori>0)
			$mesaje[]="Va rugam sa completati toate campurile in mod corect!";
		if($nr_linii==0)
			$mesaje[]="Trebuie sa introduceti cel putin un produs defect!";	

		if($erori==0 && $nr_linii>0)
		{
			arrayInsertToDB("t_formulare_retur",
							 array("nume_persoana_contact", "nr_telefon", "produse_defecte", "data_trimitere", "id_user"),
							 array($nume_p_contact, $nr_telefon, serialize(array("cantitati"=>$_POST["cantitati"], "produse"=>$_POST["produse"], "descrieri"=>$_POST["descrieri"])), time(), $_SESSION["id_user"]));
			
			$mesaje[]="Formularul dvs. de retur a fost trimis cu succes! <br /> Veti fi contactat telefonic in cel mai scurt timp.";
			unset($_POST, $nume_p_contact, $nr_telefon, $arr_produse);
		}
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("mesaj", (is_array($mesaje))?implode("<br />", $mesaje):"");
	$smarty->assign("SEDIUL", SEDIUL);
	$smarty->assign("text_formular_retur", $arr_texte_pagina[0]["text"]);
	
	$smarty->assign("adresa_livrare", "Judetul ".$arr_judete[$arr_date_user[0]["id_jud"]]." - ".$arr_date_user[0]["localitate"]." - Adresa: ".$arr_date_user[0]["adresa"]." - Cod postal: ".$arr_date_user[0]["cod_postal"]);
	$smarty->assign("date_user", $arr_date_user);
	$smarty->assign("nume_p_contact", $nume_p_contact);
	$smarty->assign("nr_telefon", $nr_telefon);
	$smarty->assign("data_retur", date("d.m.Y"));
	
	$smarty->assign("produse", $arr_produse);
	
	require_once("../right.php");
	require_once("../bottom.php");
?>