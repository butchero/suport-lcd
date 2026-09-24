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
		@Class: valideaza produs
	*/	
	require_once("validariGenerale.php");
		
	class valideazaProdus extends validariGenerale
	{
		//@valideaza numele produsului
		function valideazaNumeProdus($nume_produs, $id_produs=false)
		{
			$nume_produs=trim($nume_produs);
			
			if(empty($nume_produs))
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$nume_produs,
							 "eroare"=>"Numele produsului nu a fost completat!");
			}
			
			$sql_where=($id_produs!==false)?" AND id_produs!='".$id_produs."'":"";
			$arr_produs=arrayFromDB(array("nume_produs"), "t_produse", "WHERE nume_produs='".prepareStringToDB($nume_produs)."'".$sql_where);
					
			if(count($arr_produs)==0)
			{
				return array("valid"=>1,
							 "camp"=>$nume_produs,
							 "eroare"=>"");	
			}
			else
			{			
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$nume_produs,
							 "eroare"=>"Exista deja un produs cu acest nume!");		
			}
		}
		
		//@valideaza pretul produsului
		function valideazaPret($pret)
		{
			$pret=trim(str_replace(",", ".", $pret));
			
			if(!is_numeric($pret))
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$pret,
							 "eroare"=>"Pretul produsului nu este numeric!");
			}
			else 
			{
				return array("valid"=>1,
							 "camp"=>$pret,
							 "eroare"=>"");
			}
		}
		
		//@valideaza cod produs
		function valideazaCodProdus($cod_produs, $id_produs=false)
		{
			$cod_produs=trim($cod_produs);
			
			if(empty($cod_produs))
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$cod_produs,
							 "eroare"=>"Codul produsului nu a fost completat!");
			}
			else 
			{
				return array("valid"=>1,
							 "camp"=>$cod_produs,
							 "eroare"=>"");	
			}
			
		}
		
		//@valideaza tot formularul in functie de ce validari s-au apelat
		function getErori()
		{
			return $this->erori;	
		}
	}
?>