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
		
	//--------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page))
	$display_page="toate_cautarile.tpl";
	
	$titlu_pagina="TOATE CAUTARILE";
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@litera selectata
	if(isset($_GET["litera"]))
	{
		$sql_where.="WHERE cautare LIKE '".$_GET["litera"]."%'";
		$link_paginare=URL_BASE."cautari-".$_GET["litera"]."/p".PATTERN;
		
		$titlu_pagina.=" INCEPAND CU LITERA ".$_GET["litera"];
	}
	else 
	{
		$link_paginare=URL_BASE."cautari-magazin-online/p".PATTERN;
	}
	
	//@navigare cautari dupa alfabet
	foreach($arr_alfabet as $key=>$value)
		$alfabet[]=array("link"=>URL_BASE."cautari-".$value, "titlu"=>$value);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@paginare
	require_once("clase/paginare.php");
	$paginare=new paginare("pag",
						   "SELECT COUNT(id_cautare) AS nr FROM t_cautari ".$sql_where,
						   $link_paginare,
						   150);
	$paginare_string=$paginare->doPaginare();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//CAUTARI					   				   
	$arr_toate_cautarile=arrayFromDB("*", "t_cautari", $sql_where." ORDER BY contor DESC LIMIT ".$paginare->getLimitStart().", 150");						   
	$nr_cautari=count($arr_toate_cautarile);
	
	
	for($i=0;$i<$nr_cautari;$i++)
	{
		$toate_cautarile[$i]=array("cautare"=>$arr_toate_cautarile[$i]["cautare"],
								   "contor"=>$arr_toate_cautarile[$i]["contor"],
								   "link_cautare"=>URL_BASE."cautare/".prepareLink($arr_toate_cautarile[$i]["cautare"]));
	}

	//--------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	$smarty->assign("alfabet", $alfabet);	
	$smarty->assign("litera_selectata", $_GET["litera"]);
	$smarty->assign("toate_cautarile", $toate_cautarile);
	$smarty->assign("paginare", $paginare_string);
	
	require_once("right.php");
	require_once("bottom.php");
?>