<?	
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2006       		   **
	**                                                                         **
	*****************************************************************************
	*****************************************************************************
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	//@vars
	/*
	$server="localhost";
	$user="root";
	$pass="";
	$db="db_shop";*/
	
	$server="localhost";
	$user="root";
	$pass="";
	$db="suportlcd";
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@conectare db
//	mysql_connect($server, $user, $pass) or die("Eroare conectare la baza de date.");
//	mysql_select_db($db) or die(mysql_error());

    $mysqli=new mysqli($server, $user, $pass, $db) or die("Eroare conectare la baza de date.");

    //@setari limba romana
    $mysqli->query("SET NAMES 'utf8'") or die($mysqli->error);
    $mysqli->query("SET CHARACTER SET 'utf8'") or die($mysqli->error);
    $mysqli->query("SET COLLATION_CONNECTION='utf8_romanian_ci'") or die($mysqli->error);
?>