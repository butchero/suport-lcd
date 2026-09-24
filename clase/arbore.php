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
		@Class: afla parintii unui nod		
		-vars: $nod
		-functii: getParinti($nod) (returneaza un array numeric cu parintii nodului)
	*/	
	//--------------------------------------------------------------------------------------------------------------------------
	class parintiNod
	{		
		var $arr_cat=array();
		var $arr_parinti=array();		

		//@aflu parintii nodului
		function getParinti($nod)
		{	
			global $arr_toate_cat_dupa_id;
								
			$row=$arr_toate_cat_dupa_id[$nod];
			
			//pastrez parintii in acest array
			$this->parinti=array();
			
			if($row["id_parinte"]!=0 && is_numeric($row["id_parinte"])) 
			{ 
			   $parinti[]=$row["id_parinte"]; 	       
			   $parinti=array_merge((array)$this->getParinti($row["id_parinte"]), (array)$parinti); 
			} 
			
			//intorc parintii 
			return $parinti; 
		}	
	}
	
	
	//--------------------------------------------------------------------------------------------------------------------------
	/*
		@Class: trece prin nodurile deschise si le stocheaza intr-un array
		-vars: $arr_parinti
		-metode: arbore($nod) (CONSTRUCTOR)
				 parcurgeArbore($id_parinte, $nivel) (functie recursiva care parcurge categoriile doar pe nodurile deschise, obtinute de getParinti())
				 getMeniuri() (apeleaza functia parcurge Arbore pornind la parinte 0, nivel 0,
				 			   si intoarce un array asociativ cu informatii despre categoriiile gasite si nivelul pe care se afla)
				 getParinti() (intoarce un array cu parintii gasiti: ex: array(0=>$id_parinte1, 1=>$id_parinte2, ...)			   
		-note: mosteneste 'class parintiNod'
	*/
	//--------------------------------------------------------------------------------------------------------------------------
	class arbore extends parintiNod 
	{		
		var $meniuri;
		var $nivele_afisate=0;		
		
		//constructor: setez nodul si aflu parintii lui
		function __construct($nod, $nivele_afisate=0, $arr_cat)
		{
			$this->nivele_afisate=$nivele_afisate;
			$this->arr_cat=$arr_cat;
			$this->arr_parinti=$this->getParinti($nod);				
		}
		
		//parcurg arborele si stochez in array-ul meniuri: categoria, link-ul, nivelul pe care este, cat sa indenteze la afisare
		function parcurgeArbore($id_parinte, $nivel)
		{								
			foreach($this->arr_cat as $row) 
		    { 	
		    	if($row["id_parinte"]==$id_parinte && $row["producator"]==0)
		    	{      
			    	$this->meniuri[]=array("id_cat"=>$row["id_cat"],
			    						   "nume_cat"=>$row["nume_cat"], 
			    						   "link_cat"=>URL_BASE.strtolower($row["link_cat"]),
			    						   "link_cat_admin"=>URL_ADMIN."catalog.php?cat=".$row["id_cat"],
			    						   "nivel"=>$nivel,
			    						   "indent"=>str_repeat("&nbsp;&nbsp;", $nivel),
			    						   "nr_produse"=>$row["nr_produse"],
			    						   "activ"=>$row["activ"]);
			    						     
			        if((is_array($this->arr_parinti) && in_array($row['id_cat'], $this->arr_parinti)) || $nivel<$this->nivele_afisate)
			        {      
			       		$this->parcurgeArbore($row['id_cat'], $nivel+1); 
			        }
		    	}
			}
		}
		
		//get array-ul cu meniuri
		function getMeniuri()
		{
			$this->parcurgeArbore(0, 0);
			return $this->meniuri;
		}
		
		//get array-ul cu parinti
		function getParintiGasiti()
		{
			return $this->arr_parinti;
		}		
	}
	
	
	//--------------------------------------------------------------------------------------------------------------------------
	/*
		@Class: genereaza tot arborele de categorii (in mod default) sau pornind de la o categorie in jos, gasind toti copii acesteia
		-vars: $arr_parinti
		-metode: parcurgeArbore($id_parinte, $nivel) (functie recursiva care parcurge toate categoriile, subcategoriile, etc)
				 getArboreComplet() (apeleaza functia parcurgeArbore pornind la parinte 0, nivel 0,
				 			   		 si intoarce un array asociativ cu informatii despre categorie + nivelul pe care se afla)
		
		
	*/
	//--------------------------------------------------------------------------------------------------------------------------
	class arboreComplet
	{		
		var $arr_cat=array();
		var $categorii;
		var $id_parinte;
		var $nivel;
				
		//constructor
		function __construct($id_parinte=0, $nivel=0, $arr_cat)
		{
			$this->id_parinte=$id_parinte;
			$this->nivel=$nivel;
			$this->arr_cat=$arr_cat;
		}
		
		//parcurg arborele si stochez in array-ul meniuri: categoria, link-ul, nivelul pe care este, indentarea pt afisare
		function parcurgeArbore($id_parinte, $nivel)
		{		
			foreach($this->arr_cat as $row) 
		    { 	      
		    	if($row["id_parinte"]==$id_parinte && $row["producator"]==0)
		    	{
			    	$this->categorii[]=array("id_cat"=>$row["id_cat"],
			    						     "nume_cat"=>$row["nume_cat"], 
			    						     "link_cat"=>URL_BASE.strtolower($row["link_cat"]),
			    						     "nivel"=>$nivel,
			    						     "indent"=>str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $nivel),
			    						     "nr_produse"=>$row["nr_produse"],
			    						     "activ"=>$row["activ"]);
			    						     
			       	$this->parcurgeArbore($row['id_cat'], $nivel+1);
		    	} 		        
			}
		}
		
		//get array-ul cu meniuri
		function getArboreComplet()
		{
			$this->parcurgeArbore($this->id_parinte, $this->nivel);
			return $this->categorii;
		}	
	}
?>