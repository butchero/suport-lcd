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
	session_name("shop");
	session_start();
	
	//@include-uri	
	require_once("conectare.php");	
	require_once("configurare.php");	
	require_once("functii/f_generale.php");
	require_once("clase/cos.php");
	
	if(is_numeric($_GET["id_produs"]) && !empty($_GET["id_produs"]))
	{
		$id=$_GET["id_produs"];
		
		$sql="SELECT nume_produs, pret, descriere_produs FROM t_produse WHERE id_produs='".$id."'";
		$result=$mysqli->query($sql);
		$row=$result->fetch_array();
			
		if($result->num_rows==1)
		{		
			$cos=new Cos();
			$adaugare=$cos->adaugaProdus($id, 1, $row['pret']);
			
			header("Location:".URL_BASE."cosul-meu");
		}
	}
?>	