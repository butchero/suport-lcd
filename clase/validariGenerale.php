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
		@Class: valideaza campurile generale: email, camp completat, cod verificare
		- vars: $erori (este incrementata la fiecare eroare de validare)			
		- functii: verificaEmail($email) - (intoace valoare booleana)
				   valideazaEmail($email) - verifica daca emailul este in format corect (intoarce un array cu erori si mesaje)
				   valideazaCamp($camp) - verifica daca un camp este completat (intoarce un array cu erori si mesaje)
				   valideazaCodVerificare($cod_introdus, $cod_verificare) - compara codurile de verificare (intoarce un array cu erori si mesaje)
				   getErori() (intoarce int - numarul de erori generate de functiile de validare folosite; 0 = formular validat)	        
				  
	*/	
	class validariGenerale
	{
		var $erori=0;
		
		function verificaEmail($email="")
		{
			if(@ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$", $email))
				return true;
			else return false;	
		}
		
		//@validare e-mail
		function valideazaEmail($email)
		{
			if(!$this->verificaEmail($email))
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$email,
							 "eroare"=>"Emailul nu este valid!");	
			}	
			else 
			{			
				return array("valid"=>1,
							 "camp"=>$email,
							 "eroare"=>"");
			}
		}
		
		//@verifica un camp oarecare daca este completat
		function valideazaCamp($camp, $nume_camp, $limita_max_caractere=0)
		{
			$camp=trim($camp);
			
			if(empty($camp))
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$camp,
							 "eroare"=>"Nu ati completat campul ".$nume_camp."!");
			}
			elseif(is_numeric($limita_max_caractere) && $limita_max_caractere>0 && strlen($camp)>$limita_max_caractere)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$camp,
							 "eroare"=>"Lungimea maxima este <b>".$limita_max_caractere."</b>");
			}
			elseif(strpos($camp, "\"")!=false)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>str_replace('\"', '', $camp),
							 "eroare"=>"Campul ".prepareStringFromDB($camp)." contine caracterul interzis <b>\"</b>!");
			}
			elseif(strpos($camp, "\'")!=false)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>str_replace("\'", "", $camp),
							 "eroare"=>"Campul ".prepareStringFromDB($camp)." contine caracterul interzis <b>'</b>!");
			}
			else
			{
				return array("valid"=>1,
							 "camp"=>$camp);
			}
		}
		
		//@verifica cod verificare
		function valideazaCodVerificare($cod_introdus, $cod_verificare)
		{
			if(strtolower($cod_introdus)==strtolower($cod_verificare))
			{
				return array("valid"=>1,
							 "camp"=>$cod_introdus);
			}
			else
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$cod_introdus,
							 "eroare"=>"Codul introdus este diferit de codul de verificare!");			 
			}
		}
		
		function valideazaTelefon($telefon)
		{
			$telefon=str_replace(array(".", "-"), array("", ""), trim($telefon));
			if(is_numeric($telefon) && strlen($telefon)==10)
			{
				return array("valid"=>1,
							 "camp"=>$telefon);
			}
			else 
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$telefon,
							 "eroare"=>"Telefonul trebuie sa fie numeric cu 10 cifre!");
			}
		}
		
		//@valideaza tot formularul in functie de ce validari s-au apelat
		function getErori()
		{
			return $this->erori;	
		}
	}
?>