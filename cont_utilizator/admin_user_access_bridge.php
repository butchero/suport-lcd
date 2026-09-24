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
	session_name("shop");
	session_start();
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");
		
	//--------------------------------------------------------------------------------------------------------------------------
	//@include-uri functii
	require_once("../functii/f_securitate.php");	
	require_once("../functii/f_bd.php");
	require_once("../functii/f_links.php");
	require_once("../functii/f_generale.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@incarc configurari aditionale
	require_once("../init.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@verificari login admin in contul utilizatorului selectat
	if(strstr($_SERVER["HTTP_REFERER"], URL_BASE."admin/utilizatori.php")!==false && $_GET["parola_admin_user"]==PAROLA_ADMIN_USER && isset($_GET["id_user"]) && is_numeric($_GET["id_user"]) && !empty($_GET["id_user"]))
	{
		$id_user=$_GET["id_user"];
		$arr_user=arrayFromDB("*", "t_useri", "WHERE id_user='".$id_user."'");
		
		if(count($arr_user)==1)
		{
			session_unset();
			
			$_SESSION["username"]=$arr_user[0]["username"];
			$_SESSION["parola"]="none";
			$_SESSION["id_user"]=$id_user;
			$_SESSION["nume_utilizator"]=$arr_user[0]["nume"]." ".$arr_user[0]["prenume"];
			$_SESSION["id_sesiune"]=session_id();
			
			$_SESSION["admin_acces"]=PAROLA_ADMIN_USER;
			
			header("Location:".URL_BASE."contul-meu");			
		}
		else 
		{
			die("Eroare logare cont user!");
		}
	}
?>