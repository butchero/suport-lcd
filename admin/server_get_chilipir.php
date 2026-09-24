<?
	/*
    *****************************************************************************
	*****************************************************************************
	**                                                                         **
	**          CIUCA VALERIU (BUTCHER) - GOGO PROMOTIONS - 2008       		   **
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
	//@verificare data
	if(!checkdate($_GET["luna"], $_GET["ziua"], $_GET["an"]))
	{
		print "<span class='eroare_text'>Data este invalida!</span>";
		die;
	}
	
	$an=$_GET["an"];
	(strlen($_GET["luna"])==1)?$luna="0".$_GET["luna"]:$luna=$_GET["luna"];
	(strlen($_GET["ziua"])==1)?$zi="0".$_GET["ziua"]:$zi=$_GET["ziua"];
	
	if(isset($_GET["id_produs"]) && is_numeric($_GET["id_produs"]) && !empty($_GET["id_produs"]))
	{
		$id_produs=$_GET["id_produs"];
		$arr_produs=arrayFromDB("*", "t_produse", "WHERE id_produs='".$id_produs."'");
	
		if(count($arr_produs)==1)
		{
			$nume_produs=$arr_produs[0]["nume_produs"];
			$pret=$arr_produs[0]["pret"];
			
			//------------------------------------------------------------------------------------------------------------------
			//@poze produs
			$poza_principala=getPozaPrincipalaProdus($id_produs);
	
			//------------------------------------------------------------------------------------------------------------------		
			//@chilipir verificare
			$arr_chilipir_check1=arrayFromDB("*", "t_chilipirul_zilei", "WHERE id_produs='".$id_produs."'");
			$arr_chilipir_check2=arrayFromDB("*", "t_chilipirul_zilei", "WHERE data_chilipir='".$an.$luna.$zi."'");
			
			if(count($arr_chilipir_check2)==1)	
				$output="<span class='eroare_text'><b>Ziua selectata are deja un \"chilipir\" setat!</b></span>";
			elseif(count($arr_chilipir_check1)==1)
				$output="<span class='eroare_text'><b>Acest produs a fost deja setat \"chilipir\" pentru una din zile!</b></span>";	
			elseif((int)$an.$luna.$zi<=(int)date("Ymd"))
				$output="<span class='eroare_text'><b>Nu poate fi setat un chilipir pentru o zi din trecut sau ziua curenta!</b></span>";		
			else 
			{
				$output="<form action='".URL_ADMIN."chilipirul_zilei.php?calendar_year=".$_GET["an"]."&calendar_month=".$_GET["luna"]."&calendar_Day=".$_GET["ziua"]."&id_produs=".$id_produs."' method='POST'>
							 <table>
								<tr><td><img src='".$poza_principala."'></td><td>".$nume_produs."</td></tr>
								<tr><td></td><td>Pret curent: <input type='text' value='".$pret."' size='12' disabled></td></tr>
								<tr><td></td><td>Pret chilipir: <input type='text' name='pret_chilipir' size='12'></td></tr>
								<tr><td></td><td><input type='submit' name='seteaza_chilipir' value='SETEAZA CHILIPIR' class='buton' style='width:150px'></tr></tr>
							 </table>
						 </form>";
			}
		}
		else 
		{
			$output="<span class='eroare_text'><b>Produsul cu ID-ul ".$id_produs." nu exista!</b></span>";
		}
	}
	else
	{
		$output="ID produs invalid!";
	}
	
	//@afiseaza ouput 
	print $output;
?>