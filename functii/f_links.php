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
	//-------------------------------------------------------------------------------------------------------------
	//@pregateste link-ul \
	function prepareLink($string, $substract=false) 
	{ 	
		$arr_bad_chars=array("\"", "'", "%", "\\", "?", "/", ".", "_", " ", ";", ":", "]", "[", "=", "!", "#", "+", "$", "&", "*", "^", ")", "(", "@", "~", "`", "<", ">", "{", "}");
		
		$string=strtolower(strip_tags($string));
		$string=str_replace($arr_bad_chars, "-", $string);
		$string=str_replace("--", "-", $string);
		
		if(strpos($string, "--")===false) // elimin "--" din string pana cand toate cuvintele raman despartite de o singura "-"
			return $string;
		else 
			return prepareLink($string);	
	} 
	
	//@pregateste link pentru filtre
	function prepareLinkFiltre($string, $substract=false) 
	{ 	
		$arr_bad_chars=array("\"", "'", "%", "\\", "?", "/", "_", " ", ";",  "]", "[", "=", "!", "#");
		
		$string=strtolower(strip_tags($string));
		$string=str_replace($arr_bad_chars, "-", $string);
		$string=str_replace("--", "-", $string);
		
		if(strpos($string, "--")===false) // elimin "--" din string pana cand toate cuvintele raman despartite de o singura "-"
			return $string;
		else 
			return prepareLink($string);	
	} 
	
	//-------------------------------------------------------------------------------------------------------------
	//@inlocuieste "-" cu " "
	function read_Link($string, $lower=true)//atentie a nu se confunda cu functia php "readLink" care nu are nici o leg cu functia asta
	{
		($lower)?$string=strtolower($string):"";
		
		return str_replace(array("-"), array(" "), $string);
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@link produs
	function getLinkProdus($link_cat, $nume_produs, $id_produs)
	{
		return URL_BASE.strtolower($link_cat)."/".prepareLink(stringLimit($nume_produs, 60))."-prod".$id_produs;
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@link cat sec
	function getLinkCatSec($link_cat)
	{
		return URL_BASE.strtolower($link_cat)."--s";
	}
?>