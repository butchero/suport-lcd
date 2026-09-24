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
	//@vars/urls
	define("COOKIE_NAME", "suport-lcd");
	
	define("BASE_NAME", "/");
	define("URL_BASE", "https://".$_SERVER['HTTP_HOST'].BASE_NAME);
	define("URL_BASE_ABS", $_SERVER['DOCUMENT_ROOT'].BASE_NAME);
	
	define("THUMB_W", "150");
	define("THUMB_H", "150");
	
	define("LARGE_W", "600");
	define("LARGE_H", "600");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@path director admin
	define("URL_ADMIN", URL_BASE."admin/");

	//--------------------------------------------------------------------------------------------------------------------------
	//@dir poze site
	define("POZE_DIR", "img");

	//--------------------------------------------------------------------------------------------------------------------------
	//@path template curent	
	$template="template";
	
	define("DIR_TEMPLATE", URL_BASE.$template."/");
	define("DIR_TEMPLATE_ABS", URL_BASE_ABS.$template."/");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@cale font
	define("TTF_DIR", URL_BASE_ABS."admin/jpgraph/fonts/");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@pattern arbitrar: fac replace in url string la pattern cu pagina - pt clasa de paginare
	define("PATTERN", "--|x|--");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@produs care nu mai e stoc (valoare arbitrare din bd, din tabelul t_stoc)
	define("NU_E_PE_STOC", 6);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@pret cos pentru care transportul e gratuit
	//daca e pus pe 0, limita nu e luata in calcul, in caz contrar ex.: daca TRANSPORT_GRATUIT=90, pt cumparaturile in valoare 90 RON nu se mai plateste transport
	define("TRANSPORT_GRATUIT", 0);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@limita maxima produse cos
	define("LIMITA_COS", 35);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@parola pentru admin -> user (acces din admin in contul utilizatorului)
	define("PAROLA_ADMIN_USER", "");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@cate nivele sa fie afisate in mod default la meniu
	if($_SERVER["PHP_SELF"]=="/index.php")
		$nivele_afisate=1;
	else $nivele_afisate=1;	
	
	define("NIVELE_AFISATE", $nivele_afisate); //0 = pt a afisa doar categoriile principale, 1 = pt afisate categorii + subcategorii, etc...
	
	//--------------------------------------------------------------------------------------------------------------------------				
	//@stare comanda (starile prin care trece o comanda)- atentie nu tb schimbata ordinea din momentul cand magazinul are comenzi
	$stare_comanda=array("asteapta procesare", "in procesare", "onorata", "anulata", "in asteptare");			
				
	//--------------------------------------------------------------------------------------------------------------------------
	//@sort cols catalog produse
	$sort_cols=array("pret"=>"pret", "produs"=>"nume_produs");			
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@tabs catalog produse
	$taburi=array("noutati", "pe-stoc"=>2);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@departamente (pt formularul de contact)
	$arr_departamente=array(0=>array("nume"=>"Comenzi", "email"=>"office@suport-lcd.ro"), 
							1=>array("nume"=>"Suport tehnic", "email"=>"office@suport-lcd.ro"));
							
	//--------------------------------------------------------------------------------------------------------------------------
	//@tipuri mesaje din site
	$arr_tip_mesaje_din_site=array(0=>"Propuneri", 1=>"Contact site");					
							
	//--------------------------------------------------------------------------------------------------------------------------
	//@activare/dezactivare chilipirul zile (toggle afisarea si accesul la admin - ATENTIE! trebuie setat CRONJOB-ul coresp. din /cronjobs/)
	define("CHILIPIR", false);	

	//--------------------------------------------------------------------------------------------------------------------------
	//@activare/dezactivare categorii secundare (facut in special pt. magazinul naturist -> navigarea dupa afectiuni)
	define("CAT_SECUNDARE", false);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@activare/dezactivare preturi in valuta (toggle afisarea si accesul la admin - ATENTIE! trebuie setat CRONJOB-ul coresp. din /cronjobs/)
	define("PRETURI_VALUTA", false);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@manipulare preturi global procentual (incrementare - decrementare cu un procent dat)
	define("MANIPULARE_PRETURI_PROC", true);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@navigare previous-next din detalii produs
	define("NAVIGARE_DIN_DETALII", true);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@curs valutar automat de la BNR sau adaugat manual
	define("CURS_VALUTAR_AUTOMAT", false);
				
	//--------------------------------------------------------------------------------------------------------------------------
	//@luni
	$luni=array("01"=>"Ianuarie",
				"02"=>"Februarie",
				"03"=>"Martie",
				"04"=>"Aprilie",
				"05"=>"Mai",
				"06"=>"Iunie",
				"07"=>"Iulie",
				"08"=>"August",
				"09"=>"Septembrie",
				"10"=>"Octombrie",
				"11"=>"Noiembrie",
				"12"=>"Decembrie");							
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@extensii valide pt upload poze/bannere
	$arr_extensii_valide=array("gif", "jpg", "jpeg", "bmp", "png");	

	//--------------------------------------------------------------------------------------------------------------------------
	//@pagini restrictionate pentru subadmini
	$arr_pagini_restrictionate=array("parametri_site.php",
									 "gestioneaza_transport.php",
									 "stoc_produse.php",
									 "subadmini.php",
									 "log_subadmini.php",
									 "comenzi.php",
									 "editare_texte.php",
									 "gestioneaza_cautari.php",
									 "grupeaza_produse.php",
									 "statistici_vanzari.php",
									 "statistici_vanzari_pe_cat.php",
									 "statistici_vazanri_pe_produs.php",
									 "gestioneaza_liste_discount.php",
									 "newsletter.php",
									 "abonati_newsletter.php",
									 "chilipirul_zilei.php",
									 "tools.php");
									 
	//--------------------------------------------------------------------------------------------------------------------------
	//@judete - judetele pentru care nu exista comanda minima (ATENTIE: textul din "cont_user/cosul_meu.tpl" cu mesajul cu judetele preferentiale nu este dinamic, tb modificat manual)
	$arr_judete_preferentiale=array();								 

	//--------------------------------------------------------------------------------------------------------------------------
	//@date e-payment
	define("SECRET_KEY", "");
	define("MERCHANT_ID", "");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@alfabet
	$arr_alfabet=array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@css style pt emailuri - (ar fi tb si designurile la mailurile puse toate in smarty, dar too late)
	$mail_css_style="<style type='text/css'>
						body, td, p {
							font-family:Verdana;
							font-size:11px;
							color: #6C6C6C;	
						}
							
						a {
							color:#04A2C4;	
						}
									
						a:hover {
							color:#6F6F6F;	
						}
									
						h1 {
							font-family:Arial;
							font-size:12px;
							color:#000000;
							margin:0px;
							padding:0px;  
						}
							
						.margine {
							border:1px solid #F2F2F2;	
						}	
						
						.bg_spatiu {
							background-color:#F2F2F2;
						}
					</style>";
?>