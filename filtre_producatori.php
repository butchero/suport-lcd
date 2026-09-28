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
	//@filtru producatori
	if(!isset($filtru))
		$filtru="";

	if(is_array($arr_parinti) && count($arr_parinti)>0)
	{
		$producatori=arrayFromDB(array("DISTINCT(t_produse.id_prod)", "nume_cat", "link_cat"),
								 "t_produse LEFT JOIN t_categorii ON t_produse.id_prod=t_categorii.id_cat",
								 "WHERE t_produse.id_cat='".$id_cat."' AND nume_cat!='' GROUP BY t_produse.id_prod ORDER BY t_categorii.nr_ordine ASC");
		
		$nr_producatori=count($producatori);
								 
		if($nr_producatori>0)						   
			$filtru_producatori[0]=array("nume_prod"=>"Oricare", "link_prod"=>$link_pagina.$filtru);						
		 
		for($i=0;$i<$nr_producatori;$i++)						 
		{
			$filtru_producatori[$i+1]=array("nume_prod"=>prepareStringFromDB($producatori[$i]["nume_cat"]),
											"link_prod"=>$link_pagina."/".prepareLink($producatori[$i]["link_cat"]).$filtru);						
		}				
	}	
?>