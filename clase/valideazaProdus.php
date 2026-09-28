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
		
		//@valideaza durata garantiei si eligibilitatea GARAN
		function valideazaGarantie($warranty_months, $garan_eligible, $id_producator, $cod_produs)
		{
			$warranty_months=trim($warranty_months);
			$garan_eligible=($garan_eligible==1 || $garan_eligible==="1")?1:0;

			if($warranty_months==="" || preg_match("/^[0-9]+$/", $warranty_months)==0)
			{
				$this->erori++;
				return array("warranty"=>array("valid"=>0,
											   "camp"=>$warranty_months,
											   "eroare"=>"Durata garantiei trebuie sa fie un numar intreg de luni."),
							 "eligible"=>$garan_eligible);
			}

			$luni=(int)$warranty_months;
			$eroare="";

			if($garan_eligible==1)
			{
				if($luni<=24)
					$eroare="GARAN poate fi activat doar daca garantia este mai mare de 24 luni.";
				elseif($luni%6!=0)
					$eroare="Pentru eticheta GARAN durata trebuie sa fie un numar intreg de ani sau de jumatati de an.";
				elseif(!is_numeric($id_producator) || (int)$id_producator<=0)
					$eroare="Pentru eticheta GARAN trebuie sa existe producator.";
				elseif(trim($cod_produs)==="")
					$eroare="Pentru eticheta GARAN trebuie sa existe codul/modelul produsului.";
			}

			if($eroare!="")
				$this->erori++;

			return array("warranty"=>array("valid"=>($eroare==="")?1:0,
										   "camp"=>$luni,
										   "eroare"=>$eroare),
						 "eligible"=>$garan_eligible);
		}
		
		//@valideaza tot formularul in functie de ce validari s-au apelat
		function getErori()
		{
			return $this->erori;	
		}
	}
?>