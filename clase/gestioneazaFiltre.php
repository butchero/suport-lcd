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
		@Class: gestioneazaFiltre		        		 
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	class gestioneazaFiltre
	{
		var $id_cat;
		var $mesaj=array();
		
		//@constructorul clasei
		function gestioneazaFiltre($id_cat="")		
		{
			$this->id_cat=$id_cat;
		}
		
		//@adauga un filtru nou cu toate valorile aferente
		function adaugaFiltru($nume_filtru, $este_filtru, $valori)
		{
			$nume_filtru=trim(curataString($nume_filtru));
			
			foreach($valori as $key=>$value)
				$tmp[$key]=trim(curataString($value));
				
			$valori=$tmp;
					
			if(empty($nume_filtru))
			{
				$this->mesaj[]="Numele caracteristicii(filtrului) nu poate fi nul!";
				return;
			}
			if(empty($valori))
			{
				$this->mesaj[]="Caracteristica(filtrul) trebuie sa aiba cel putin o valoare nenula!";
				return;
			}
			
			$valori_string=";".implode(";", $valori).";";
			
			arrayInsertToDB("t_filtre",
							 array("id_cat", "nume_filtru", "valori_posibile", "afiseaza_filtru"),
							 array($this->id_cat, $nume_filtru, $valori_string, $este_filtru));

			$arr_produs=arrayFromDB(array("caracteristici"), "t_produse", "WHERE id_cat='".$this->id_cat."' LIMIT 0, 1");
			
			if($arr_produs[0]["caracteristici"]=="")
			{
				$update_val=";-;";
				$strip=false;
			}
			else
			{
				$update_val="CONCAT(caracteristici, '-;')";
				$strip=true;
			}
							 	 
			arrayUpdateToDB("t_produse",
							 array("caracteristici"), array($update_val),
							 array("id"=>"id_cat", "valoare"=>$this->id_cat),
							 $strip);
							 
			$this->mesaj[]="Filtrul \"".$nume_filtru."\" a fost adaugat cu succes!";				 
		}
		
		//@modifica numele filtrului si seteaza afiseaza filtru pe on/off
		function modificaFiltru($nume_filtru_nou, $id_filtru, $afiseaza_filtru)
		{
			$nume_filtru_nou=trim(curataString($nume_filtru_nou));
			
			arrayUpdateToDB("t_filtre", 
							 array("nume_filtru", "afiseaza_filtru"), array($nume_filtru_nou, $afiseaza_filtru),
							 array("id"=>"id_filtru", "valoare"=>$id_filtru));
						 
			$this->mesaj[]="Numele caracteristicii a fost modificat cu succes!";
			
			if($afiseaza_filtru==1)
				$this->mesaj[]="Caracteristica \"".$nume_filtru_nou."\" a fost setata ca filtru!";
			else $this->mesaj[]="Caracteristica \"".$nume_filtru_nou."\" a fost scoasa din filtru!";
		}
		
		//@modifica valoarea unui filtru dat
		function modificaValoare($valoare_noua, $id_filtru, $id_val, $sterge_valoare=false)
		{			
			//@valoarea cu care se face replace in filtru
			$valoare_noua=trim(curataString($valoare_noua));
						
			if($valoare_noua=="" && $sterge_valoare==false)
			{
				$this->mesaj[]="Valoarea unei caracteristici nu poate fi nula!";
				return;
			}
	
			$arr_filtru=arrayFromDB("*", "t_filtre", "WHERE id_filtru='".$id_filtru."'");		
			$arr_valori_posibile=explode(";", $arr_filtru[0]["valori_posibile"]);

			$nume_filtru=$arr_filtru[0]["nume_filtru"];
			$nr_valori_posibile=count($arr_valori_posibile)-1;
			
			//@verific daca valoarea nu este deja definita pt aceasta caracteristica
			if(in_array($valoare_noua, $arr_valori_posibile, true) && !$sterge_valoare)
			{
				$this->mesaj[]="Exista deja valoarea \"".$valoare_noua."\" in filtru!";
				return;
			}
					
			//@recontruiesc valorile posibile dupa patternul: ";valoare1;valoare2;etc..;$valoare_noua;etc..;valoareX;
			for($i=1;$i<$nr_valori_posibile;$i++) //incep de la '1' pana la 'count($arr)-1' pt ca prima si ultima valoare rezultata din explode dupa ';' sunt nule
			{
				if($i==$id_val+1)
				{
					(!$sterge_valoare)?$valori_posibile[]=$valoare_noua:"-";						
					$valoare_veche=$arr_valori_posibile[$i];
				}
				else $valori_posibile[]=$arr_valori_posibile[$i];				
			}			
			
			//@fac update la valorile posibile cu noul pattern rezultat mai sus
			if(count($valori_posibile)==0)
				$string_valori_posibile="";
			else $string_valori_posibile=";".implode(";", $valori_posibile).";";
			
			arrayUpdateToDB("t_filtre", array("valori_posibile"), array($string_valori_posibile), array("id"=>"id_filtru", "valoare"=>$id_filtru));

			//@fac update la vechea valoare cu noua valoare, in toate produsele care o foloseau
			$arr_caracteristici=arrayFromDB("*", "t_filtre", "WHERE id_cat='".$this->id_cat."' ORDER BY id_filtru ASC");
			$nr_caracteristici=count($arr_caracteristici);
			
			//@construiesc patternul dupa care identific produsele ce trebuiesc updatate
			for($i=0;$i<$nr_caracteristici;$i++)
			{
				if($arr_caracteristici[$i]["id_filtru"]==$id_filtru)
				{
					$pozitie_filtru=$i;
					$pattern_produse[]=$valoare_veche;					
				}
				else $pattern_produse[]="%";
			}
			
			//@patternul final pt LIKE			
			$pattern_cautare=";".implode(";", $pattern_produse).";"; //@ex: ";%;%;512KB;%;			
			
			//@identific produsele ce trebuiesc updatate la noua valoare din filtru
			$arr_produse_de_modificat=arrayFromDB("*", "t_produse", "WHERE caracteristici LIKE '".$pattern_cautare."' AND id_cat='".$this->id_cat."'");
			$nr_produse_de_modificat=count($arr_produse_de_modificat);
			
			//@patternul pt preg_replace - ex: preg_replace("/;(socketA);*?;*?;*?;/", ";socketB;", $string);
			$pattern_replace="/".str_replace(array($valoare_veche, "%"), array("(".$valoare_veche.")", "*?"), $pattern_cautare)."/";
			
			for($i=0;$i<$nr_produse_de_modificat;$i++)
			{				
				$caracteristici=preg_replace($pattern_replace, ";".(($sterge_valoare)?"-":$valoare_noua).";", $arr_produse_de_modificat[$i]["caracteristici"]);
				
				//@update produs cu noua valoare			
				arrayUpdateToDB("t_produse",
								 array("caracteristici"), array($caracteristici),
								 array("id"=>"id_produs", "valoare"=>$arr_produse_de_modificat[$i]["id_produs"]));			 	
			}
			
			if($sterge_valoare)
				$this->mesaj[]="Valoarea a fost stearsa din filtru si din \"".$nr_produse_de_modificat."\" produse!";
			else
			{
				$this->mesaj[]="Valoarea filtrului \"".$nume_filtru."\" a fost modificata din \"".$valoare_veche."\" in \"".$valoare_noua."\"!";
				$this->mesaj[].="\"".$nr_produse_de_modificat."\" produse au fost actualizate cu noua valoare!";
			}
		}
		
		//@sterge un filtru complet	
		function stergeFiltru($id_filtru)
		{					
			$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat='".$this->id_cat."' ORDER BY id_filtru ASC");	
			$nr_filtre=count($arr_filtre);
				
			
			if($nr_filtre==1 && $arr_filtre[0]["id_filtru"]==$id_filtru)
			{
				arrayDeleteFromDB("t_filtre", array("id_filtru"), array($id_filtru));
				arrayUpdateToDB("t_produse",
								 array("caracteristici"), array(""),
								 array("id"=>"id_cat", "valoare"=>$this->id_cat));
								 
				$nr_produse_de_modificat=mysql_affected_rows();				 
			}
			else
			{
				for($i=0;$i<$nr_filtre;$i++)
				{
					//@mixed pattern
					$arr_mixed_pattern[]="(.*)?";
					
					if($arr_filtre[$i]["id_filtru"]!=$id_filtru)
					{
						//@mixed replacement
						$arr_mixed_replacement[]="\$".($i+1);
					}
				}	
				
				$arr_produse=arrayFromDB(array("id_produs", "caracteristici"), "t_produse", "WHERE id_cat='".$this->id_cat."'");
				$nr_produse_de_modificat=count($arr_produse);
				
				if(count($arr_mixed_pattern)>0)
				{
					$mixed_pattern="/;".implode(";", $arr_mixed_pattern).";/";
					$mixed_replacement=";".implode(";", $arr_mixed_replacement).";";
					
					for($i=0;$i<$nr_produse_de_modificat;$i++)
					{				
						arrayUpdateToDB("t_produse",
										 array("caracteristici"), array(preg_replace($mixed_pattern, $mixed_replacement, $arr_produse[$i]["caracteristici"])),
										 array("id"=>"id_produs", "valoare"=>$arr_produse[$i]["id_produs"]));						
					}
				}
				else 
				{
					for($i=0;$i<$nr_produse_de_modificat;$i++)
					{				
						arrayUpdateToDB("t_produse",
										 array("caracteristici"), array(""),
										 array("id"=>"id_produs", "valoare"=>$arr_produse[$i]["id_produs"]));						
					}
				}
				
				arrayDeleteFromDB("t_filtre", array("id_filtru"), array($id_filtru));
			}
			
			$this->mesaj[]="Caracteristica a fost stearsa !";
			$this->mesaj[]="Caracteristica/Filtru a fost sters din \"".$nr_produse_de_modificat."\" de  produse!";
		}
		
		//@adauga o valoare noua unui filtru dat
		function adaugaValoare($valoare, $id_filtru)
		{
			$valoare=trim(curataString($valoare));			
			
			$arr_filtre=arrayFromDB(array("valori_posibile"), "t_filtre", "WHERE id_filtru='".$id_filtru."'");

			if(strpos($arr_filtre[0]["valori_posibile"], ";".$valoare.";")===false)
			{
				if($arr_filtre[0]["valori_posibile"]=="")
				{
					arrayUpdateToDB("t_filtre",
									 array("valori_posibile"), array(";".$valoare.";"),
									 array("id"=>"id_filtru", "valoare"=>$id_filtru));
				}
				else
				{				 
					arrayUpdateToDB("t_filtre",
									 array("valori_posibile"), array("CONCAT(valori_posibile, '".$valoare.";')"),
									 array("id"=>"id_filtru", "valoare"=>$id_filtru),
									 true);	
				}
								 
				$this->mesaj[]="Valoarea a fost adaugata cu succes in Caracteristica/Filtru";				 			 
			}
			else 
			{						
				$this->mesaj[]="Aceasta valoare exista deja definita in Caracteristica/Filtru!";				 
			}					 
		}
		
		//@intoarce un array cu toate filtrele unei categorii si valorile posibile asociate
		function getFiltre($assoc=false)
		{
			$arr_filtre=arrayFromDB("*", "t_filtre", "WHERE id_cat='".$this->id_cat."' ORDER BY id_filtru ASC");
			$nr_filtre=count($arr_filtre);
			
			for($i=0;$i<$nr_filtre;$i++)
			{
				unset($arr_valori_posibile, $valori_posibile, $nr_valori_posibile);
				
				$arr_valori_posibile=explode(";", $arr_filtre[$i]["valori_posibile"]);
				$nr_valori_posibile=count($arr_valori_posibile)-1;
				
				for($j=1;$j<$nr_valori_posibile;$j++) //incep de la '1' pana la 'count($arr)-1' pt ca prima si ultima valoare delimitata de ';' sunt nule
				{
					if($assoc)
						$valori_posibile[$arr_valori_posibile[$j]]=$arr_valori_posibile[$j];
					else $valori_posibile[]=$arr_valori_posibile[$j];	
				}
				
				$filtre[]=array("id_filtru"=>$arr_filtre[$i]["id_filtru"],
								"nume_filtru"=>$arr_filtre[$i]["nume_filtru"],
								"afiseaza_filtru"=>$arr_filtre[$i]["afiseaza_filtru"],
								"valori_posibile"=>$valori_posibile);
			}
			
			return $filtre;
		}
		
		//@intoarce mesajele de eroare/confirmare
		function getMesaj()
		{
			return implode("<br />", $this->mesaj);
		}
	}
?>