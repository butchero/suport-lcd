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
	require_once("top.php");
	require_once("left.php");	
	require_once("../functii/f_admin.php");
	require_once("../functii/f_securitate.php");
	require_once("../functii/f_catalog.php");
	require_once("../clase/gestioneazaFiltre.php");
	require_once("../clase/valideazaProdus.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/gestioneaza_produse.tpl";
	
	//@formular trimis spre validare 1/0
	$form_submit=0; //netrimis

	//---------------------------------------------------------------------------------------------------------------------------------
	//@acest fisier este folosit atat pt adaugare produs cat si pentru editare - in editare se poate ajunge din catalog sau din cautare
	
	//daca s-a facut o cautare si s-a ajuns in gestioneaza produse din cautare
	if(isset($_GET["string"]) && empty($_POST)) 
		$_SESSION["link_inapoi"]=$_SERVER["HTTP_REFERER"];
	
	if(is_numeric($_GET["id_produs"]))
	{
		$arr_produs=arrayFromDB(array("id_cat"), "t_produse", "WHERE id_produs='".$_GET["id_produs"]."'");
		$id_cat=$arr_produs[0]["id_cat"];
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@verific si aflu numele categoriei de care apartine produsul sau in care va fi adaugat produsul
	$arr_categorie=arrayFromDB("*", "t_categorii", "WHERE id_cat='".$id_cat."'");
	$nume_cat=$arr_categorie[0]["nume_cat"];
	
	if(count($arr_categorie)!=1)
		die("Categoria nu exista!");
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//STERGE POZA
	if(isset($_GET["sterge_poza"]) && preg_match("/[0-9]+\.jpg/", $_GET["sterge_poza"])!=0 && is_numeric($_GET["id_produs"]))
	{
		$url_poza=URL_BASE_ABS."poze_produse/".$_GET["id_produs"]."/%s/".$_GET["sterge_poza"];
		
		@unlink(sprintf($url_poza, "mici"));
		@unlink(sprintf($url_poza, "medii"));
		@unlink(sprintf($url_poza, "mari"));
		@unlink(sprintf($url_poza, "supermari"));
		
		$mesaj="Poza a fost stearsa cu succes!";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//@STERGE FISIER
	if(isset($_GET["sterge_fisier"]) && is_numeric($_GET["id_produs"]) && !empty($_GET["sterge_fisier"]))
	{
		@unlink(URL_BASE_ABS."poze_produse/".$_GET["id_produs"]."/".$_GET["sterge_fisier"]);
	}
		
	//---------------------------------------------------------------------------------------------------------------------------------	
	//VARIABILE FORMULAR

	//@afisare detalii produs pt editare
	if(isset($_GET["id_produs"]) && is_numeric($_GET["id_produs"]) && !isset($_POST["modifica_produs"]))
	{
		$id_produs=$_GET["id_produs"];
		$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$id_produs."'");

		$nume_produs=htmlspecialchars($arr_produs[0]["nume_produs"]);
		$producator_selectat=$arr_produs[0]["id_prod"];
		$pret=$arr_produs[0]["pret"];
		$pret_vechi=$arr_produs[0]["pret_vechi"];
		$furnizor=$arr_produs[0]["furnizor"];
		$cod_produs=trim($arr_produs[0]["cod_produs"]);
		
		$arr_valori_posibile=explode(";", $arr_produs[0]["caracteristici"]);
		$nr_valori_posibile=count($arr_valori_posibile)-1;
		
		for($i=1;$i<$nr_valori_posibile;$i++) //incep de la '1' pana la 'count($arr)-1' pt ca prima si ultima valoare delimitata de ';' sunt nule		
			$caracteristici[]=$arr_valori_posibile[$i]	;	
		
		$filtre_selectate=$caracteristici;
		$stoc_selectat=$arr_produs[0]["stoc"];
		$descriere_produs=inverse_nl2br($arr_produs[0]["descriere_produs"]);
		$oferta_speciala=$arr_produs[0]["tip"];
		
		//@construiesc variabilele din campurile obligatorii de felul asta pt a pastra structura tpl-ului si la modificare si la adaugare
		$nume_produs_check=array("valid"=>1, "camp"=>$nume_produs, "eroare"=>"");								 
		$pret_check=array("valid"=>1, "camp"=>$pret, "eroare"=>"");
						  
		(!empty($pret_vechi))?$pret_vechi_check=array("valid"=>1, "camp"=>$pret_vechi, "eroare"=>""):"";
		(!empty($cod_produs))?$cod_produs_check=array("valid"=>1, "camp"=>$cod_produs, "eroare"=>""):"";

		//@galerie produs
		$poza_principala=str_replace("/mari/", "/medii/", getPozaPrincipalaMareProdus($id_produs));
		
		$arr_galerie=genereazaGalerie($id_produs, true);
		$poze_sec_medii=$arr_galerie["medii"];
		$poze=$arr_galerie["poze"];
		$nr_ultima_poza=(is_numeric($arr_galerie["ultima_poza"]) && $arr_galerie["ultima_poza"]!="")?$arr_galerie["ultima_poza"]:0;
		
		$nr_poze_sec=count($poze_sec_medii);
	}
	//@adaugare sau modificare daca se face submit la form
	else 
	{
		if(isset($_POST["modifica_produs"]))
		{
			$id_produs=$_GET["id_produs"];
			
			//@galerie produs
			$poza_principala=str_replace("/mari/", "/medii/", getPozaPrincipalaMareProdus($id_produs));
			
			$arr_galerie=genereazaGalerie($id_produs, true);
			$poze_sec_medii=$arr_galerie["medii"];
			$poze=$arr_galerie["poze"];
			$nr_ultima_poza=(is_numeric($arr_galerie["ultima_poza"]) && $arr_galerie["ultima_poza"]!="")?$arr_galerie["ultima_poza"]:0;
			
			$nr_poze_sec=count($poze_sec_medii);
		}
		
		$nume_produs=htmlspecialchars(trim(prepareStringFromDB($_POST["nume_produs"])));
		$producator_selectat=$_POST["producator"];
		$furnizor=$_POST["furnizor"];
		$cod_produs=trim($_POST["cod_produs"]);
		$pret=str_replace(",", ".", trim($_POST["pret"]));
		$pret_vechi=str_replace(",", ".", trim($_POST["pret_vechi"]));
		$filtre_selectate=$_POST["filtre"];
		$stoc_selectat=$_POST["stoc"];
		$descriere_produs=inverse_nl2br(prepareStringFromDB($_POST["descriere_produs"]));
		$oferta_speciala=$_POST["oferta_speciala"];
		$watermark=($_POST["watermark"]==1)?true:false;
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ACTIUNI
	
	//@adauga produs
	if(isset($_POST["adauga_produs"]))
	{
		$form_submit=1;

		//@validari campuri obligatorii
		$validare=new valideazaProdus();	
		
		$nume_produs_check=$validare->valideazaNumeProdus($nume_produs);	
		$pret_check=$validare->valideazaPret($pret);
		(!empty($pret_vechi))?$pret_vechi_check=$validare->valideazaPret($pret_vechi):"";
		(!empty($cod_produs))?$cod_produs_check=$validare->valideazaCodProdus($cod_produs):"";

		if($validare->getErori()==0)
		{
			$id_produs=arrayInsertToDB("t_produse",
										array("id_cat",
											  "id_prod",
											  "furnizor",
											  "cod_produs",
											  "nume_produs",
											  "pret",
											  "pret_vechi",
											  "descriere_produs",
											  "caracteristici",
											  "data_adaugarii",
											  "stoc",
											  "tip", 
											  "bestseller",
											  "id_admin"),
										array($id_cat,
											  $producator_selectat,
											  $furnizor,
											  $cod_produs,
											  $nume_produs,
											  $pret,
											  $pret_vechi,
											  $descriere_produs,
											  ";".@implode(";", $filtre_selectate).";",
											  time(),
											  $stoc_selectat,
											  $oferta_speciala,
											  0,
											  $_SESSION["admin_id_user"]));									  
			
			//@creez directoarele pt poze
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs, 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/mici", 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/medii", 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/mari", 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/supermari", 0777);
			
			chmod(URL_BASE_ABS."poze_produse/".$id_produs, 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/mici", 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/medii", 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/mari", 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/supermari", 0777);
			
			//@adaugare poza principala
			if(isset($_FILES["poza_principala"]["name"]))
				adaugaPozaPrincipalaProdus("poza_principala", $id_produs, $watermark);
			
			$nr_poze=count($_FILES["poze"]["name"]);
			
			//@adaugare poze secundare
			for($i=0;$i<$nr_poze;$i++)
				adaugaPozaProdus("poze", $id_produs, $i, $watermark);
														  
			//@adaugare fisiere
			if(is_uploaded_file($_FILES["fisier"]["tmp_name"]))
				move_uploaded_file($_FILES["fisier"]["tmp_name"], URL_BASE_ABS."poze_produse/".$id_produs."/".$_FILES["fisier"]["name"]);	
				
			//modul sincronizare				
			if(file_exists(URL_BASE_ABS."admin/module/gsmnet_preturi_disponibilitati_sincronizare.php"))
				require_once(URL_BASE_ABS."admin/module/gsmnet_preturi_disponibilitati_sincronizare.php");	
																		
			//@incrementez nr produse la categoria in care a fost adaugat produsul + toti parintii categoriei	  
			$arbore=new arbore($id_cat, 0, $arr_toate_cat);
			$rows=$arbore->getParintiGasiti();
			
			(!empty($id_cat))?$rows[]=$id_cat:""; //adaug categoria in array pt a incrementa cantitatile dintr-un foc
			(!empty($producator_selectat))?$rows[]=$producator_selectat:""; //adaug producatorul in array pt a incrementa cantitatile dintr-un foc
			
			$nr_rows=count($rows);
			 
			for($i=0;$i<$nr_rows;$i++)
				arrayUpdateToDB("t_categorii", array("nr_produse"), array("nr_produse+1"), array("id"=>"id_cat", "valoare"=>$rows[$i]), true);
				 
			//@curata mesajele de confirmare	  
			$form_submit=0;
			
			$mesaj="Produsul a fost adaugat cu succes!";
			
			//@sterg variabilele folosite	
			unset($producator_selectat, $nume_produs_check, $pret_check, $pret_vechi_check, $descriere_produs, $filtre_selectate, $stoc, $oferta_speciala, $watermark, $cod_produs_check, $furnizor, $stoc_selectat);	
		}
	}
	
	//@editare produs
	if(isset($_POST["modifica_produs"]))
	{
		$form_submit=1;
		
		//@validari campuri obligatorii
		$validare=new valideazaProdus();	
		
		$nume_produs_check=$validare->valideazaNumeProdus($nume_produs, $id_produs);	
		$pret_check=$validare->valideazaPret($pret);
		(!empty($pret_vechi))?$pret_vechi_check=$validare->valideazaPret($pret_vechi):"";
		(!empty($cod_produs))?$cod_produs_check=$validare->valideazaCodProdus($cod_produs, $id_produs):"";

		if($validare->getErori()==0)
		{
			//@creez directoarele pt poze
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs, 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/mici", 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/medii", 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/mari", 0777);
			@mkdir(URL_BASE_ABS."poze_produse/".$id_produs."/supermari", 0777);
			
			chmod(URL_BASE_ABS."poze_produse/".$id_produs, 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/mici", 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/medii", 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/mari", 0777);
			chmod(URL_BASE_ABS."poze_produse/".$id_produs."/supermari", 0777);
			
			$arr_produs_temp=arrayFromDB(array("id_prod"), "t_produse", "WHERE id_produs='".$id_produs."'");
			$producator_vechi=$arr_produs_temp[0]["id_prod"];
			
			//@daca a fost schimba producatorul actualizez nr_produse coresp cu mutarea
			if($producator_vechi!=$producator_selectat)
			{
				if(is_numeric($producator_vechi) && !empty($producator_vechi))
					arrayUpdateToDB("t_categorii", array("nr_produse"), array("nr_produse-1"), array("id"=>"id_cat", "valoare"=>$producator_vechi), true);
					
				if(is_numeric($producator_selectat) && !empty($producator_selectat))	
					arrayUpdateToDB("t_categorii", array("nr_produse"), array("nr_produse+1"), array("id"=>"id_cat", "valoare"=>$producator_selectat), true);
			}
			
			arrayUpdateToDB("t_produse",
							array("id_cat",
								  "id_prod",
								  "furnizor",
								  "cod_produs",
								  "nume_produs",
								  "pret",
								  "pret_vechi",
								  "descriere_produs",
								  "caracteristici",
								  "data_adaugarii",
								  "stoc",
								  "tip",
								  "id_admin"),
							array($id_cat,
								  $producator_selectat,
								  $furnizor,
								  $cod_produs,
								  $nume_produs,
								  $pret,
								  $pret_vechi,
								  $descriere_produs,
								  ";".@implode(";", $filtre_selectate).";",
								  time(),
								  $stoc_selectat,
								  $oferta_speciala,
								  $_SESSION["admin_id_user"]),
							array("id"=>"id_produs", "valoare"=>$id_produs));
												
			//@adaugare poza principala
			if(isset($_FILES["poza_principala"]["name"]))
				adaugaPozaPrincipalaProdus("poza_principala", $id_produs, $watermark);
			
			$nr_poze=count($_FILES["poze"]["name"]);
			
			//@adaugare poze secundare
			for($i=0;$i<$nr_poze;$i++)
				adaugaPozaProdus("poze", $id_produs, $i, $watermark, $nr_ultima_poza);		
			
			//@adaugare fisiere
			if(is_uploaded_file($_FILES["fisier"]["tmp_name"]))
				move_uploaded_file($_FILES["fisier"]["tmp_name"], URL_BASE_ABS."poze_produse/".$id_produs."/".$_FILES["fisier"]["name"]);	
					
			//modul sincronizare				
			if(file_exists(URL_BASE_ABS."admin/module/gsmnet_preturi_disponibilitati_sincronizare.php"))
				require_once(URL_BASE_ABS."admin/module/gsmnet_preturi_disponibilitati_sincronizare.php");	
			
			//@curata mesajele de confirmare	  
			$form_submit=0;	

			//@galerie produs
			$poza_principala=str_replace("/mari/", "/medii/", getPozaPrincipalaMareProdus($id_produs));
			
			$arr_galerie=genereazaGalerie($id_produs, true);
			$poze_sec_medii=$arr_galerie["medii"];
			$poze=$arr_galerie["poze"];
			
			$nr_poze_sec=count($poze_sec_medii);
					
			$mesaj="Produsul a fost modificat cu succes!";	
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------	
	//DETALII PRODUS
	
	//@producatori
	$producatori=arrayFromDBtoCombo("t_categorii", "id_cat", "nume_cat", "WHERE producator='1' ORDER BY nume_cat ASC");
	
	//@caracteristicile produsului
	$gestioneazaFiltre=new gestioneazaFiltre($id_cat);
	$filtre=$gestioneazaFiltre->getFiltre(true);
		
	//@fisiere uploadate
	if(!empty($id_produs) && is_numeric($id_produs) && $id_produs!=0)
	{
		$arr_fisiere_upl=citesteDir(URL_BASE_ABS."poze_produse/".$id_produs."/", true);
		
		//@actualizare nr poze (la fiecare accesare - pt a preveni stergerea manuala de pe ftp a pozelor)
		$nr_poze_produs=count(citesteDir(URL_BASE_ABS."poze_produse/".$id_produs."/mici/"));
		
		arrayUpdateToDB("t_produse", array("nr_poze"), array($nr_poze_produs), array("id"=>"id_produs", "valoare"=>$id_produs));
		
		if(isset($_POST["adauga_produs"]))
			unset($id_produs);
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("id_produs", $id_produs);
	$smarty->assign("id_cat", $id_cat);
	$smarty->assign("nume_cat", $nume_cat);	
	$smarty->assign("producatori", $producatori);
	$smarty->assign("producator_selectat", $producator_selectat);
	$smarty->assign("furnizor", $furnizor);
	$smarty->assign("filtre", $filtre);
	$smarty->assign("filtre_selectate", $filtre_selectate);
	$smarty->assign("stoc_selectat", $stoc_selectat);
	$smarty->assign("descriere_produs", $descriere_produs);
	$smarty->assign("oferta_speciala", $oferta_speciala);
	$smarty->assign("watermark", $watermark);
	$smarty->assign("poza_principala", $poza_principala);
	$smarty->assign("poze_sec_medii", $poze_sec_medii);
	$smarty->assign("poze", $poze);
	$smarty->assign("NR_POZE_DISPONIBILE", NR_POZE-$nr_poze_sec);
	$smarty->assign("fisiere_upl", $arr_fisiere_upl);
	
	//@timestamp pt poze sa nu le ia din cache
	$smarty->assign("timestamp", time());
	
	$smarty->assign("nume_produs_check", $nume_produs_check);
	$smarty->assign("pret_check", $pret_check);
	$smarty->assign("pret_vechi_check", $pret_vechi_check);
	$smarty->assign("cod_produs_check", $cod_produs_check);
	$smarty->assign("form_submit", $form_submit);
	
	$smarty->assign("string", $_GET["string"]);
	
	$smarty->assign("mesaj", $mesaj);
	
	require_once("right.php");
	require_once("bottom.php");
?>