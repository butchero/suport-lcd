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
		
	class valideazaCategorie extends validariGenerale
	{
		//@valideaza discount
		function valideazaDiscount($discount)
		{
			return array("valid"=>1,
						 "camp"=>preg_replace("/[^0-9.]/", "", str_replace(",", ".", $discount)),
						 "eroare"=>"");
		}
		
		function valideazaDescriere($descriere)
		{
			return array("valid"=>1,
						 "camp"=>$descriere,
						 "eroare"=>"");
		}
		
		//@valideaza limite preturi (filtre dupa pret)
		function valideazaLimitePreturi($limite_preturi)
		{
			if(strpos($limite_preturi, ",")!==false) 
			{
				$limite_preturi_pieces=explode(",", $limite_preturi);
				
				foreach($limite_preturi_pieces as $key=>$value)
				{
					$contor=0;
					
					if(!preg_match("/^(>|<)[0-9]+$/", $value))
						$contor++;
					if(!preg_match("/^[0-9]+-[0-9]+$/", $value))
						$contor++;					
					
					if($contor==2)
					{
						$this->erori++;
						return array("valid"=>0,
									 "camp"=>$limite_preturi,
									 "eroare"=>"Format invalid!");
					}		
				}				
			}
			elseif(!empty($limite_preturi)) 
			{
				$contor=0;
				
				if(!preg_match("/^(>|<)[0-9]+$/", $limite_preturi))
					$contor++;
				if(!preg_match("/^[0-9]+-[0-9]+$/", $limite_preturi))
					$contor++;
					
				if($contor==2)
				{
					$this->erori++;
					return array("valid"=>0,
								 "camp"=>$limite_preturi,
								 "eroare"=>"Format invalid!");
				}
			}
			
			return array("valid"=>1,
						 "camp"=>$limite_preturi,
						 "eroare"=>"");
		}

		function valideazaLinkCat($link_cat, $id_cat="")
		{
			(!empty($id_cat) && is_numeric($id_cat))?$sql_where=" AND id_cat!='".$id_cat."'":"";
			
			$arr_link=arrayFromDB(array("link_cat"), "t_categorii", "WHERE link_cat='".prepareStringToDB($link_cat)."'".$sql_where);
			
			if(count($arr_link)==0)
			{
				return array("valid"=>1,
							 "camp"=>$link_cat,
							 "eroare"=>"");	
			}
			else
			{
				$this->erori++;
				return array("valid"=>0,
							 "camp"=>$arr_link[0]["link_cat"],
							 "eroare"=>"Exista deja o categorie cu acest link!");
			}
		}
		
		//@valideaza tot formularul in functie de ce validari s-au apelat
		function getErori()
		{
			return $this->erori;	
		}
	}
?>