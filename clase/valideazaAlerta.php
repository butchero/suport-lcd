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
		@Class: valideaza campurile din formularul de setare alerta pret produs
		- vars: $erori (este incrementata la fiecare eroare de validare)			
		- functii: valideazaX(...)
				  getErori() (intoarce numarul de erori generate de functiile de validare folosite)	        
		- note: mosteneste clasa validariGenerale			  
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	require_once("validariGenerale.php");
	
	class valideazaAlerta extends validariGenerale
	{
		//@validare prag alerta
		function valideazaPragAlerta($alerta_prag, $pret_curent)
		{			
			if(!is_numeric($alerta_prag))
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$alerta_prag,
							 "eroare"=>"Pretul dorit nu este numeric !");
			}
			elseif($alerta_prag > $pret_curent)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$alerta_prag,
							 "eroare"=>"Pretul dorit e deja mai mic decat pretul produsului !");
			}
			else
			{
				return array("valid"=>1,
							 "camp"=>$alerta_prag);
			}
		}

		//@verific daca mai exista o alerta setata pt produsul dat
		function verificaAlerta($id_produs, $adresa_email)
		{
			$arr_check=arrayFromDB(array("id_alerta"),
								  "t_alerte",
								  "WHERE id_produs='".prepareStringToDB($id_produs)."' AND adresa_email='".prepareStringToDB($adresa_email)."'");
			
			if(count($arr_check)==0)
			{
				return array("valid"=>1,
							 "camp"=>"");
			}
			else
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>"",
							 "eroare"=>"Aveti deja o alerta setata pe aceasta produs !");			 
			}
		}
	}
?>