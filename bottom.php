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
	//@ultimele produse vizitate
	if(!isset($_SESSION["link_ultimele_vizite"]) || !is_array($_SESSION["link_ultimele_vizite"]))
	{
		$_SESSION["link_ultimele_vizite"]=array();
		$_SESSION["nume_ultimele_vizite"]=array();
	}
	else 
	{
		if(!empty($link_produs) && !in_array($link_produs, $_SESSION["link_ultimele_vizite"]))
		{
			$_SESSION["link_ultimele_vizite"][]=$link_produs;				
			$_SESSION["nume_ultimele_vizite"][]=$nume_produs;
		}		
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@pagina precedenta daca e diferita de "/cont"
	($_SERVER["REQUEST_URI"]!="/cont")?$_SESSION["pagina_precedenta"]=$_SERVER["REQUEST_URI"]:"";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu pagina	
	if($_SERVER["PHP_SELF"]=="/index.php")
		$titlu_pagina=TITLU_SITE; /*.implodeAssocArray($arr_meniuri, "nume_cat", ", ");*/	
	if(!empty($nume_cat))
		$titlu_pagina=ucfirst(strtolower($nume_cat));
	if(!empty($nume_produs))
		$titlu_pagina=$nume_produs;	
	if(!empty($nume_cat_sec) && CAT_SECUNDARE)
		$titlu_pagina=ucfirst(strtolower($arr_cat_secundara[0]["nume_cat_sec"]));	
		
	(empty($titlu_pagina))?$titlu_pagina=ucfirst(strtolower(TITLU_SITE)):"";	
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@tiganie seo pt a afisa in bottom tree deschis si pe nivelul 1
	if($_SERVER["PHP_SELF"]=="/index.php")
	{
		$categorii_bottom=new arbore(0, 1, $arr_toate_cat);			
		$arr_categorii_bottom=$categorii_bottom->getMeniuri();		
		$smarty->assign("categorii_bottom", $arr_categorii_bottom);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@keywords
	if($_SERVER["PHP_SELF"]=="/catalog.php")
	{
		if($este_producator)
		{
			$string_keywords=strtolower($nume_cat);
		}
		else 
		{
			$keywords[]=strtolower($nume_cat);
			
			if(isset($arr_catalog) && is_array($arr_catalog))
				foreach($arr_catalog as $k=>$v)
					$keywords[]=strtolower($v["nume_cat"]);
				
			$string_keywords=implode(", ", $keywords);		
		}
	}
	elseif($_SERVER["PHP_SELF"]=="/module_secundare/catalog_categorii_secundare.php" && CAT_SECUNDARE)
	{
		$keywords[]=strtolower($arr_cat_secundara[0]["nume_cat_sec"]);
		
		if(is_array($arr_cat_sec_copii))
			foreach($arr_cat_sec_copii as $k=>$v)
				if(strtolower($v["nume_cat_sec"])!=strtolower($arr_cat_secundara[0]["nume_cat_sec"]))
					$keywords[]=strtolower($v["nume_cat_sec"]);
				
		$string_keywords=implode(", ", $keywords);		
	}
	else 
	{
		$keywords=array_unique(explode(" ", strtolower(str_replace(array(",", "-"), array(""), $titlu_pagina))));
		$string_keywords=implode(", ", $keywords);
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@adaugare filtre in titlu
	if(!empty($filtre_memorate))
	{
		$titlu_filtre="";
		
		foreach($filtre_memorate as $value)
		{
			$titlu_filtre[]=$value["valoare_filtru"];
		}
		
		$titlu_filtre=" ".implode(" ", $titlu_filtre);
		
		$titlu_pagina.=$titlu_filtre;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@adaugare ordonare in titlu
	if(!empty($_GET["col"]) && !empty($_GET["sort"]))
		$titlu_pagina.=" - Ordonate dupa ".$_GET["col"]." ".strtoupper($_GET["sort"]);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@titlu toate produsele
	if(isset($_GET["show"]) && $_GET["show"]=="toate_produsele")
	{
		$titlu_pagina="Toate produsele";
		
		$arr_radacina[]=array("nume_radacina"=>"Toate produsele",
							  "link_radacina"=>URL_BASE."toate-produsele");
	}
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@modificare titlu daca pagina este setata pentru a evita duplicate titles/descriptions
	if(isset($_GET["pag"]) && $_GET["pag"]!=1)
		$titlu_pagina.=" pag. ".$_GET["pag"];
		
	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	
	//@ultimele vizite
	$smarty->assign("link_ultimele_vizite", (empty($_SESSION["link_ultimele_vizite"])?"":$_SESSION["link_ultimele_vizite"]));
	$smarty->assign("nume_ultimele_vizite", (empty($_SESSION["nume_ultimele_vizite"])?"":$_SESSION["nume_ultimele_vizite"]));
	
	//@keywords
	$smarty->assign("keywords", $string_keywords);
	
	//@afisare radacina categorii
	if(!isset($arr_radacina) || !is_array($arr_radacina))
		$arr_radacina=array();
	$smarty->assign("radacina", $arr_radacina);
	
	//@titlu pagina -> smarty
	$smarty->assign("titlu_pagina", $titlu_pagina);	
	
	//@nume_firma
	$smarty->assign("NUME_FIRMA", NUME_FIRMA);
	
	//@nume_firma
	$smarty->assign("TELEFON_COMENZI", TELEFON_COMENZI);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@calculare timp executie
	$timp_end=microtime_float();
	$timp_executie_script=$timp_end-$timp_start;
	
	$smarty->assign("timp_exec", number_format($timp_executie_script, 4, ".", ""));
	$smarty->assign("nr_interogari", count($interogari));
	
	/*
	print "<ol>";
	foreach ($interogari as $value)
	{
		print "<li>".$value."</li>";
	}
	print "</ol>";
	*/
	
	//--------------------------------------------------------------------------------------------------------------------------
	//AFISEAZA PAGINA
	$smarty->display($display_page);
?>