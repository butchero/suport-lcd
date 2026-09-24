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
		@Class: autentificareAdmin		        		 
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	class autentificareAdmin
	{
		var $erori=0;
		var $username="";
		var $parola="";
		var $sesiune_setata=false;
		
		function autentificareAdmin($username, $parola, $sesiune_setata=false)		
		{
			$this->sesiune_setata=$sesiune_setata;						
			$this->username=$username;
			$this->parola=($sesiune_setata)?$parola:md5(trim($parola));
		}
		
		//@verifica username daca exista in baza de date + conditii		
		function tryAutentificare($remember_me=false)
		{			
			$arr_admin=arrayFromDB(array("id_admin", "username", "parola", "super_admin", "ultima_logare"),
								   "t_admin",
								   "WHERE username='".prepareStringToDB($this->username)."' AND parola='".$this->parola."'");
			
			if(count($arr_admin)==1)
			{
				$_SESSION["admin_username"]=$this->username;
				$_SESSION["admin_parola"]=$this->parola;
				
				$_SESSION["admin_id_user"]=$arr_admin[0]["id_admin"];
				$_SESSION["admin_super_admin"]=$arr_admin[0]["super_admin"];
				$_SESSION["admin_ultima_logare"]=date("d.m.Y h:i", $arr_admin[0]["ultima_logare"]);
				
				$_SESSION["admin_id_sesiune"]=session_id();
				
				if($remember_me)
				{
					setcookie(COOKIE_NAME."_cookie_admin", $this->username.PATTERN.$this->parola, time()+60*60*24*COOKIE_USER_LIFETIME);
				}
				
				if(!$this->sesiune_setata) //inseamna ca verificarea la login se face prin form
				{
					//@loghez data logarii
					arrayUpdateToDB("t_admin", array("ultima_logare"), array(time()), array("id"=>id_admin, "valoare"=>$arr_admin[0]["id_admin"]));
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
		
		//@valideaza tot formularul in functie de ce validari s-au apelat
		function getErori()
		{
			return $this->erori;	
		}
	}
?>