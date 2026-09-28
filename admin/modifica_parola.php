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

	//---------------------------------------------------------------------------------------------------------------------------------
	//@autorizare user logat
	require_once("autentificare.php");

	//---------------------------------------------------------------------------------------------------------------------------------
	//template-ul care va fi folosit de smarty - variabila e folosita in bottom.php ($smarty->display($display_page);)
	$display_page="admin/modifica_parola.tpl";

	//---------------------------------------------------------------------------------------------------------------------------------
	//@actiune modificare parola user
	if(isset($_POST["modifica_parola"]) || isset($_POST["parola_noua"]))
	{
		if(empty($_POST["parola_noua"]) || strlen(trim($_POST["parola_noua"]))<6)
		{
			$mesaj="Parola trebuie sa aiba minim 6 caractere!";			
		}
		else 
		{
			$parola_noua=md5(trim($_POST["parola_noua"]));
			
			arrayUpdateToDB("t_admin", array("parola"), array($parola_noua), array("id"=>"id_admin", "valoare"=>$_SESSION["admin_id_user"]));
			
			//@setez noua parola in sesiune
			$_SESSION["admin_parola"]=$parola_noua;
			
			$mesaj="Parola a fost schimbata cu succes!";
		}
	}

	//---------------------------------------------------------------------------------------------------------------------------------
	//ASIGNARE VARIABILE PHP->SMARTY
	if(!isset($mesaj)) $mesaj="";
	$smarty->assign("mesaj", $mesaj);

	require_once("right.php");
	require_once("bottom.php");
?>