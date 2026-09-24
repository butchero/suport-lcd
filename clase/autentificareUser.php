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
		@Class: autentificareUser			        		 
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	class autentificareUser
	{
		var $erori=0;
		var $username="";
		var $parola="";
		
		function autentificareUser($username, $parola, $sesiune_setata=false)		
		{
			$this->username=$username;
			$this->parola=($sesiune_setata)?$parola:md5(trim($parola));
		}
		
		//@verifica username daca exista in baza de date + conditii		
		function tryAutentificare($remember_me=false)
		{			
			$arr_user=arrayFromDB(array("id_user", "username", "parola", "nume", "prenume"),
								  "t_useri",
								  "WHERE username='".prepareStringToDB($this->username)."' AND parola='".$this->parola."'");
			
			if(count($arr_user)==1)
			{
				$_SESSION["username"]=$this->username;
				$_SESSION["parola"]=$this->parola;
				$_SESSION["id_user"]=$arr_user[0]["id_user"];
				$_SESSION["nume_utilizator"]=$arr_user[0]["nume"]." ".$arr_user[0]["prenume"];
				$_SESSION["id_sesiune"]=session_id();
				
				if($remember_me)
				{
					setcookie(COOKIE_NAME."_cookie", $this->username.PATTERN.$this->parola, time()+60*60*24*COOKIE_USER_LIFETIME);
				}
				
				return array("valid"=>1,
							 "eroare"=>"");
			}
			else
			{
				$this->erori++;
				return array("valid"=>0,
							 "eroare"=>"Username-ul sau parola sunt gresite!");
			}
		}
		
		//@valideaza tot formularul in functie de ce validari s-au facut mai inainte
		function getErori()
		{
			return $this->erori;	
		}
	}
?>