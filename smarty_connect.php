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
	//load Smarty library
	require("smarty_dir/libs/Smarty.class.php");
	
	class smarty_connect extends Smarty 
	{
	   function smarty_connect()
	   {
			global $template;
			
	   		$this->Smarty();
	
			$this->template_dir=URL_BASE_ABS."/".$template;
			$this->config_dir=URL_BASE_ABS."/smarty/config";
			$this->cache_dir=URL_BASE_ABS."/cache";
			$this->compile_dir=URL_BASE_ABS."/templates_c";
			
			$this->debugging=false;
			
			$this->assign("app_name", "Shop GoGo Promotions");
	   }
	}	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@smarty
	$smarty=new smarty_connect();
	$smarty->caching=false;

	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@template folder
	$smarty->assign("DIR_TEMPLATE", DIR_TEMPLATE);	
	//@url base
	$smarty->assign("URL_BASE", URL_BASE."");
	//@poze dir
	$smarty->assign("POZE_DIR", POZE_DIR);		
	//@url producatori
	$smarty->assign("LINK_PRODUCATORI", URL_BASE."producatori");	
	//@url producatori
	$smarty->assign("LINK_TOATE_CAUTARILE", URL_BASE."cautari-magazin-online");
	//@url cont
	$smarty->assign("LINK_CONT", URL_BASE."cont");
	//@url cont nou
	$smarty->assign("LINK_CONT_NOU", URL_BASE."cont-nou");	
	//@url contul meu
	$smarty->assign("LINK_CONTUL_MEU", URL_BASE."contul-meu");
	//@url contul meu
	$smarty->assign("LINK_DATE_CONT", URL_BASE."contul-meu/date-cont");
	//@url cosuri salvate
	$smarty->assign("LINK_COSURI_SALVATE", URL_BASE."contul-meu/cosuri-salvate");
	//@url cosuri salvate
	$smarty->assign("LINK_ISTORIC_TRANZACTII", URL_BASE."contul-meu/istoric-tranzactii");
	//@url formular retur
	$smarty->assign("LINK_FORMULAR_RETUR", URL_BASE."contul-meu/formular-de-retur");
	//@url mergi la casa
	$smarty->assign("LINK_COSUL_MEU", URL_BASE."cosul-meu");
	//@url finalizeaza comanda
	$smarty->assign("LINK_FINALIZEAZA_COMANDA", URL_BASE."finalizeaza-comanda");	
	//@url logout
	$smarty->assign("LINK_LOGOUT", URL_BASE."logout");	
	//@link recuperare parola
	$smarty->assign("LINK_RECUPEREAZA_PAROLA", URL_BASE."recupereaza-parola");
	//@link contact
	$smarty->assign("LINK_CONTACT", URL_BASE."contact");
	//@link despre noi
	$smarty->assign("LINK_DESPRE_NOI", URL_BASE."despre-noi");
	//@link intrebari frecvente
	$smarty->assign("LINK_INTREBARI_FRECVENTE", URL_BASE."intrebari-frecvente");
	//@link termeni
	$smarty->assign("LINK_TERMENI_SI_CONDITII", URL_BASE."termeni-si-conditii");
	//@link toate produsele
	$smarty->assign("LINK_TOATE_PRODUSELE", URL_BASE."toate-produsele");
	//@link oferta excel
	$smarty->assign("LINK_OFERTA_EXCEL", URL_BASE."oferta-excel");
	//@link sitemap
	$smarty->assign("LINK_SITEMAP", URL_BASE."sitemap");
	//@link admin
	$smarty->assign("LINK_ADMIN", URL_ADMIN);
	//@link gestiune stocuri
	$smarty->assign("LINK_GESTIUNE_STOCURI", URL_GESTIUNE_STOCURI);
?>