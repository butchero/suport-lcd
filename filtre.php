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
	//@restul filtrelor
	if(!isset($link_pagina))
		$link_pagina="";
	$link_pagina=strtolower($link_pagina);
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@construiesc link-ul "prefix"
	if(isset($_GET["set_filtru"]) && $_GET["set_filtru"]==1 && !empty($_GET["filtru"]))
		$link_filtru=$link_pagina."/filtru/".$_GET["filtru"];	
	else 
		$link_filtru=$link_pagina."/filtru/";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@functie care genereaza valorile unui filtru dat + linkuri
	function citesteValoriFiltru($arr, $doLinks=false, $id_filtru="", $nume_filtru="")
	{
		if(empty($arr))
			return "";

		if($doLinks)
		{
			global $link_filtru;	
			$nume_filtru=prepareLinkFiltre($nume_filtru);
		}
				
		$bucati=explode(";", $arr);
		$j=0;
		$nr_bucati=count($bucati);
		$arr_temp=array();
		
		for($i=0;$i<$nr_bucati;$i++)
		{
			if(!empty($bucati[$i]))
			{
				if($doLinks)
				{					
					//replace la filtru curent fid cu alta valoare
					$link_replace_filtru=preg_replace("/fid".$id_filtru.",.*?-vid[0-9]+/", "fid".$id_filtru.",".prepareLinkFiltre($bucati[$i])."-vid".$j, $link_filtru);
					
					//daca nu se face nici un replace inseamna ca fid selectat e nou si se concateneaza filtrul
					if(strpos($link_filtru,"fid".$id_filtru)===false && $link_replace_filtru==$link_filtru)
						$arr_temp[]=$link_filtru.((isset($_GET["filtru"]))?"--":"").$nume_filtru."-fid".$id_filtru.",".prepareLinkFiltre($bucati[$i])."-vid".$j;
					else $arr_temp[]=$link_replace_filtru;	
				}
				else $arr_temp[]=$bucati[$i];
				$j++;
			}
		}
		
		return $arr_temp;
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@manipulare filtru care vine prin $_GET	
	if(isset($_GET["filtru"]) && !empty($_GET["filtru"]))
	{
		$arr_filtru_memorat=explode("--", $_GET["filtru"]);
		$nr_filtre_memorate=count($arr_filtru_memorat);
		
		for($i=0;$i<$nr_filtre_memorate;$i++)
		{			
			//@link stergere link
			$link_stergere_filtru=str_replace($arr_filtru_memorat[$i], "", $link_filtru);
			
			//@prelucrari 
			if(substr($link_stergere_filtru, -2)=="--")
				$link_stergere_filtru=substr($link_stergere_filtru, 0, strlen($link_stergere_filtru)-2);
			if(strpos($link_stergere_filtru, "/filtru/--")!==false)
				$link_stergere_filtru=str_replace("/filtru/--", "/filtru/", $link_stergere_filtru);
			if(substr($link_stergere_filtru, -8)=="/filtru/")
				$link_stergere_filtru=str_replace("/filtru/", "", $link_stergere_filtru);	
							
			$link_stergere_filtru=str_replace("----", "--", $link_stergere_filtru);	
			
			//@reconstruire filtru pentru a afisa filtrarea efectuata	
			preg_match("/(.*)?-fid([0-9]+),(.*)?-vid([0-9]+)/", $arr_filtru_memorat[$i], $matches);

			$arr_id_filtre[]=$matches[2];
			$arr_pozitie_valoare[]=$matches[4];	
			$arr_link_stergere[]=$link_stergere_filtru;
		}		
	}
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@generez array cu filtre + valori posibile + linkuri
	if(isset($id_cat) && !empty($id_cat) && is_numeric($id_cat))
	{
		$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat=".$id_cat." ORDER BY id_filtru ASC"); 
		$nr_filtre=count($arr_filtre);
		
		for($i=0;$i<$nr_filtre;$i++)
		{
			
			if($arr_filtre[$i]["afiseaza_filtru"]==1)
			{
				$filtre[]=array("id_filtru"=>$arr_filtre[$i]["id_filtru"],
								"nume_filtru"=>$arr_filtre[$i]["nume_filtru"],
								"valori_posibile"=>citesteValoriFiltru($arr_filtre[$i]["valori_posibile"]),
								"link_valori_posibile"=>citesteValoriFiltru($arr_filtre[$i]["valori_posibile"],
								  											true, 
								  											$arr_filtre[$i]["id_filtru"],
								  											$arr_filtre[$i]["nume_filtru"]));
			}
								  																				  														
			if(!isset($arr_id_filtre) || !is_array($arr_id_filtre))
				continue;
				
			if(in_array($arr_filtre[$i]["id_filtru"], $arr_id_filtre))	
			{			  											  	  							  											  
				$flip=array_flip($arr_id_filtre);
				$index_filtru=$flip[$arr_filtre[$i]["id_filtru"]];
				
				$arr_valori_filtru=explode(";", $arr_filtre[$i]["valori_posibile"]);
				
				for($j=1;$j<count($arr_valori_filtru)-1;$j++)
				{	
					if($j==$arr_pozitie_valoare[$index_filtru]+1)
					{
						$filtre_memorate[]=array("nume_filtru"=>$arr_filtre[$i]["nume_filtru"],
												 "valoare_filtru"=>$arr_valori_filtru[$j],
												 "link_filtru"=>$arr_link_stergere[$index_filtru]);
						
						$pattern_cautare[]=$arr_valori_filtru[$j];
					}
				}
			}
			else 
			{
				$pattern_cautare[]="%";
			}
		}	
		
		if(isset($_GET["filtru"]) && !empty($_GET["filtru"]))
			$caracteristici_filtrari=" AND caracteristici LIKE ';".implode(";", $pattern_cautare).";' ";
	}
	
	//@sterge toate filtrele
	if(isset($_GET["prod"]) && !empty($_GET["prod"]))
		$filtre_stergere=str_replace("/".$_GET["prod"], "", $link_pagina);		
	else 
		$filtre_stergere=$link_pagina;
?>