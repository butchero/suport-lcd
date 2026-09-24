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
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("functii/f_bd.php");
		
	//@selectez parametrii site-ului din "t_config"
	$arr_config=arrayFromDB(array("nume_param", "val_param"), "t_config");
	
	foreach($arr_config as $key=>$value)
		$config[$value["nume_param"]]=$value["val_param"];
	
	define("TELEFON_COMENZI", $config["telefon_comenzi"]);
	define("MONEDA", $config["moneda"]);
	define("ZILE_LIMIT", $config["zile_limit"]);	
	define("RATING_MAX", $config["rating_max"]);
	define("DATA_FORMAT", $config["data_format"]);
	define("AFISARI_PE_PAG", $config["afisari_pe_pag"]);
	define("AFISARI_TOP_CAUTARI", $config["afisari_top_cautari"]);
	define("AFISARI_BESTSELLER", $config["afisari_bestseller"]);
	define("AFISARI_ULTIMELE_VANZARI", $config["afisari_ultimele_vanzari"]);
	define("AFISARI_ULTIMELE_PRODUSE_ADAUGATE", $config["afisari_ultimele_produse_adaugate"]);
	define("AFISARI_OFERTE_SPECIALE", $config["afisari_oferte_speciale"]);
	define("COMENTARII_PRODUS_PE_PAG", $config["comentarii_produs_pe_pag"]);
	define("TVA", ($config["tva"]+100)/100);
	define("TVA_NEPRELUCRAT", $config["tva"]/100);
	define("COMANDA_MINIMA", $config["comanda_minima"]);
	define("COOKIE_USER_LIFETIME", $config["cookie_user_lifetime"]);
	define("NUME_DOMENIU_SITE", $config["nume_domeniu_site"]);
	define("TITLU_SITE", $config["titlu_site"]);
	define("NR_PRODUSE_DE_COMPARAT", $config["nr_produse_de_comparat"]);
	define("NR_POZE", $config["nr_poze"]);
	
	//@date firma (pt proforma pdf, etc)
	define("NUME_FIRMA", $config["nume_firma"]);
	define("NR_REG_COMERT", $config["nr_reg_comert"]);
	define("COD_FISCAL", $config["cod_fiscal"]);
	define("SEDIUL", $config["sediul"]);
	define("JUDETUL", $config["judetul"]);
	define("CONT", $config["cont"]);
	define("BANCA", $config["banca"]);
?>