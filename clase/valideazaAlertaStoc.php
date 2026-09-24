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
	
	class valideazaAlertaStoc extends validariGenerale
	{
		//@verific daca mai exista o alerta setata pt produsul dat
		function verificaAlerta($id_produs, $adresa_email, $id_stoc)
		{
			global $taburi;
			
			if($id_stoc==2)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>"",
							 "eroare"=>"Produsul este deja pe stoc!");
			}
			
			$arr_check=arrayFromDB(array("id_alerta"),
								   "t_alerte_stoc AS a LEFT JOIN t_produse AS b ON a.id_produs=b.id_produs",
								   "WHERE a.id_produs='".prepareStringToDB($id_produs)."' AND a.adresa_email='".prepareStringToDB($adresa_email)."'");
			
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
							 "eroare"=>"Aveti deja o alerta setata pe aceasta produs!");			 
			}
		}
	}
?>