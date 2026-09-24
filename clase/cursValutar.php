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
	/*
		@Class: curs valutar		
		- vars: 
		- metode: cursValutar()
				  extrageCurs()	
		  		  getCurs()		        
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	class cursValutar
	{
		//@constructor - daca cursul nu exista pt data de astazi il preia online
		function cursValutar()
		{		
			if(empty($_SESSION["curs_valutar"]["usd"]) || empty($_SESSION["curs_valutar"]["euro"]))
			{
				if(CURS_VALUTAR_AUTOMAT)
				{
					$arr_curs=arrayFromDB("*", "t_curs_bnr", "WHERE data='".date("Ymd")."'");
					
					if(count($arr_curs)==0)
					{		
						//daca nu exista data curenta in BD iau cursul de pe BNR si il adaug in baza de date
						$valuta=$this->extrageCurs('http://www.bnro.ro/Ro/Info/', '<TD class="bold">');
						
						$usd=str_replace(array(" ", ""), array(",", "."), $valuta["usd"]); 
						$euro=str_replace(array(" ", ""), array(",", "."), $valuta["euro"]);
										
						if(!empty($usd) && !empty($euro))
						{
							$sql_insert="INSERT INTO t_curs_bnr VALUES(
										 '',
										 '".date("Ymd")."',
									 	 '".$usd."',
									 	 '".$euro."')";
							mysql_query($sql_insert);
						}					
					}
				}
				
				$arr_ultimul_curs=arrayFromDB("*", "t_curs_bnr", "ORDER BY id_curs DESC LIMIT 0, 1");
				
				$_SESSION["curs_valutar"]["usd"]=str_replace(",", ".", $arr_ultimul_curs[0]["usd"]);
				$_SESSION["curs_valutar"]["euro"]=str_replace(",", ".", $arr_ultimul_curs[0]["euro"]);
				$_SESSION["curs_valutar"]["data_curs"]=$arr_ultimul_curs[0]["data"];
			}				
		}
		
		//@citeste fisierul de la adresa data, cauta patternul si extrage cursul valutar
		function extrageCurs($path, $pattern)
		{
			$file=@file($path);
			$j=0; 
			$nr_linii=count($file);
			
			for($i=0;$i<$nr_linii;$i++)
			{
				if(strstr($file[$i], $pattern))
				{
					$arr[$j]=substr($file[$i], 18, 6);
					$j++;
				}
			}
			
			return array("euro"=>$arr[0], "usd"=>$arr[1]);
		}
		
		//@get curs curent
		function getCurs()
		{
			return array("usd"=>$_SESSION["curs_valutar"]["usd"],
						 "euro"=>$_SESSION["curs_valutar"]["euro"],
						 "data_curs"=>$_SESSION["curs_valutar"]["data_curs"]);
		}
	}
?>