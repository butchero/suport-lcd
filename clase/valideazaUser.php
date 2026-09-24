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
		@Class: valideaza campurile din formularul de creare cont nou
		- vars: $erori (este incrementata la fiecare eroare de validare)			
		- functii: valideazaX(...) 
				  getErori() (intoarce numarul de erori generate de functiile de validare folosite)	        
		- note: mosteneste clasa validariGenerale			  
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	require_once("validariGenerale.php");
	
	class valideazaUser extends validariGenerale
	{
		//@verifica username daca exista in baza de date + conditii
		function valideazaUserName($username)
		{
			$username=trim($username);
			if(empty($username) or strlen($username)<3)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$username,
							 "eroare"=>"Numele utilizatorului trebuie sa aiba minim 3 caractere!");
			}
			
			$arr_user=arrayFromDB(array("id_user"), "t_useri", "WHERE username='".prepareStringToDB($username)."'");
			
			if(count($arr_user)==0)
			{
				return array("valid"=>1,
							 "camp"=>$username,);	
			}
			else
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$username,
							 "eroare"=>"Exista deja un utilizator cu acest nume!");		
			}
		}
		
		//@compara parola cu parola verificare + conditii
		function valideazaParola($parola, $parola_verificare)
		{
			$parola=trim($parola);
			if(strlen($parola)<6)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$parola,
							 "eroare"=>"Parola trebuie sa aiba minim 6 caractere!");				
			}
			elseif($parola!=$parola_verificare)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$parola,
							 "eroare"=>"Parola este diferita de parola verificare!");
			}
			else return array("valid"=>1,
							  "camp"=>$parola);	
		}
		
		//@verifica cnp
		function valideazaCNP($cnp)
		{
			if(!is_numeric($cnp) || strlen($cnp)<13)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$cnp,
							 "eroare"=>"CNP invalid!");
			}
			else 
			{
				return array("valid"=>1,
							 "camp"=>$cnp);
			}
		}
		
		//@validare e-mail
		function valideazaEmail($email, $email_verificare)
		{
			if(!$this->verificaEmail($email))
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$email,
							 "eroare"=>"Emailul nu este valid!");	
			}				
			elseif($email!=$email_verificare)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$email,
							 "eroare"=>"Emailul este diferit de emailul verificare!");		
			}
			else 
			{
				$arr_email=arrayFromDB(array("id_user"), "t_useri", "WHERE email='".prepareStringToDB($email)."'".((isset($_SESSION["id_user"]))?" AND id_user!=".$_SESSION["id_user"]:""));
				if(count($arr_email)==0)
				{
					return array("valid"=>1,
								 "camp"=>$email);
				}
				else
				{
					$this->erori++;
					return array("valid"=>0,
								 "camp"=>$email,
								 "eroare"=>"Aceasta adresa de email este deja folosita!");
				}
			}
		}
		
		//@validare cod postal
		function valideazaCodPostal($cod_postal)
		{
			if(is_numeric($cod_postal) && strlen($cod_postal)==6)
			{
				return array("valid"=>1,
							 "camp"=>$cod_postal);
			}
			else 
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$cod_postal,
							 "eroare"=>"Codul postal nu este valid!");
			}
		}
		
		//@valideaza judet
		function valideazaJudet($judet)
		{
			if(!is_numeric($judet) || $judet==0)
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$judet,
							 "eroare"=>"Nu ati ales judetul!");
			}
			
			$arr_judet=arrayFromDB(array("id_jud"), "t_judete", "WHERE id_jud='".prepareStringToDB($judet)."'");
			
			if(count($arr_judet)==1)
			{
				return array("valid"=>1,
							 "camp"=>$judet);
			}
		}

		//@valideaza termeni si conditii
		function valideazaTermeniConditii($termeni_conditii)
		{
			if($termeni_conditii==1)
			{
				return array("valid"=>1,
							 "camp"=>$termeni_conditii,
							 "eroare"=>"");
			}
			else 
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$termeni_conditii,
							 "eroare"=>"Trebuie sa fiti de acord cu termenii si conditiile de utilizare!");
			}
		}
	}
?>