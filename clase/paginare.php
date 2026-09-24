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
	//-------------------------------------------------------------------------------------------------------------
	/*
		@Class: paginare		
		- vars: $nume_var_pag = numele variabilei in care e stocata pagina ex: "pag" ; ex: $_GET['pag']
	 		    $sql = stringul SQL folosit pentru a calcula cate inregistrari sunt in baza de date
	 		    $url_link = ex: "fisier.php?pag=--|x|--" ; fac replace in acest string la PATTERN(--|x|--) cu pagina
	 		    $count = daca count este pus pe TRUE se numara inregistrarile cu mysql_num_rows(), altfel, 
	                     pentru a obtinute numarul de inregistrari tb ca SQL-ul ($sql) trimis ca parametru in functie
	                     sa contina sintagma: "SELECT COUNT(*) AS nr ..."
	            $afisari_pe_pag = afisari pe pagina
	            $interval = la ce interval sa afiseze "..." in loc de pagini
	            $limit_start = limita inferioara pentru SELECT * FROM ... LIMIT $limit_start, ...
	            $nr_rezultate = nr total de inregistrari obtinute
	     - metode: paginare() (constructor)  
	     		   doPaginare (returneaza stringul cu pagini, etc)
	     		   getLimitStart() (returneaza variabila $limit_start pt selectul exterior)    
	                    
	 
	*/
	class paginare 
	{	
		var $nume_var_pag;
		var $sql;
		var $url_link;
		var $count=false;
		var $afisari_pe_pag; 
		var $interval=6; 
		var $limit_start=0;
		var $nr_rezultate=0;

        function __construct($nume_var_pag, $sql, $url_link, $afisari_pe_pag=AFISARI_PE_PAG, $count=false)
		{
			$this->nume_var_pag=$nume_var_pag;
			$this->sql=$sql;
			$this->url_link=$url_link;	
			$this->afisari_pe_pag=$afisari_pe_pag;
			$this->count=$count;
		}
		
		function doPaginare()
		{
		    global $mysqli;

			//@get pagina
			if(isset($_GET[$this->nume_var_pag]) && $_GET[$this->nume_var_pag]!="" && is_numeric($_GET[$this->nume_var_pag]))
				$pag=$_GET[$this->nume_var_pag];
			else $pag=1;
	
			//@limita inferioara pentru SELECT * FROM ... LIMIT $limit_start, ...
			$this->limit_start=($pag-1)*$this->afisari_pe_pag;
	
			//@interogare bd
			$result=$mysqli->query($this->sql) or die($this->sql."<br />".$mysqli->error);

            $row=$result->fetch_assoc();

			//@nr total de rezultate (daca count e pe false inseamna ca SQL-ul trimis e de forma: SELECT COUNT(*) AS nr ....)
			(!$this->count)?$this->nr_rezultate=$row["nr"]:$this->nr_rezultate=$result->num_rows;
	
			//@nr pagini
			$nr_pagini=ceil($this->nr_rezultate/$this->afisari_pe_pag);
			
			//@verificare existenta pagina
			if($pag>$nr_pagini && $nr_pagini>0)
				return "Aceasta pagina nu exista!";
			
			//@paginarea efectiva	
			if($nr_pagini>0)
			{
				if($nr_pagini>$interval && $pag<=$nr_pagini && $nr_pagini>($interval+1))
				{
					$limita_inf=$pag-$this->interval;
					$limita_sup=$pag+$this->interval;
					if($limita_inf<=0)
						$limita_inf=1;
					if($limita_sup>$nr_pagini)
						$limita_sup=$nr_pagini;
	
					if($pag!=$nr_pagini)
						$more=true;
					else $more=false;
				}
				else
				{
					$limita_inf=1;
					$limita_sup=$nr_pagini;
					$more=false;
				}
	
				$link_prefix="Pag. <b>$pag</b>/$nr_pagini: ";
				
				//inainte, inapoi - navigare prin pagini
				($pag>1)?$inapoi="<a href='".str_replace(PATTERN, $pag-1, $this->url_link)."' class='pagina' title='Pagina precedenta'><b>&laquo;</b></a>":"";
				($more)?$inainte="<a href='".str_replace(PATTERN, $pag+1, $this->url_link)."' class='pagina' title='Pagina urmatoare'><b>&raquo;</b></a>":""; 				   				
				
				//-------------------------------------------------------------------------------------------------------------
				//@loop prin pagini
				for($i=$limita_inf;$i<=$limita_sup;$i++)
				{
		    		if($pag==$i)
			 	   	  $link.="<font class='pagina_selectata'>[".$i."]</font> ";
			  		else
			    	  $link.="<a href='".str_replace(PATTERN, $i, $this->url_link)."' class='pagina' title='Pagina ".$i."'>".$i."</a> ";	     		  
		   		}
		   		//-------------------------------------------------------------------------------------------------------------
	   			
				return $link_prefix.$inapoi." ".$link." ".$inainte;
			}
			else
			{
				return "";
			}
		}
		
		function getLimitStart()
		{
			return $this->limit_start;
		}
		
		function getNrRezultate()
		{
			return $this->nr_rezultate;
		}
	}
?>