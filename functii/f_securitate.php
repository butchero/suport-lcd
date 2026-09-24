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
	//@curata string: strip toate caracterele in afara de litere, numere si spatiu
	function curataString($string)
	{
		return ereg_replace("[^[:space:]()A-Za-z0-9:.,]", "", $string);
	}
	
	function curataStringPartial($string)
	{
		return ereg_replace("[^[:space:]/-_()A-Za-z0-9]", "", $string);
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@securitate - orice operatie cu baza de date care implica interactiunea utilizatorului (date din formulare) tb trecuta prin aceasta functie
	function prepareStringToDB($string)
	{
	    global $mysqli;
	    
		//stripslashes daca MAGIC QUOTES sunt ON
	    if(get_magic_quotes_gpc()) 
	    {
	        $string=stripslashes($string);
	    }   
	    
	    return $mysqli->real_escape_string($string); //face addslashes la caracterele: \x00, \n, \r, \, ', ", \x1a
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@opusul la prepareStringToDB()
	function prepareStringFromDB($string)
	{
		return stripslashes($string);
	}
	
	//-------------------------------------------------------------------------------------------------------------
	//@curata excesul de spatii albe dintr-un string
	function curataSpatiiAlbe($string)
	{
		return preg_replace("/\s\s+/", " ", $string);
	}
?>