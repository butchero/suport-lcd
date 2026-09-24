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
		@Class: valideaza campul e-mail din formularul recuperare parola
		- vars: $erori (este incrementata la fiecare eroare de validare)			
		- functii: valideazaX(...)
				  getErori() (intoarce numarul de erori generate de functiile de validare folosite)	        
		- note: mosteneste clasa validariGenerale			  
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	require_once("validariGenerale.php");
	
	class valideazaRecParola extends validariGenerale
	{		
		function valideazaEmailUser($email)
		{
			$arr_cont=arrayFromDB("*", "t_useri", "WHERE email='".prepareStringToDB($email)."'");
			
			if(count($arr_cont)==1)
			{
				return array("valid"=>1,
							 "camp"=>"",
							 "username"=>$arr_cont[0]["username"]);				
			}
			else
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$email,
							 "eroare"=>"Adresa de e-mail invalida !");
			}				 
		}
	}
?>