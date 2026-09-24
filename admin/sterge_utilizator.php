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
	session_name("admin");
	session_start();
	
	//@include-uri
	require_once("../conectare.php");
	require_once("../configurare.php");	
	require_once("../functii/f_bd.php");
	require_once("../functii/f_admin.php");	
	require_once("../functii/f_catalog.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@basic check
	if(!is_numeric($_GET["id_user"]))
		die("Utilizator invalid!");
	else $id_user=$_GET["id_user"];	
	
	$user_sters="false";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@construiesc link-ul de redirectare
	$url_redirect=URL_ADMIN."utilizatori.php";
	
	//--------------------------------------------------------------------------------------------------------------------------
	//@select datele utilizatorului
	$arr_user=arrayFromDB(array("COUNT(id_comanda) AS nr_comenzi", "t_useri.*"),
						  "t_useri LEFT JOIN t_comenzi ON t_useri.id_user=t_comenzi.id_user",
						  "WHERE t_useri.id_user='".$id_user."' GROUP BY id_user");
	
	if($arr_user[0]["nr_comenzi"]==0)
	{					  
		arrayDeleteFromDB("t_useri", array("id_user"), array($id_user));
		arrayDeleteFromDB("t_comentarii", array("id_user"), array($id_user));
		arrayDeleteFromDB("t_cosuri_salvate", array("id_user"), array($id_user));
		
		removeDir(URL_BASE_ABS."proforme/".md5($arr_user[0]["data_inregistrarii"].$id_user));
		
		$user_sters="true";		
	}
	
	header("Location:".$url_redirect."?user_sters=".$user_sters);
?>