<?
	/**
	 * Smarty plugin
	 * @package Smarty
	 * @subpackage plugins	 
	 * 
	 * Smarty functie paginare
	 * 
	 * Exemplu:
	 *   {paginare nr_pagini=5 pag=1 url=http://domeniu.ro/pag-::PATTERN_PAGINA::}
	 * 
	 * @author Ciuca Valeriu <vali.ciuca@gmail.com>
	 * @version 1.0
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	
	function smarty_function_paginare($params)
	{
		$nr_pagini=$params["nr_pagini"]; //nr pagini
		$pag=$params["pag"]; //pagina curenta 
		$url=$params["url"]; //url paginare
		
		$interval=6;
		
		if($nr_pagini==0)
			return "";
	
		if($nr_pagini>$interval && $pag<=$nr_pagini && $nr_pagini>($interval+1))
		{
			$limita_inf=$pag-$interval;
			$limita_sup=$pag+$interval;
			
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

		$link_prefix="Pag. <b>".$pag."</b>/".$nr_pagini.": ";
		
		//inainte, inapoi - navigare prin pagini
		($pag>1)?$inapoi="<a href='".str_replace(PATTERN, $pag-1, $url)."' class='pagina' title='Pagina precedenta'><b>&laquo;</b></a>":"";
		($more)?$inainte="<a href='".str_replace(PATTERN, $pag+1, $url)."' class='pagina' title='Pagina urmatoare'><b>&raquo;</b></a>":""; 				   				
		
		//-------------------------------------------------------------------------------------------------------------
		//@loop prin pagini
		for($i=$limita_inf;$i<=$limita_sup;$i++)
		{
    		if($pag==$i)
	 	   		$link.="<font class='pagina_selectata'>[".$i."]</font> ";
	  		else
	    		$link.="<a href='".str_replace(PATTERN, $i, $url)."' class='pagina' title='Pagina ".$i."'>".$i."</a> ";	     		  
   		}
   		//-------------------------------------------------------------------------------------------------------------
			
		return $link_prefix.$inapoi." ".$link." ".$inainte;
	}
?>