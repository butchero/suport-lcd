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
	//@filtre preturi
	if(strpos($filtre_preturi, ",")!==false)
	{
		$arr_filtre_preturi=explode(",", $filtre_preturi);
		unset($filtre_preturi);
		
		//@daca utilizatorul este pe pagina 2 de exemplu, se reseteaza pagina la 1
		$url_brut=preg_replace("/\/p([0-9]+)/", "/p1", $_SERVER["REQUEST_URI"]);
				
		if(strpos($url_brut, "?")!=false)
			 $url_prelucrat=preg_replace("/(.*)\?(.*)/", "$1", $url_brut);
			 
		if(empty($tab))
			$tab_prefix="?";	
		else 
		{
			if(strpos($tab, "|")!==false)
			{
				$tab_pieces=explode("|", $tab);				
				
				$tab_prefix=$tab_pieces[0];
				$limita_pret_selectata=$tab_pieces[1];							
			}
			else 
			{
				$tab_prefix=$tab;
			}
		}
		
		$filtre_preturi[]=array("link"=>$url_prelucrat.$tab_prefix,
								"nume"=>"orice pret");
			
		foreach($arr_filtre_preturi as $key=>$value)
		{ 
			$url_sufix=str_replace(array(">", "<"), array("peste-", "sub-"), $value);
			
			$filtre_preturi[]=array("link"=>$url_prelucrat.$tab_prefix."|".$url_sufix,
									"nume"=>str_replace(array(">", "<", "-"), array("> ", "< ", " - "), $value)." ".MONEDA,
									"setat"=>($url_sufix==$limita_pret_selectata)?1:0);
		}
	}
?>