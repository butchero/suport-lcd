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
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@afisare radacina categorii
	$smarty->assign("radacina", $arr_radacina);
	
	//@titlu pagina -> smarty
	$smarty->assign("titlu_pagina", $titlu_pagina);	
	
	//@link inapoi catre catalog pt paginile care deriva din el (gestioneaza produse, filtre, adaugari, editari, etc)
	$smarty->assign("link_inapoi", $_SESSION["link_inapoi"]);
	
	//@nume_firma
	$smarty->assign("NUME_FIRMA", NUME_FIRMA);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@calculare timp executie
	$timp_end=microtime_float();
	$timp_executie_script=$timp_end-$timp_start;
	
	$smarty->assign("timp_exec", number_format($timp_executie_script,4,".",""));
	
	//--------------------------------------------------------------------------------------------------------------------------
	//AFISEAZA PAGINA
	$smarty->display($display_page);
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@sfarsit page compress
	if($do_gzip_compress)
	{
		$gzip_contents = ob_get_contents();
		ob_end_clean();

		$gzip_size = strlen($gzip_contents);
		$gzip_crc = crc32($gzip_contents);
	
		$gzip_contents = gzcompress($gzip_contents, 9);
		$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);
	
		echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
		echo $gzip_contents;
		echo pack('V', $gzip_crc);
		echo pack('V', $gzip_size);
	}	
?>