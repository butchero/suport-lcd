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
	//adaptat de la scriptul pe care l-am facut la www.interfinbrok.ro
	//------------------------------------------------------------------------------------
	$tabel="t_curs_bnr";
	$camp="data";
	
	//------------------------------------------------------------------------------------
	//----------------functie care ia cursul BNR (usd, euro)------------------------------
	function getCurs($path, $pattern)
	{
		$file=file($path);
		$j=0; 
		for($i=0;$i<count($file);$i++)
		{
			if(strstr($file[$i], $pattern))
			{
				$arr[$j]=substr($file[$i], 18, 6);
				$j++;
			}
		}
		
		$euro=$arr[0];
		$dolar=$arr[1];	
		return array($dolar,$euro);
	}
	
	//------------------------------------------------------------------------------------
	//---------------functie care verifica existenta unei valori in BD--------------------
	function ifExists($tabel, $camp, $valoare)
	{
		global $mysqli;

		$sql="SELECT * FROM $tabel WHERE $camp='".$valoare."'";
		$resursa=$mysqli->query($sql);
		if($resursa->num_rows==0)
		{
			 return false;
		}
		else 
		{	
			 return true;
		}
	}
	
	//-----------------------------------------------------------------------------------
	require_once(__DIR__."/conectare.php");

	$sql="SELECT * FROM $tabel WHERE data='".date("Ymd")."'";
	$result=$mysqli->query($sql);
	
	if($result->num_rows==0)
	{
		$data_curenta=date("Y").date("m").date("d");
		
		//daca nu exista data curenta in BD iau cursul de pe BNR si il adaug in baza de date
		$valuta=getCurs('http://www.bnro.ro/Ro/Info/','<TD class="bold">');
		
		$dolar=str_replace(" ", "", $valuta[0]); 
		$dolar=str_replace(",", ".", $valuta[0]);
		$euro=str_replace(" ", "", $valuta[1]);
		$euro=str_replace(",", ".", $valuta[1]);
	
		if(!ifExists($tabel, $camp, $data_curenta))
		{
		
			if($dolar=="0" || $dolar=="" || $euro=="0" || $euro=="")
			{
				//nu face nimic daca imi vine cursul null sau egal cu 0
			}
			else
			{
				$sql_insert="INSERT INTO $tabel VALUES(
							 '',
							 '".$data_curenta."',
						 	 '".$dolar."',
						 	 '".$euro."')";
				$mysqli->query($sql_insert);			  
		 	}
		}
		else
		{
			if($dolar=="0" || $dolar=="" || $euro=="0" || $euro=="")
			{
				//same
			}
			else
			{
				$sql_update="UPDATE $tabel SET 
							 usd='".$dolar."',
							 euro='".$euro."'
						 	 WHERE data='".$data_curenta."'";
				$mysqli->query($sql_update);	
			}	
		}
	}
	unset($sql)
?>